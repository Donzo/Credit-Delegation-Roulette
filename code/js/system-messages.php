<script>
	function popAlert(which){
		setAlertMsg(which);
		showAlertBox();
	}
	function popConfirm(which){
		setConfirmMsg(which);
		showConfirmBox();
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
</script>