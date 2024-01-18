<head>
	<title>Credit Delegation Roulette | An AAVE Powered Payment Game</title>
		
		<?php
			require_once $_SERVER['DOCUMENT_ROOT'] . "/code/html/metatags.php";
			require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/global-variables.php";
		?>

		
		<?php
			// STYLES
			require_once $_SERVER['DOCUMENT_ROOT'] . "/code/css/inter.php";
			require_once $_SERVER['DOCUMENT_ROOT'] . "/code/css/style.php";
		?>
	<script>
		<?php
			// WEB3JS INTERFACE CODE
			require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/web3js/web3.min.js";
		?>
	</script>
	
</head>

<body>
	<div id="coverAll"></div>
	<?php
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/page-change-handler.php"; //Handles Refreshes on Loads...
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/html/banner.php";
	?>
	<div id="content">
		
		<div id="introduction" class="gone">
			
			<h1 id="page-title-01">Credit Delegation Roulette</h1>
			
			<div id="intro-txt" class="text-box-white">
			
				<div class="txt-box-heading"><strong>Credit Delegation Roulette</strong></div>
			
				A modern variation of credit card roulette using smart contracts, the AAVE protocol, and Chainlink oracles to generate provably fair results.
		
			</div>
			
			<div class="underline-here">
				&nbsp;
			</div>
			
			<h3>Connect Your Wallet To Begin</h3>
			<div id="connect-button-div">
				<button class="button largeButton" onclick="connectMyWallet()">CONNECT WALLET</button>
				<!--button class="button largeButton" onclick="poof()">POOF</button-->
			</div>
			
		</div>
				
		<!--div id="connect-button-div">
			<button class="button" onclick="connectMyWallet()">BUTTON</button>
			<button class="button" onclick="makeAlert()">ALERT</button>
			<button class="button" onclick="makeConfirm()">CONFIRM</button>
		</div-->
		
		<div id="interface">
			<?php
				require_once $_SERVER['DOCUMENT_ROOT'] . "/code/html/step-01.php";
				require_once $_SERVER['DOCUMENT_ROOT'] . "/code/html/step-02.php";
				require_once $_SERVER['DOCUMENT_ROOT'] . "/code/html/step-03.php";
			?>	
		</div>
	</div>
	<?php
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/html/system-messages.php";
	?>	
</body>

<footer>
	<?php 
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/abi-01.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/abi-02.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/abi-03.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/abi-04.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/contract-functions.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/page-builder.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/wallet-connect.php";
		require_once $_SERVER['DOCUMENT_ROOT'] . "/code/js/system-messages.php";
	?>
</footer>