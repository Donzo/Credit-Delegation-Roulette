<script>
		
		//Function To Set Initial Parameters of the Game in the Smartcontract
		async function initalizeGame(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});
			
			var tValue = processNumberForContract(transactionValue);
			
			//Use CCIP if the Box is Checked
			if (document.getElementById("ccipCheckBox").checked){
				ccipTransfer = true;
			}		
			
			
			await contract.methods.initGameSettings(playerCount, tValue, pymntAddress, ccipTransfer ).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				popMiningBox(1, hash);
			}).on('receipt', function(receipt){
				if (receipt.events.GameSettingInit && receipt.events.GameSettingInit.returnValues){ //GameSettingInit contract name
					newGMID = receipt.events.GameSettingInit.returnValues.gameID;
					popMiningBox(2, receipt);
					setTimeout("reloadPage()", 3000); //Reload Page
				}
			}).on('error', console.error);
		}
		
		//If user is on Step 2 of the game,
		//There will be a URL parameter "gameID"
		//This is used to retrieve mapped values from the game contract.
		//There values are then loaded into the web page.
		async function getGameData(gID){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});
			
			//Is game already done?
			var reqFulfilled = await contract.methods.reqFulfilled(gID).call();			
			//Has request been made?
			var reqMade = await contract.methods.gameToReqID(gID).call();			
			//Player Number
			playerCount = await contract.methods.game_pCount(gID).call();
			//Game Value
			transactionValue = await contract.methods.game_value(gID).call();
			transactionValue = processNumberForDisplay(transactionValue)
			//Payment Address
			pymntAddress = await contract.methods.pymt_add(gID).call();
			
			lookForPlayers(gID);
			setGameDescDiv();
			setPlayerStatusDiv();
			
			//We also set an Interval Function
			//To look for new players every 15 seconds 
			var lookForPlayersInterval = setInterval(async function(){
				var allPlayersReady = await lookForPlayers(theGameID);
				if (allPlayersReady){
					clearInterval(lookForPlayersInterval);
					document.getElementById("ready-player-button").innerHTML = "Play Game";
					document.getElementById("ready-player-button").disabled = false;
					document.getElementById("pStatusHdrTxt").innerHTML = "<strong>Players Ready!</strong>";
					
					//All players ready. Start checking if the game has been started by another player
					if (!didGameEnd){ //Dont start this if game is already over
						checkGameStartedInterval = setInterval(async function() {
							let gameStarted = await contract.methods.gameStarted(gID).call();
							if (gameStarted && !gameOver) {
								clearInterval(checkGameStartedInterval);
								popMiningBox(13);
								poofGone('step-2', 'step-3');
								//Start checking if the game has finished
								checkGameFinishedInterval = setInterval(async function() {
									let gameFinished = await contract.methods.reqFulfilled(gID).call();
									if (gameFinished) {
										clearInterval(checkGameFinishedInterval);
										gameOver = true;
										getEndGameData(theGameID);
									}
								}, 15000);
		        	    	}
        				}, 15000);
					}	
				}
				else{
					console.log("Waiting on players...");
				}
					
			}, 15000);
			
		}
		
		//Called from Step2 Button, 
		//Begins series of checks to verify player can fulfill obligations.
		async function checkPlayer(){
			getUserMaxCredit();
		}
		
		//Part of obligation checks.
		async function getUserDelgationAmount(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi2, aGhoDebtTokenContractAddress, {});
			
			var delegatedAmount = await contract.methods.borrowAllowance(window['userAccountNumber'], gameContractAddress).call();
			delegatedAmountBN = web3.utils.toBN(delegatedAmount);
			var tValue = makeRegularNumberHave18DecimalPlaces(transactionValue);
			tValue = web3.utils.toBN(tValue);
			
			//If user has delegated LESS to this contract than required, request credit delegation.
			if (delegatedAmount < tValue){
				popConfirm(5); // Prompt Credit Delegation
			}
			else{
				joinGame();
			}
		}
		
		//Part of obligation checks.
		async function getUserMaxCredit(){
			
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi3, aavePoolContractAddress, {});
			
			//Max Credit Power? (based on collateral)
			var usrAcctData = await contract.methods.getUserAccountData(window['userAccountNumber']).call();
			userMaxCredit = usrAcctData.availableBorrowsBase;
			var scTValue = processNumberForContract(transactionValue);
			//User Has Enough Collateral
			if (parseFloat(userMaxCredit) > parseFloat(scTValue)){
				//Step 2 - Check to see contract has been delegated appropriate amount
				getUserDelgationAmount();
			}
			//Prompt a Collateral Deposit
			else{
				popConfirm(4);
			}
			
		}
		
		//Part of obligation checks.
		async function approveBorrowingDelegation(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi2, aGhoDebtTokenContractAddress, {});
			
			var tValue = makeRegularNumberHave18DecimalPlaces(transactionValue);

			await contract.methods.approveDelegation(gameContractAddress, tValue).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				popMiningBox(3, hash);
			}).on('receipt', function(receipt){
				popMiningBox(4, receipt);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
				popConfirm(6); // Prompt Game Join Transaction
			}).on('error', console.error);
		}
		
		//Deposits ETH into AAVE if user needs more collateral
		async function depositETHintoAAVE(amount){
			if (!amount){
				console.log('no eth sent');
				return;
			}
			var amount = amount.toString();
		    amount	= amount.replace('.', '');
		    amount = amount + '0000000000000000'; // Append zeros

			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi4, wethGatewayContractAddress, {});
			var ethSepoliaAaveTknPoolAddress = "0x5b071b590a59395fE4025A0Ccc1FcC931AAc1830";
			await contract.methods.depositETH(ethSepoliaAaveTknPoolAddress, window['userAccountNumber'], 0).send({
				from: window['userAccountNumber'],
				value: amount
				//value: web3.toWei(1, "ether"), 
			}).on('transactionHash', function(hash){
				myHash = hash;
				popMiningBox(7, hash);
			}).on('receipt', function(receipt){
				popMiningBox(8, receipt);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
				setTimeout("checkPlayer()", 3200); //Try to join again
				
			}).on('error', console.error);
		}
		async function joinGame(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});
			
			var tValue = processNumberForContract(transactionValue);
			
			await contract.methods.readyPlayer(theGameID).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				popMiningBox(5, hash);
			}).on('receipt', function(receipt){
				popMiningBox(6, receipt);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
				
			}).on('error', console.error);
		}
		async function playGame(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});
						
			await contract.methods.startGame(theGameID).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				clearInterval(checkGameStartedInterval); //Clear interval checking if game has started
				popMiningBox(9, hash);
			}).on('receipt', function(receipt){
				if (receipt.events.RequestSent && receipt.events.RequestSent.returnValues){ //GameSettingInit contract name
					closeMiningBoxBox();
					oracleReqID = receipt.events.RequestSent.returnValues.requestId;
					popMiningBox(10, oracleReqID);
					poofGone('step-2', 'step-3');
					checkForGameEnd();
				}
				if (receipt.events.RequestFulfilled && receipt.events.RequestFulfilled.returnValues){ //GameSettingInit contract name
					whichPlayerLost = receipt.events.RequestFulfilled.returnValues.randomNum;
					popMiningBox(12, receipt);
					setTimeout("closeMiningBoxBox()", 3000); //Transition
					showGameResults();
				}
			}).on('error', console.error);
		}
		function checkForGameEnd(){
			
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});
			
			//Start checking if the game has finished
			checkGameFinishedInterval2 = setInterval(async function() {
				
				let gameFinished = await contract.methods.reqFulfilled(theGameID).call();
				if (gameFinished) {
					clearInterval(checkGameFinishedInterval2);
					getEndGameData(theGameID);
				}
			}, 15000);
		}
	</script>