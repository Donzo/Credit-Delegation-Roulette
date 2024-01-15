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
	function clearCover(){
		
		var leaving = document.getElementById("coverAll");
		var coming1 = document.getElementById("header");
		var coming2 = document.getElementById("introduction");	
		
		//Page 2
		if (window['userAccountNumber'] && theGameID){
			coming1 = document.getElementById("thin-header");
			coming2 = document.getElementById("step-2");
			//Set Connected Address
			document.getElementById("connected-as-address-02").innerHTML = window['userAccountNumber'];
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
		const accounts = await ethereum.request({method: 'eth_accounts'});	   
		if (theGameID){
			getGameData(theGameID);
		}
		if (accounts.length) {
			console.log(`You're connected to: ${accounts[0]}`);
			window['userAccountNumber'] = accounts[0];
			clearCover();
			if (theGameID){
				document.getElementById("coverAll").style.display = "block";
			}
		}
		else{
			console.log("Metamask is not connected");
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
</script>