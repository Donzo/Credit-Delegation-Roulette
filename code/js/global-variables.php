<script>
		var theGameID = false; //Used by Page Change Handler
		
		//Used by Page Builder
		var playerCount = 2;
		var transactionValue = 100; 
		var pymntAddress = false;
		var properAddress = true;
		var newGMID = false;
		var userMaxCredit = 0;
		var checkGameStartedInterval = false;
		var didGameEnd = false;
		var checkGameFinishedInterval = false;
		var gameOver = false;
		
		//Contract Addresses
		var gameContractAddress = "0x40f0aFC1A72e8e0542D98f19e35Cb310D281C1df";
		var aavePoolContractAddress = "0x6Ae43d3271ff6888e7Fc43Fd7321a503ff738951";
		var aGhoDebtTokenContractAddress = "0x67ae46EF043F7A4508BD1d6B94DB6c33F0915844";
		var wethGatewayContractAddress = "0x387d311e47e80b498169e6fb51d3193167d89F7D";
		
		//Wallet Connection Variables
		var onPreferredNetwork = false;
		var preferredNetwork1 = "Ethereum Sepolia Testnet";
		var preferredNetworkChainID = "0xaa36a7";
		var preferredNetworkSwitchCode = 9;
		var preferredProviderNumber = 11155111;
		var chain = false;
		var chainId = false;
		
		//Step 2 Player Status 
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
		
		//Oracle Variables
		var oracleReqID = false;
		var oracleGMID = false;
		var whichPlayerLost = false;
		
	</script>