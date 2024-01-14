<script>
	var playerCount = 2;
	var transactionValue = 100; 
	var pymntAddress = false;
	var properAddress = true;
	
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
	function poof(){
		var header = document.getElementById('header');
		var thinHeader = document.getElementById('thin-header');

		poofGone('header', 'thin-header', true);
		poofGone('introduction', 'step-1');
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
	function appear(e, noBlock){
		//Overwrites the entire classname.
		if (noBlock){
			e.className = "visible-no-block";
		}
		else{
			e.className = "visible";
		}
	}
	function initalizeGame(){
		alert('go!')
	}
	
</script>