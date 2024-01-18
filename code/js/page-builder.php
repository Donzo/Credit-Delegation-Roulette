<script>
	
	var pCountSlider = document.getElementById("playerCountSlider");
	var playerInt = document.getElementById("playerCountInteger");
	
	var tValueInput = document.getElementById("transaction-value-input");
	var tValueDisp = document.getElementById("tValueDisp");
	
	var pymAddressInput = document.getElementById("payment-address-input");
	var pymAddressDisp = document.getElementById("pymAddressDisp");
	
	pCountSlider.oninput = function() {
		playerInt.innerHTML = this.value;
		playerCount = this.value;
		enableInitButton()
	}
	
	tValueInput.oninput = function() {
		tValueDisp.innerHTML = this.value;
		transactionValue = this.value;
		enableInitButton()
	}
	
	pymAddressInput.oninput = function() {
		goodSymbol = "&nbsp; <span class='bigSymbol'>&check;</span> Address Looks Good!";
		badSymbol = "&nbsp; <span class='bigSymbol'>&#10005</span> &nbsp; Address Won't Work!";
		
		pymntAddress = this.value;
		properAddress = properlyFormattedAddressCheck(pymntAddress);
		if (properAddress){
			pymAddressInput.className = "input-field greenInput";
			pymAddressDisp.className = "centerTxt greenInput";
		}
		else{
			pymAddressInput.className = "input-field redInput";
			pymAddressDisp.className = "centerTxt redInput";
		}
		console.log(properlyFormattedAddressCheck(pymntAddress));
		if (properlyFormattedAddressCheck(pymntAddress)){
			pymAddressDisp.innerHTML = this.value + goodSymbol;
		}
		else{
			pymAddressDisp.innerHTML = this.value + badSymbol;
		}
		enableInitButton()
	}
	function properlyFormattedAddressCheck(address) {
		return (/^(0x){1}[0-9a-fA-F]{40}$/i.test(address));
	}
	function enableInitButton(){
		if (properlyFormattedAddressCheck(pymntAddress) && playerCount >= 2 && playerCount <= 5 && transactionValue > 0){
			document.getElementById("init-game-button").disabled = false;
		}
		else{
			document.getElementById("init-game-button").disabled = true;
		}
	}
	function clearCover(endGame){
		
		var leaving = document.getElementById("coverAll");
		var coming1 = document.getElementById("header");
		var coming2 = document.getElementById("introduction");	
		
		//Page 2
		if (endGame){
			coming1 = document.getElementById("thin-header");
			coming2 = document.getElementById("step-3");
			if (window['userAccountNumber']){
				document.getElementById("connected-as-address-03").innerHTML = window['userAccountNumber'];
			}
			else{
				document.getElementById("connected-as-03").innerHTML = "";
			}
		}
		else if (window['userAccountNumber'] && theGameID){
			coming1 = document.getElementById("thin-header");
			coming2 = document.getElementById("step-2");
			//Set Connected Address
			document.getElementById("connected-as-address-02").innerHTML = window['userAccountNumber'];
			document.getElementById("connected-as-address-03").innerHTML = window['userAccountNumber'];
			//Set Share Link URL
			document.getElementById("linkToGame").innerHTML = window.location.href;
		}			

		leaving.className += " " + "invisible";
		coming1.className = "invisible";
		coming2.className = "invisible";
		
		window.setTimeout(function(){
			appear(coming1, true);
			appear(coming2, true);
			leaving.className += " " + "gone";	
		}, 500);
		
	}
	async function isConnected() {
		var accounts = false;
		
		try {
			accounts = await ethereum.request({method: 'eth_accounts'});
			if (theGameID){
				getGameData(theGameID);
			}
			if (accounts.length) {
				console.log(`You're connected to: ${accounts[0]}`);
				window['userAccountNumber'] = accounts[0];
				if (theGameID){
					document.getElementById("coverAll").style.display = "block";
					didGameEnd = await isGameOver(theGameID);
					if (didGameEnd){
						getEndGameData(theGameID, true);
						clearCover(true);
					}
					else{
						clearCover();
					}
				}
				else{
					clearCover();
				}
			}
			else{
				console.log("Wallet not connected");
				clearCover();
			}
		}
		catch(error){
			console.log("Wallet not connected");
			clearCover();
		}		
	}
	isConnected();

	function agreeToPlay(){
		var checkBox = document.getElementById("agreeToPlayCB");
		var playButton = document.getElementById("lock-player-in-div");
		if (checkBox.checked == true){
			//playButton.style.display = "flex";
			makeAppear("lock-player-button", 1);
		}
		else{
			//playButton.style.display = "none";
			makeDisappear("lock-player-button", 1);
		}
	}	
	function poof(){
		var header = document.getElementById('header');
		var thinHeader = document.getElementById('thin-header');

		poofGone('header', 'thin-header', true);
		if (theGameID){
			poofGone('introduction', 'step-2');
		}
		else{
			poofGone('introduction', 'step-1');	
		}
		
		if (theGameID){
			getGameData(theGameID);
			//Set Share Link URL
			document.getElementById("linkToGame").innerHTML = window.location.href;
		}
		
	}
	function makeAppear(id, which){
		var thing = document.getElementById(id);
		if (which == 1){ //Large Buttons
			thing.className = "invisible button largeButton";
		}
		else{
			thing.className = "invisible";
		}
		window.setTimeout(function(){ 
			appear(thing, false, 1);		
		}, 500);
	}
	function makeDisappear(id, which){
		var thing = document.getElementById(id);
		if (which == 1){ //Large Buttons
			thing.className = "invisible button largeButton";
		}
		else{
			thing.className += " " + "invisible";
		}
		window.setTimeout(function(){ 
			thing.className += " " + "gone";	
		}, 500);
	}
	function poofGone(eID, neID, noBlock){
		var leaving = document.getElementById(eID);
		var coming = document.getElementById(neID);	
		
		leaving.className += " " + "invisible";
		if (noBlock){
			coming.className = "invisible-no-block";
		}
		else{
			coming.className = "invisible";
		}
		window.setTimeout(function(){ 
			leaving.className += " " + "gone";	
			if (noBlock){
				appear(coming, true);
				document.getElementById('thin-header').style.position = "sticky";
			}
			else{
				appear(coming);	
			}
			
		}, 500);
		
	}
	function appear(e, noBlock, which){
		//Overwrites the entire classname.
		if (which == 1){
			e.className = "visible button largeButton";
		}
		else if (noBlock){
			e.className = "visible-no-block";
		}
		else{
			e.className = "visible";
		}
	}
	//Allow players to copy game link by clicking DIV
	function copyGameLinkToClipboard() {
		//Get the text from the linkToGame div
		var gameLinkText = document.getElementById('linkToGame').innerText;

		//Create a temporary textarea element
		var tempTextArea = document.createElement('textarea');
		tempTextArea.value = gameLinkText;
		document.body.appendChild(tempTextArea);

		//Select the text in the textarea
		tempTextArea.select();
		tempTextArea.setSelectionRange(0, 99999); //For mobile devices

		//Copy the text inside the textarea to the clipboard
		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			console.log('Copying text command was ' + msg);
			document.getElementById('copy-status').style.color = "green";
			document.getElementById('copy-status').innerHTML = "Copied Successfully!"
			setTimeout("clearCopyStatusField()", 3000);
		}
		catch (err) {
			document.getElementById('copy-status').style.color = "red";
			document.getElementById('copy-status').innerHTML = "Failed to copy :(";
			setTimeout("clearCopyStatusField()", 3000);
		}

		//Remove the temporary textarea
		document.body.removeChild(tempTextArea);
	}
	function clearCopyStatusField(){
		document.getElementById('copy-status').innerHTML = "&nbsp;";
	}
	//Add event listener to the div for click event
	document.getElementById('gameLinkShareBox').addEventListener('click', copyGameLinkToClipboard);
	
	function setGameDescDiv(){
			if (didGameEnd){
				getEndGameData(theGameID, true);
			}
			var againstThisMany = playerCount - 1;
			document.getElementById('tb-pCount').innerHTML = againstThisMany;
			document.getElementById('tb-tAmount').innerHTML = transactionValue;
			document.getElementById('tb-dAddress').innerHTML = pymntAddress;
			if (document.getElementById('tb-tAmount-02')){
				document.getElementById('tb-tAmount-02').innerHTML = transactionValue;
			}
			if (document.getElementById('tb-dAddress-02')){
				document.getElementById('tb-dAddress-02').innerHTML = pymntAddress;
			}		
			var pymntAddressLink = `<a href="https://sepolia.etherscan.io/address/${pymntAddress}" target="_blank">${pymntAddress}</a>`;
			
			document.getElementById('payment-address-span').innerHTML = pymntAddressLink;
			if (document.getElementById('payment-address-span-02')){
				document.getElementById('payment-address-span-02').innerHTML = pymntAddressLink;
			}
			
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
		/*8 decimals*/
		function processNumberForContract(num){
			var numParts = num.toString().split('.');

			var zerosToAdd;

			if (!numParts[1]) {
				zerosToAdd = 8;
			}
			else if (numParts[1].length === 1) {
				num = num * 10;
				zerosToAdd = 7;
			}
			else{
				num = Math.floor(num * 100) / 100;
				zerosToAdd = 6;
			}
			if (numParts[1]) {
				var noDecimal = Math.floor(num * 100);
				num = noDecimal;
			}

			var addedZeros = num * Math.pow(10, zerosToAdd);

			var resultStr = addedZeros.toString();
			console.log('resultStr = ' + resultStr)
			return resultStr;
		}

		//Turn 8 decimal smart contract returned values back into human readable money values
		function processNumberForDisplay(num){
			if (isNaN(num)){
				console.error("Invalid input: not a number");
				return null;
			}

			var numStr = num.toString();

			var requiredLength = numStr.length >= 8 ? numStr.length : 8;
			numStr = numStr.padStart(requiredLength, '0');

			var decimalPosition = numStr.length - 8;
			var withDecimal = numStr.slice(0, decimalPosition) + "." + numStr.slice(decimalPosition);

			var number = parseFloat(withDecimal);
			var formattedNumber;

			if (number <= 0.01){
				formattedNumber = number.toString();
			}
			else{
				formattedNumber = number.toFixed(2);
			}
			return formattedNumber;
		}
		function makeRegularNumberHave18DecimalPlaces(num){
			var numParts = num.toString().split('.');
	
			var zerosToAdd;
			if (!numParts[1]){
				num = num * 100;
				zerosToAdd = 16;
			}
			else if (numParts[1].length === 1){
				num = num * 10;
				zerosToAdd = 17;
			}
			else{
				num = Math.floor(num * 100) / 100;
				zerosToAdd = 16;
			}

			var noDecimal = Math.floor(num * 100);

			var addedZeros = noDecimal * Math.pow(10, zerosToAdd);

			var resultStr = addedZeros.toString();
			//resultStr = resultStr.split('.').join("");
			return resultStr;
		}
		async function lookForPlayers(gID){
						  
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});

			//Player 1 Ready
			if (!p1Ready && playerCount > 0){
				p1Ready = await contract.methods.p1_signed(gID).call();
				console.log("p1ready: ", p1Ready);
			}
			
			//Player 2 Ready
			if (!p2Ready && playerCount > 1){
				p2Ready = await contract.methods.p2_signed(gID).call();
				console.log("p2ready: ", p2Ready);
			}
			
			//Player 3 Ready
			if (!p3Ready && playerCount > 2){
				p3Ready = await contract.methods.p3_signed(gID).call();
				console.log("p3ready: ", p3Ready);
			}
			
			//Player 4 Ready
			if (!p4Ready && playerCount > 3){
				p4Ready = await contract.methods.p4_signed(gID).call();
				console.log("p4ready: ", p4Ready);
			}
			
			//Player 5 Ready
			if (!p5Ready && playerCount > 4){
				p5Ready = await contract.methods.p5_signed(gID).call();
				console.log("p5ready: ", p5Ready);
			}
			
			
			var allPlayersReady = p1Ready && (playerCount <= 1 || p2Ready) && 
				(playerCount <= 2 || p3Ready) && 
				(playerCount <= 3 || p4Ready) && 
				(playerCount <= 4 || p5Ready);
			
			setPlayerStatusDiv();
			
			return allPlayersReady;
		}
		function showGameResults(){
			document.getElementById('gStatusHdrTxt').innerHTML = "<span style='font-weight:700'>Game Over</span>";
			document.getElementById('gameResultsHdr').innerHTML = `Player ${whichPlayerLost} Lost`;
			document.getElementById('gResultsBody').innerHTML = `${playerCount} players wagered to see who would send $${transactionValue} to address <a href='https://sepolia.etherscan.io/address/${pymntAddress}' target='_blank'>${pymntAddress}</a>.<br/><br/>Player ${whichPlayerLost} lost the wager and has borrowed that value in GHO against their collateral on AAVE.<br><br/><strong>Thank you! Play again soon.</strong>`;
			document.getElementById('step-3-title-div').innerHTML = "<h2>Game Over</h2>";
			document.getElementById('game-desc-txt').innerHTML =`
			
					<div class="centerTxt"><strong>Game Has Ended</strong></div>
					<div>
						Player ${whichPlayerLost} lost this game and borrowed ${transactionValue} in GHO then transfered it to <a href='https://sepolia.etherscan.io/address/${pymntAddress}' target='_blank'>${pymntAddress}</a>.
					</div>`;			
		}
		async function isGameOver(gID){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});

			var hasGameEnded = await contract.methods.reqFulfilled(gID).call();
			return hasGameEnded;
		}
		async function getEndGameData(gID, dontShowMiningBox){
			let web3 = new Web3(Web3.givenProvider);
			var contract = new web3.eth.Contract(abi1, gameContractAddress, {});

			whichPlayerLost = await contract.methods.randNumb(gID).call();
			showGameResults();
			if (dontShowMiningBox){
			
			}
			else{
				popMiningBox(14);
				setTimeout("closeMiningBoxBox()", 3000); //Close Mining Box
			}
		}
		function reloadPage(){
			if (newGMID){
				window.location.href = "https://cdroulette.com/?gameID=" + newGMID;
			}
		}
	
</script>