<div id="step-1" class="gone">

				<!-- Connected As -->
				<div id="connected-as-01" class="connected-as">Connected As: &nbsp; <span id="connected-as-address-01"></span></div>
				<h1 class="page-title" id="page-title-02">Credit Delegation Roulette</h1>
				
				<!-- Page Heading -->
				<h3>Step 1 of 3</h3>
				<div class="step-num-title-div">
					<h2>Initialize Game Settings</h2>
				</div>
			
				<!-- Player Count -->
				<h3>Set Number of Players</h3>
				<div id="pSliderHeading" class="inputHeading">
					<strong>Number of Players</strong>		
				</div>
			
				<div id="playerSlider">
					<span class="slider-lbl">MIN 2 &nbsp;</span>
					<input type="range" min="2" max="5" value="2" class="slider" id="playerCountSlider">
					<span class="slider-lbl">&nbsp; 5 MAX</span>
				</div>
			
				<div id="playerCountDisp" class="centerTxt">
					<span id="playerCountInteger">2</span> &nbsp; Players
				</div>
				
				<div class="underline-here">
					&nbsp;
				</div>
			
				<!-- Transaction Value -->
				<h3>Set Value of Transaction In GHO (USD)</h3>
				
				<div id="tValueHeading" class="inputHeading centerTxt">
					<strong>Set Transaction Value</strong>		
				</div>
				<div id="transaction-value-input-div">
					<input id="transaction-value-input" class="input-field" type="number" min="0.01" step="0.01" max="99999999" value="100.00" />
				</div>
			
				<div id="transactionValueDisp" class="centerTxt">
					The Value of This Game: &nbsp; $<span id="tValueDisp">100.00</span>
				</div>
			
				<div class="underline-here">
					&nbsp;
				</div>
			
				<!-- Payment Address -->
				<h3>Payment Address</h3>
			
				<div id="pymAddressBasic">
					<div id="pymAddressHeading" class="inputHeading centerTxt">
						<strong>Loser of Game Will Send Transaction Value Here</strong>		
					</div>
			
					<div id="payment-address-input-div">
						<input id="payment-address-input" class="input-field greenInput" onfocus="this.select();" onmouseup="return false;" value="Enter Payment Address Here"/>
					</div>
			
					<div id="paymentAddressDisp" class="centerTxt">
						Address That Will Receive Payment:
					</div>
					<div id="pymAddressDisp" class="centerTxt">Enter Address Above</div>
				</div>
			
				<div class="underline-here">
					&nbsp;
				</div>
				
				<!-- Initialize Game Button -->
				<div id="initialize-game-button-div" class="center-button-div">
					<button id="init-game-button" class="button largeButton" onclick="initalizeGame()" disabled>Initialize Game</button>
				</div>

			</div>
			<!--End Step 1-->