<script>
	function popAlert(which){
		setAlertMsg(which);
		showAlertBox();
	}
	function popConfirm(which){
		setConfirmMsg(which);
		showConfirmBox();
	}
	function popMiningBox(which, data){
		setMiningBoxMsg(which, data);
		showMiningBoxBox();
	}
	//These Control Visibility of System Message Boxes
	function showAlertBox(){
		document.getElementById("sysMsgBoxBG").style.display = "block";
		document.getElementById("alertBox").style.display = "block";
	}
	function closeAlert(){
		document.getElementById("sysMsgBoxBG").style.display = "none";
		document.getElementById("alertBox").style.display = "none";
	}
	function showConfirmBox(){
		document.getElementById("sysMsgBoxBG").style.display = "block";
		document.getElementById("confirmBox").style.display = "block";
	}
	function closeConfirm(which){
		document.getElementById("sysMsgBoxBG").style.display = "none";
		document.getElementById("confirmBox").style.display = "none";
		if (which == 2){
			//Switch Network to Sepolia
			switchNetwork(9);
		}
		else if (which == 3){
			//Decline Network Change
			popAlert(4)
		}
		else if (which == 4){
			//Add Sepolia
			switchNetwork(9);
		}
	}
	function showMiningBoxBox(){
		document.getElementById("sysMsgBoxBG").style.display = "block";
		document.getElementById("miningInfoBox").style.display = "block";
	}
	function closeMiningBoxBox(){
		document.getElementById("sysMsgBoxBG").style.display = "none";
		document.getElementById("miningInfoBox").style.display = "none";
	}
	//setTimeout("closeMiningBoxBox()", 3000); //Close mining box after 3 seconds.
	
	function hideLoadingWheel(){
		document.getElementById("miningInfoLoadingWheel").style.display = "none";;
	}
	function showLoadingWheel(){
		document.getElementById("miningInfoLoadingWheel").style.display = "block";;
	}
	
	
	//These Control Messages and Button Actions
	function setAlertMsg(num){
		var title = document.getElementById("alertBoxTitle");
		var body = document.getElementById("alertBoxBody");
		var button = document.getElementById("sysAlertButtonDiv");
		
		// Default is to close alert but we can set it to other things too.		
		button.innerHTML = `<button class='button sysMsgButton' onclick="closeAlert()">OK</button>`;

		if (num == 1){
			title.innerHTML = "Alert 1 Called";
			body.innerHTML = "Alert 1 has been called. Now that alert 1 has been called blah blah blah.";
		}
		//You rejected the request to connect.
		else if (num == 2){
			title.innerHTML = "Connection Failed";
			body.innerHTML = "You rejected the request to connect.";
		}
		//Request Already Pending
		else if (num == 3){
			title.innerHTML = "Connection Waiting";
			body.innerHTML = "You already have a pending connection request. Check your wallet.";
		}
		//Network Change Declined
		else if (num == 4){
			title.innerHTML = "Network Change Declined";
			body.innerHTML = "That's fine, but you need to be on Sepolia to use this Dapp.";
		}
		else if (num == 5){
			title.innerHTML = "Network Connection Failed";
			body.innerHTML = `You rejected the request to change the network. You must switch to the ${preferredNetwork1} to use this Dapp.`;
		}
		//Request Already Pending
		else if (num == 6){
			title.innerHTML = "Request Waiting";
			body.innerHTML = "You already have a pending network change request. Check your wallet.";
		}
	}
	function setConfirmMsg(num){
		var title = document.getElementById("confirmBoxTitle");
		var body = document.getElementById("confirmBoxBody");
		var button = document.getElementById("sysConfirmButtonDiv");
		
		// Default is to close alert but we can set it to other things too.		
		button.innerHTML = `<button class='button sysMsgButton' onclick="closeConfirm(1)">Yes</button><button class='button sysMsgButton' onclick="closeConfirm(1)">No</button>`;

		if (num == 1){
			title.innerHTML = "Confirm 1 Called";
			body.innerHTML = "Confirm 1 has been called. Now that confirm 1 has been called blah blah blah.";
		}
		else if (num == 2){
			title.innerHTML = "Change Network?";
			body.innerHTML = `You must be on the ${preferredNetwork1} to your to play this game. Would you like to switch to Sepolia now?`;
			button.innerHTML = `<button class='button sysMsgButton' onclick="closeConfirm(2)">Yes</button><button class='button sysMsgButton' onclick="closeConfirm(3)">No</button>`;
		}
		else if (num == 3){
			title.innerHTML = "Add Network?";
			body.innerHTML = `You must add the ${preferredNetwork1} to your wallet to play this game. Would you like to do that now?`;
			button.innerHTML = `<button class='button sysMsgButton' onclick="closeConfirm(4)">Yes</button><button class='button sysMsgButton' onclick="closeConfirm(3)">No</button>`;
		}
	}
	function setMiningBoxMsg(num, data){
		var title = document.getElementById("miningInfoBoxTitle");
		var body = document.getElementById("miningInfomBoxBody");
		var loadingWheel = document.getElementById("miningInfoLoadingWheelDiv");
		var loader = `<img src="/images/loading.gif"/>`
		var loaded = `<img src="/images/check-mark.gif"/>`
		if (num == 1){
			title.innerHTML = "Initializing Game Settings";
			var slicedObj = data.slice(0, 10);
			slicedObj += "...";
			var link = "https://sepolia.etherscan.io/tx/" + data;
			body.innerHTML = `You are now setting up the game. The game contract will hold the number of players, the value of the game, and the destination address of the payment. <br/><br/>Transaction <a href='${link}' target='_blank'>${slicedObj}</a> is mining.`;
			loadingWheel.innerHTML = loader;
		}
		else if (num == 2){
			var slicedObj = data.blockHash.slice(0, 10);
			slicedObj += "...";
			var link = "https://sepolia.etherscan.io/tx/" + data.blockHash;
			title.innerHTML = "Game Settings Initialized";
			body.innerHTML = `This game has now been created.<br/><br/>Transaction <a href='${link}' target='_blank'>${slicedObj}</a> SUCCESSFULLY MINED!`;
			loadingWheel.innerHTML = loaded;
		}
		else if (num == 3){
			title.innerHTML = "Approving Credit Delegation";
			var slicedObj = data.slice(0, 10);
			slicedObj += "...";
			var link = "https://sepolia.etherscan.io/tx/" + data;
			body.innerHTML = `Game contract must be able to borrow $$[transactionValue} against your collateral in the event you lose the game.<br/><br/>Transaction <a href='${link}' target='_blank'>${slicedObj}</a> is mining.`;
			loadingWheel.innerHTML = loader;
		}
		else if (num == 4){
			var slicedObj = data.blockHash.slice(0, 10);
			slicedObj += "...";
			var link = "https://sepolia.etherscan.io/tx/" + data.blockHash;
			title.innerHTML = "Credit Delegation Successful!";
			body.innerHTML = `Transaction <a href='${link}' target='_blank'>${slicedObj}</a> successfully mined!<br/><br/>You have delegated your borrowing power to the game contract. You are ready to play the game.`;
			loadingWheel.innerHTML = loaded;
		}
		else if (num == 5){
			title.innerHTML = "Joining Game";
			var slicedObj = data.slice(0, 10);
			slicedObj += "...";
			var link = "https://sepolia.etherscan.io/tx/" + data;
			body.innerHTML = `You are now joining the game. Once all the players have joined, we can determine the results.<br/><br/>Transaction <a href='${link}' target='_blank'>${slicedObj}</a> is mining.`;
			loadingWheel.innerHTML = loader;
		}
		else if (num == 6){
			var slicedObj = data.blockHash.slice(0, 10);
			slicedObj += "...";
			var link = "https://sepolia.etherscan.io/tx/" + data.blockHash;
			title.innerHTML = "Game Joined!";
			body.innerHTML = `You have now joined the game.<br/><br/>Transaction <a href='${link}' target='_blank'>${slicedObj}</a> successfully mined!`;
			loadingWheel.innerHTML = loaded;
		}
	}
</script>