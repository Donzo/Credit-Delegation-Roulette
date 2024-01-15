<div id="step-2" class="gone">

				<!-- Connected As -->
				<div id="connected-as-02" class="connected-as">Connected As: &nbsp; <span id="connected-as-address-02"></span></div>
				<h1 class="page-title" id="page-title-03">Credit Delegation Roulette</h1>
				
				<!-- Page Heading -->
				<h3>Step 2 of 3</h3>
				<div class="step-num-title-div">
					<h2>Lock In Players</h2>
				</div>
			
				<!-- Get Ready Player -->
				<h3>Get Ready Player</h3>
				
				
				<div id="intro-txt" class="text-box-white-02">
					<div class="centerTxt"><strong>Enter Wager?</strong></div>
					<div>
						Would you like to compete with <span id="tb-pCount">2</span> other players to determine who will pay $<span id="tb-tAmount">100.00</span> to <span id="tb-dAddress">DESTINATION ADDRESS</span>? Loser of the game will borrow GHO
against their collateral on AAVE and send it to the payment address.	
					</div>				
				</div>
				
				<div id="agree-check-div">
					<input type="checkbox" id="agreeToPlayCB" name="agreeToPlayCB" value="agree" onclick="agreeToPlay()">
					<label for="agreeToPlayCB"> I understand the risks and agree to play.</label><br>
				</div>
				
				<!-- Initialize Game Button -->
				<div id="lock-player-in-div" class="center-button-div">
					<button id="lock-player-button" class="invisible button largeButton" onclick="joinPlayer()">Join Game</button>
				</div>
				
				
				<div class="underline-here">
					&nbsp;
				</div>
				
				<!-- Player Address -->
				<h3>Player Status</h3>
				
				<div id="pStatusHdrTxt" class="inputHeading centerTxt">
					<strong>Waiting for Players...</strong>		
				</div>
				
				<div id="gameShareLink" class="centerTxt">
					<div id="gameShareLinkDiv">
						<strong>Share This Game Link with Other Players</strong>
						<div id="gameLinkShareBox" class="linkShareBox">
							<div id="linkToGame"></div>
						</div>
						<strong>Click This Box to Copy the Game Link</strong>
					</div>
				</div>
				<div id='copy-status'>&nbsp;</div>
				
				<div id="player-status-div">
					
				</div>
				
				<!-- Initialize Game Button -->
				<div id="ready-player-button-div" class="center-button-div">
					<button id="ready-player-button" class="button largeButton" onclick="playGame()" disabled>Players Not Ready</button>
				</div>

			</div>
			<!--End Step 2-->