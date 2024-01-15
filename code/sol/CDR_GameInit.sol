// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

interface AavePoolInterace {
    function getUserAccountData(address) external returns (uint256, uint256, uint256, uint256, uint256, uint256);
    //totalCollateralBase, totalDebtBase, availableBorrowsBase, currentLiquidationThreshold, ltv, healthFactor
    function borrow(address, uint256, uint256, uint16, address) external;
    //asset, amount, interestRateMode, referralCode, onBehalfOf
}


contract CDR_GameInit{

    event GameSettingInit(uint256 gameID);

    uint256 public gameID = 0;
    uint256 public lastGameID;
    uint8 public pCount; //Number of Players
    uint256 public vrfRequestID;
    address internal msgSender;

	//Mapped Game Data
    mapping(uint256 => uint256) public game_value;
    mapping(uint256 => uint8) public game_pCount;
    mapping(uint256 => address) public pymt_add;
    mapping(uint256 => address) public p1_add;
    mapping(uint256 => bool) public p1_signed;
    mapping(uint256 => address) public p2_add;
    mapping(uint256 => bool) public p2_signed;
    mapping(uint256 => address) public p3_add;
    mapping(uint256 => bool) public p3_signed;
    mapping(uint256 => address) public p4_add;
    mapping(uint256 => bool) public p4_signed;
    mapping(uint256 => address) public p5_add;
    mapping(uint256 => bool) public p5_signed;
    mapping(uint256 => bool) public gameReady;
    mapping(uint256 => uint256) public randNumb;
    mapping(uint256 => uint256) public gameToReqID;
    mapping(uint256 => uint256) public reqIDToGame;
    mapping(uint256 => bool) public reqFulfilled;

    //Address Aave Pool (for borrowing / minting GHO)
    address aavePoolAddABI = 0x6Ae43d3271ff6888e7Fc43Fd7321a503ff738951;
    AavePoolInterace aavePool = AavePoolInterace(aavePoolAddABI);
    

    function initGameSettings(uint8 _pCount, uint256 _game_value, address _pymt_add) public{
        require(_pCount > 1 && _pCount < 6, "Invalid Player Count"); 
        require(_game_value > 0, "Game value must be greater than zero.");
        require(_pymt_add != address(0), "Invalid Payment Address");
        game_value[gameID] = _game_value; //We map the value of the game
        game_pCount[gameID] = _pCount; //And the player count
        pymt_add[gameID] = _pymt_add; //And the payment address
        emit GameSettingInit(gameID); //To the current gameID
        gameID++; //Then increment the gameID so that it doesn't reuse.
	}

    
    
    //This function retrieves the borrowing power of an arbitrary address
    function checkBorrowingPower(address _pAddress) public returns (uint256) {
        (, , uint256 availableBorrowsETH, , , ) = aavePool.getUserAccountData(_pAddress);
        return availableBorrowsETH;
    }


    //Checks Players Into the Game
    function readyPlayer(uint256 _gameID) public{
        //Verify Borrowing Power
        uint256 borrowPower = checkBorrowingPower(msg.sender);
        uint256 gameValue = game_value[_gameID];
        require(borrowPower > gameValue, "Insufficent borrowing power. You must post more collateral to take this bet.");

        //Retrieve Occupied Slots
        uint8 ps = game_pCount[_gameID];
        bool p1_ready = p1_signed[_gameID]; 
        bool p2_ready = p2_signed[_gameID]; 
        bool p3_ready = p3_signed[_gameID]; 
        bool p4_ready = p4_signed[_gameID]; 
        bool p5_ready = p5_signed[_gameID];         

        //Find and Fill Empty Slot
        if (!p1_ready){
           p1_add[_gameID] = msg.sender; 
           p1_signed[_gameID] = true; 
           
        }
        else if (!p2_ready){
            p2_add[_gameID] = msg.sender; 
            p2_signed[_gameID] = true;
            if (ps == 2){
                gameReady[_gameID] = true;
            }
        }
        else if (!p3_ready && ps >= 3){
            p3_add[_gameID] = msg.sender; 
            p3_signed[_gameID] = true;
            if (ps == 3){
                gameReady[_gameID] = true;
            }
        }
        else if (!p4_ready && ps >= 4){
            p4_add[_gameID] = msg.sender; 
            p4_signed[_gameID] = true;
            if (ps == 4){
                gameReady[_gameID] = true;
            }
        }
        else if (!p5_ready && ps >= 5){
            p5_add[_gameID] = msg.sender; 
            p5_signed[_gameID] = true;
            if (ps == 5){
                gameReady[_gameID] = true;
            }
        }
        else{
            revert('No more player slots available.');
        }
    }
}