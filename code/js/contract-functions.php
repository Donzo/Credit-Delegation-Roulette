<script>
		//Player Status IMGS
		var p1NotReadyIMG = "/images/p-ready-imgs/p1-not-ready.png";
		var p1ReadyIMG = "/images/p-ready-imgs/p1-ready.png";
		var p2NotReadyIMG = "/images/p-ready-imgs/p2-not-ready.png";
		var p2ReadyIMG = "/images/p-ready-imgs/p2-ready.png";
		var p3NotReadyIMG = "/images/p-ready-imgs/p3-not-ready.png";
		var p3ReadyIMG = "/images/p-ready-imgs/p3-ready.png";
		var p4NotReadyIMG = "/images/p-ready-imgs/p4-not-ready.png";
		var p4ReadyIMG = "/images/p-ready-imgs/p4-ready.png";
		var p5NotReadyIMG = "/images/p-ready-imgs/p5-not-ready.png";
		var p5ReadyIMG = "/images/p-ready-imgs/p5-ready.png";
		var p1Ready = false;
		var p2Ready = false;
		var p3Ready = false;
		var p4Ready = false;
		var p5Ready = false;
		
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
				if (receipt.events.GameSettingInit && receipt.events.GameSettingInit.returnValues) { //GameSettingInit contract name
					newGMID = receipt.events.GameSettingInit.returnValues.gameID;
					console.log(newGMID);
					popMiningBox(2, receipt);
					setTimeout("reloadPage()", 3000); //Reload Page
				}
			}).on('error', console.error);
		}
		async function joinPlayer(){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi2, aGhoDebtTokenContractAddress, {});
			
			var borrowingPower = await contract.methods.borrowAllowance(window['userAccountNumber'], initGameAddress).call();
			transactionValue;
			console.log('borrowingPower = ' + borrowingPower);
			console.log('transactionValue = ' + transactionValue);
			if (borrowingPower < transactionValue){
				approveBorrowingDelegation();
			}
			else{
				joinGame();
			}
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
				setTimeout("joinPlayer()", 1000); //Join Game
			}).on('error', console.error);
		}
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
			var pAddress = await contract.methods.game_pCount(gID).call();
			console.log("pAddress: ", pAddress);
			
			//Player 1 Ready
			p1Ready = await contract.methods.p1_signed(gID).call();
			console.log("p1ready: ", p1Ready);
			
			//Player 2 Ready
			p2Ready = await contract.methods.p2_signed(gID).call();
			console.log("p2ready: ", p2Ready);
			
			//Player 3 Ready
			p3Ready = await contract.methods.p3_signed(gID).call();
			console.log("p3ready: ", p3Ready);
			
			//Player 1 Ready
			p4Ready = await contract.methods.p4_signed(gID).call();
			console.log("p4ready: ", p4Ready);
			
			//Player 5 Ready
			p5Ready = await contract.methods.p5_signed(gID).call();
			console.log("p5ready: ", p5Ready);
			setGameDescDiv();
			setPlayerStatusDiv();
		}
		function setGameDescDiv(){
			var againstThisMany = playerCount - 1;
			document.getElementById('tb-pCount').innerHTML = againstThisMany;
			document.getElementById('tb-tAmount').innerHTML = transactionValue;
			document.getElementById('tb-dAddress').innerHTML = pAddress;		
		}
		function setPlayerStatusDiv(){

			var p1sIcon = `<div id="p1Status" class="pStatusItem"><img src="${p1NotReadyIMG}"></div>`;
			if (p1Ready){
				p1sIcon = `<div id="p1Status" class="pStatusItem"><img src="${p1ReadyIMG}"></div>`;
			}
			var p2sIcon = `<div id="p2Status" class="pStatusItem"><img src="${p2NotReadyIMG}"></div>`;
			if (p2Ready){
				p2sIcon = `<div id="p2Status" class="pStatusItem"><img src="${p2ReadyIMG}"></div>`;
			}
			var p3sIcon = `<div id="p3Status" class="pStatusItem"><img src="${p3NotReadyIMG}"></div>`;
			if (p3Ready){
				p3sIcon = `<div id="p3Status" class="pStatusItem"><img src="${p3ReadyIMG}"></div>`;
			}
			var p4sIcon = `<div id="p4Status" class="pStatusItem"><img src="${p4NotReadyIMG}"></div>`;
			if (p4Ready){
				p4sIcon= `<div id="p4Status" class="pStatusItem"><img src="${p4ReadyIMG}"></div>`;
			}
			var p5sIcon = `<div id="p5Status" class="pStatusItem"><img src="${p5NotReadyIMG}"></div>`;
			if (p5Ready){
				p5sIcon = `<div id="p5Status" class="pStatusItem"><img src="${p5ReadyIMG}"></div>`;
			}
			
			var stati = p1sIcon + p2sIcon;
			
			if (playerCount > 2){
				stati += p3sIcon;
			}
			if (playerCount > 3){
				stati += p4sIcon;
			}
			if (playerCount > 4){
				stati += p5sIcon;
			}
			document.getElementById('player-status-div').innerHTML = stati;
		}
		function processNumberForContract(num) {

			var numParts = num.toString().split('.');
	
			var zerosToAdd;
			
			if (!numParts[1]) {
				//No decimal place
				num = num * 100;
				zerosToAdd = 16; //Add 16 zeros
			}
			else if (numParts[1].length === 1) {
				//One digit after decimal
				num = num * 10;
				zerosToAdd = 17; //Add 17 zeros
			}
			else{
				num = Math.floor(num * 100) / 100;
				zerosToAdd = 16; //Add 16 zeros
			}

			var noDecimal = Math.floor(num * 100);
			var addedZeros = noDecimal * Math.pow(10, zerosToAdd);
			var resultStr = addedZeros.toString();

			return resultStr;
		}
		function processNumberForDisplay(num) {
			if (isNaN(num)) {
				console.error("Invalid input: not a number");
				return null;
			}

			var numStr = num.toString();

			var requiredLength = numStr.length >= 18 ? numStr.length : 18;
			numStr = numStr.padStart(requiredLength, '0');

			var decimalPosition = numStr.length - 18;
			var withDecimal = numStr.slice(0, decimalPosition) + "." + numStr.slice(decimalPosition);

			var number = parseFloat(withDecimal);
			var formattedNumber;

			if (number <= 0.01) {
				formattedNumber = number.toString();
			}
			else{
				formattedNumber = number.toFixed(2);
			}
			return formattedNumber;
		}

		function reloadPage(){
			if (newGMID){
				window.location.href = "https://cdroulette.com/?gameID=" + newGMID;
			}
		}
	</script>