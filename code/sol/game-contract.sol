// SPDX-License-Identifier: MIT
pragma solidity ^0.8.13;

import "@chainlink/contracts/src/v0.8/interfaces/VRFCoordinatorV2Interface.sol";
import "@chainlink/contracts/src/v0.8/ConfirmedOwner.sol";
import "@chainlink/contracts/src/v0.8/vrf/VRFConsumerBaseV2.sol";

interface GhoTokenInterface {
	function transfer(address, uint) external returns (bool); //to - value
	function allowance(address, address) external returns (uint256); //owner, spender
	function balanceOf(address) external returns (uint256); 
}
interface aGhoTokenInterface {
	function borrowAllowance(address, address) external returns (uint256); //to - value
}
interface AavePoolInterace {
	function getUserAccountData(address) external returns (uint256, uint256, uint256, uint256, uint256, uint256);
	//totalCollateralBase, totalDebtBase, availableBorrowsBase, currentLiquidationThreshold, ltv, healthFactor
	function borrow(address, uint256, uint256, uint16, address) external;
	//asset, amount, interestRateMode, referralCode, onBehalfOf
}
interface LinkTokenInterface {
	function transfer(address, uint) external returns (bool); //to - value
	function allowance(address, address) external returns (uint256); //owner, spender
	function balanceOf(address) external returns (uint256); 
}
interface CCIPInterface {
	function allowlistDestinationChain(uint64, bool) external returns (bool);
	function transferTokensPayLINK(uint64, address, address, uint256) external returns (bytes32); 
	//_destinationChainSelector, _receiver, _token, _amount.  returns messageId
	function transferTokensPayNative(uint64, address, address, uint256) external returns (bytes32);
	function withdraw(address) external; //_beneficiary (withdraws ETH from contract)
	function withdrawToken( address, address) external; //_beneficiary, _token
	function transferOwnership(address) external; //Change owner of CCIP contract
	function acceptOwnership() external;
}

contract CDR_GameContract is VRFConsumerBaseV2, ConfirmedOwner{
	//Events
	event RequestFulfilled(uint256 gameID, uint256 vrfRequestID, uint256 randomNum);
	event RequestSent(uint256 gameID, uint256 requestId);
	event GameSettingInit(uint256 gameID);

	//Global Variables
	uint64 subscriptionID;
	VRFCoordinatorV2Interface COORDINATOR;
	
	uint256 public gameID = 0;
	uint256 public curGameID;
	uint8 public pCount; //Number of Players
	uint256 public vrfRequestID;
	address internal msgSender;

	//Mapped Game Data
	mapping(uint256 => uint256) public game_value;
	mapping(uint256 => uint256) public scaled_value;
	mapping(uint256 => uint8) public game_pCount;
	mapping(uint256 => address) public pymt_add;
	mapping(uint256 => bool) public ccipTransfer;
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
	mapping(uint256 => bool) public gameStarted;
	mapping(uint256 => uint256) public randNumb;
	mapping(uint256 => uint256) public gameToReqID;
	mapping(uint256 => uint256) public reqIDToGame;
	mapping(uint256 => bool) public reqFulfilled;
	mapping(uint256 => bool) public paidOut;
	
	//Borrowing Settings
	uint256[6] public aaveUserAccountData;

	//VRF Settings
	uint32 callbackGasLimit = 2500000;
	uint16 requestConfirmations = 3;
	bytes32 keyHash = 0x474e34a077df58807dbe9c96d3c009b23b3c6d0cce433e59bbf5b34f823bc56c;

	/************ External Contract Addresses and Interface Assignments ************/

	address linkAddress =  0x779877A7B0D9E8603169DdbD7836e478b4624789; //Address LINK - Sepolia Testnet

	//Address and Interface - Aave Pool (for borrowing / minting GHO)
	address aavePoolAddABI = 0x6Ae43d3271ff6888e7Fc43Fd7321a503ff738951;
	AavePoolInterace aavePool = AavePoolInterace(aavePoolAddABI);
	
	//Address and Interface - GHO Token
	address ghoAddress = 0xc4bF5CbDaBE595361438F8c6a187bDc330539c60; //GHO Address
	GhoTokenInterface ghoTkn = GhoTokenInterface(ghoAddress);

	//Address and Interface - GHO Debt Token Address - Sepolia
	address aGhoTknAdd = 0x67ae46EF043F7A4508BD1d6B94DB6c33F0915844;
	aGhoTokenInterface aGhoTkn = aGhoTokenInterface(aGhoTknAdd);

	//Address and Interface - CCIP Sending Contract Address - Sepolia
	address ccipSenderContractAddress = 0xFf9627fE89F32997d65C7CB246a70A36fe56beD5;
	CCIPInterface ccipSender = CCIPInterface(ccipSenderContractAddress);
	
	constructor(uint64 subscriptionId) VRFConsumerBaseV2(0x8103B0A8A00be2DDC778e6e7eaa21791Cd364625) ConfirmedOwner(msg.sender){
		COORDINATOR = VRFCoordinatorV2Interface(
			0x8103B0A8A00be2DDC778e6e7eaa21791Cd364625 //Sepolia Coordinator
		);
		subscriptionID = subscriptionId;
		gameID = 0;
	}

	//This function gathers the conditions we will need to start the game
	//That includes the value of the transaction and the number of players.
	function initGameSettings(uint8 _pCount, uint256 _game_value, address _pymt_add, bool _ccipTransfer) public{
		require(_pCount > 1 && _pCount < 6, "Invalid Player Count"); 
		require(_game_value > 0, "Game value must be greater than zero.");
		require(_pymt_add != address(0), "Invalid Payment Address");
		game_value[gameID] = _game_value; //We map the value of the game
		scaled_value[gameID]  = _game_value * 10**10;
		game_pCount[gameID] = _pCount; //And the player count
		pymt_add[gameID] = _pymt_add; //And the payment address
		ccipTransfer[gameID] = _ccipTransfer; // Map CCIP transfer status
		paidOut[gameID] = false; //Ensure payout bool is false;
		emit GameSettingInit(gameID); //To the current gameID
		gameID++; //Then increment the gameID so that it doesn't reuse.
	}

	//Checks Players Into the Game
	function readyPlayer(uint256 _gameID) public{
		//Verify Borrowing Power
		uint256 borrowPower = checkBorrowingPower(msg.sender);
		uint256 gameValue = game_value[_gameID];
		require(borrowPower > gameValue, "Insufficent borrowing power. You must post more collateral to play this game.");
		uint256 borrowAllow = aGhoTkn.borrowAllowance(msg.sender,address(this));
		require(borrowAllow >= scaled_value[_gameID], "You must delegate more credit to the game contract.");
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
	function startGame(uint256 _gameID) public{
		//Now we have to verify that all the players have the necessary allowances
		//And have signed the necessary delegations to play the game fairly.
		if (gameReady[_gameID] && !gameStarted[_gameID]){
			curGameID = _gameID;
			requestRandomWords();
			gameStarted[_gameID] = true;
		}
	}
	function verifyDelegatedValue(uint8 whichPlayer, uint256 _gameID) public returns (bool) {
		address player;

		if (whichPlayer == 1){
			player = p1_add[_gameID];
		}
		else if (whichPlayer == 2){
			player = p2_add[_gameID];
		}
		else if (whichPlayer == 3){
			player = p3_add[_gameID];
		}
		else if (whichPlayer == 4){
			player = p4_add[_gameID];
		}
		else if (whichPlayer == 5){
			player = p5_add[_gameID];
		}
		uint256 borrowAllow = aGhoTkn.borrowAllowance(player,address(this));
		if (borrowAllow >= scaled_value[_gameID]){			
			return true;
		}
		else{
			return false;
		}
	}
	//This function retrieves the borrowing power of an arbitrary address
	function checkBorrowingPower(address _pAddress) public returns (uint256) {
		(, , uint256 availableBorrowsETH, , , ) = aavePool.getUserAccountData(_pAddress);
		return availableBorrowsETH;
	}
	function requestRandomWords() private returns (uint256 requestId){
		requestId = COORDINATOR.requestRandomWords(keyHash, subscriptionID, requestConfirmations, callbackGasLimit, 1);
		gameToReqID[curGameID] = requestId; //Maps the Game ID to the Request ID
		reqIDToGame[requestId] = curGameID; //Maps the Request ID to the Game Number
		reqFulfilled[curGameID] = false;

		vrfRequestID = requestId; //This can actually be deleted but let's keep it now for debugging if necessary
		emit RequestSent(curGameID, requestId);
		return requestId;
	}

	function fulfillRandomWords(uint256 _requestId, uint256[] memory _randomWords) internal override {
		uint256 _thisGame = reqIDToGame[_requestId]; //Retrieves the Game ID from the Request ID
	   
		require(reqFulfilled[_thisGame] == false, 'request fulfilled already'); //Don't Allow Game to Be Played Twice
		reqFulfilled[_thisGame] = true;
		
		//Map the Random Number to the Game ID
		randNumb[_thisGame] = (_randomWords[0] % game_pCount[_thisGame]) + 1;
		payOut(_thisGame);
		emit RequestFulfilled(_thisGame, _requestId, randNumb[_thisGame]);
	}

	//This function is called by the oracle return, but anyone can call it. 
	//!paidOut[_gameID] prevents double payments.

	function payOut(uint256 _gameID) public{
		bool payIt = false; //Do not payout unless ALL players are still appropriately delegated
		
		bool pO1 = verifyDelegatedValue(1,_gameID); 
		bool pO2 = verifyDelegatedValue(2,_gameID); 
		bool pO3 = true; 
		bool pO4 = true; 
		bool pO5 = true; 

		//Verify these amounts also if the players exist.
		if (game_pCount[_gameID] >= 3){
			pO3 = verifyDelegatedValue(3,_gameID);
		}
		if (game_pCount[_gameID] >= 4){
			pO4 = verifyDelegatedValue(4,_gameID);
		}
		if (game_pCount[_gameID] == 5){
			pO5 = verifyDelegatedValue(5, _gameID);
		}
		//Only Payout the money if all players are still delegating the transaction value.
		if (pO1 && pO2 && pO3 && pO4 && pO5){
			payIt = true;
		}
		else{
			revert('One of the players has not delegated enough value to the game contract.');
		}

		//Get address of the player who will pay
		address payer;
		if (randNumb[_gameID] == 1){
			payer = p1_add[_gameID];
		}
		else if (randNumb[_gameID] == 2){
			payer = p2_add[_gameID];
		}
		else if (randNumb[_gameID] == 3){
			payer = p3_add[_gameID];
		}
		else if (randNumb[_gameID] == 4){
			payer = p4_add[_gameID];
		}
		else if (randNumb[_gameID] == 5){
			payer = p5_add[_gameID];
		}
		
		//Only Enter this function if the oracle has actually determined the winner.
		if (reqFulfilled[_gameID] && !paidOut[_gameID]){
			paidOut[_gameID] = true; //Prevent Double Payments
			aavePool.borrow(ghoAddress, scaled_value[_gameID], 2, 0, payer); //Borrow GHO
			//Use CCIP?
			if (ccipTransfer[_gameID]){ //Yes, use CCIP
				ghoTkn.transfer(ccipSenderContractAddress, scaled_value[_gameID]); //Transfer GHO to Sender Contract
				uint64 arbiSepCS = 3478487238524512106; //Destination Chain Selector (Arbitrum Sepolia)
				ccipSender.transferTokensPayLINK(arbiSepCS, pymt_add[_gameID], ghoAddress, scaled_value[_gameID]); //Then call transfer function on sender contract
			}
			else{
				ghoTkn.transfer(pymt_add[_gameID], scaled_value[_gameID]); //Send GHO to Payment Destination
			}
		}
	}
	//Withdraw Link (From Game Contract)
	function withdrawLink(address _withdrawlAdd) public onlyOwner{
		LinkTokenInterface link = LinkTokenInterface(linkAddress);
		require(link.transfer(_withdrawlAdd, link.balanceOf(address(this))), 'Unable to transfer');
	}

	//Withdraw ETH (From Game Contract)
	//Currently no payable function but you never know. Better safe than sorry.
	function withdrawETH(uint256 amount, address _withdrawlAdd) public onlyOwner{
		address payable to = payable(_withdrawlAdd);
		to.transfer(amount);
	}

	//Transfer Ownership of CCIP Sender Contract
	function ccipSenderTransferOwnership(address _newOwner) public onlyOwner {
		ccipSender.transferOwnership(_newOwner);
	}
	//Accept Ownership of CCIP Sender Contract
	function ccipAcceptOwnership() public onlyOwner {
		ccipSender.acceptOwnership();
	}
	//Add or remove destination chain
	function ccipAddDestinationChain(uint64 _newDest, bool _yayOrNay) public onlyOwner {
		ccipSender.allowlistDestinationChain(_newDest, _yayOrNay);
	}
	//Withdraw ETH (From CCIP Sender Contract)
	function ccipWithdrawETH(address _withdrawlAdd) public onlyOwner{
		ccipSender.withdraw(_withdrawlAdd);
	}
	//Withdraw Token (From CCIP Sender Contract)
	function ccipWithdrawTkn(address _withdrawlAdd, address _tknAdd) public onlyOwner{
		ccipSender.withdrawToken(_withdrawlAdd, _tknAdd);
	}
}