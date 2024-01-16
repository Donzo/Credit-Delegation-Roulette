<script>
		
		//Function To Set Initial Parameters of the Game in the Smartcontract
		async function initalizeGame(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, initGameAddress, {});
			
			var tValue = processNumberForContract(transactionValue);
			
			await contract.methods.initGameSettings(playerCount, tValue, pymntAddress ).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				console.log(hash);
				popMiningBox(1, hash);
			}).on('receipt', function(receipt){
				console.log(receipt);
				if (receipt.events.GameSettingInit && receipt.events.GameSettingInit.returnValues){ //GameSettingInit contract name
					newGMID = receipt.events.GameSettingInit.returnValues.gameID;
					console.log(newGMID);
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
			var contract = new web3.eth.Contract(abi1, initGameAddress, {});
			
			//Is game already done?
			var reqFulfilled = await contract.methods.reqFulfilled(gID).call();
			console.log("reqFulfilled: ", reqFulfilled);
			
			//Has request been made?
			var reqMade = await contract.methods.gameToReqID(gID).call();
			console.log("reqMade: ", reqMade);
			
			//Player Number
			playerCount = await contract.methods.game_pCount(gID).call();
			console.log("playerCount: ", playerCount);
			//Game Value
			transactionValue = await contract.methods.game_value(gID).call();
			transactionValue = processNumberForDisplay(transactionValue)
			console.log("transactionValue: ", transactionValue);
			//Payment Address
			pymntAddress = await contract.methods.pymt_add(gID).call();
			console.log("pymntAddress: " + pymntAddress);
			
			lookForPlayers(gID);
			setGameDescDiv();
			setPlayerStatusDiv();
			
			//We also set an Interval Function
			//To look for new players every 15 seconds 
			var lookForPlayersInterval = setInterval(async function(){
				var allPlayersReady = await lookForPlayers(theGameID);
				if (allPlayersReady){
					clearInterval(lookForPlayersInterval);
					console.log("All players are ready.");
					document.getElementById("ready-player-button").innerHTML = "Play Game";
					document.getElementById("ready-player-button").disabled = false;
					document.getElementById("pStatusHdrTxt").innerHTML = "<strong>Players Ready!</strong>";
					
				}
				else{
					console.log("Waiting on players...");
				}
			}, /*7777*/ 15000);
			
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
			
			var delegatedAmount = await contract.methods.borrowAllowance(window['userAccountNumber'], initGameAddress).call();
			var tValue = processNumberForContract(transactionValue);
			console.log('delegatedAmount = ' + delegatedAmount);
			console.log('tValue = ' + tValue);
			
			//If user has delegated LESS to this contract than required, request credit delegation.
			if (delegatedAmount < tValue){
				approveBorrowingDelegation();
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
			console.log("userMaxCredit = " + userMaxCredit);
			var tValue = processNumberForContract(transactionValue);
			//User Has Enough Collateral
			if (userMaxCredit > tValue){
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
			
			console.log('transactionValue = ' + transactionValue);
			var tValue = processNumberForContract(transactionValue);
			console.log('tValue = ' + tValue);

			await contract.methods.approveDelegation(initGameAddress, tValue).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				console.log(hash);
				popMiningBox(3, hash);
			}).on('receipt', function(receipt){
				console.log(receipt);
				popMiningBox(4, receipt);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
				setTimeout("joinGame()", 1000); //Join Game
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
				console.log(hash);
				popMiningBox(7, hash);
			}).on('receipt', function(receipt){
				popMiningBox(8, receipt);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
				setTimeout("checkPlayer()", 3200); //Try to join again
				
			}).on('error', console.error);
		}
		async function joinGame(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, initGameAddress, {});
			
			var tValue = processNumberForContract(transactionValue);
			
			await contract.methods.readyPlayer(theGameID).send({
				from: window['userAccountNumber'],
			}).on('transactionHash', function(hash){
				myHash = hash;
				console.log(hash);
				popMiningBox(5, hash);
			}).on('receipt', function(receipt){
				popMiningBox(6, receipt);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
				
			}).on('error', console.error);
		}
		
	</script>