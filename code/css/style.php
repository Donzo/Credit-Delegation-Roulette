<style>
	/******************************************
					PAGE CSS
	*******************************************/
	
	body{
		background: rgb(27, 32, 48);
		color: rgb(241, 241, 243);
		font-family: Inter, Arial;
		margin: 0;
		padding: 0;
		/*Hide Scroll Bars But Allow Scrolling*/
			-ms-overflow-style: none;
			scrollbar-width: none;
		max-width: 100%;
		overflow-x: hidden;
	}
	body::-webkit-scrollbar {
		display: none;
	}
	img{
		max-width: 100%;
		height: auto;
	}
	#coverAll {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 100vw;
		height: 100vh;
		margin: 0;
		padding: 0;
		background: rgb(27, 32, 48);
		z-index: 9999;
		opacity: 1;
	}
	/******************************************
					HEADER CSS
	*******************************************/
	#header-link, #header-link a{
		text-decoration: none;
		cursor: pointer !important;
		z-index: 11111111;
	}
	#header{
		background-color: rgb(27, 32, 48);
		display: flex;
			-webkit-box-align: center;
		align-items: center;
		box-shadow: rgba(242, 243, 247, 0.16) 0px -1px 0px inset;
		max-height: 180px;
		min-width: 100%;
		padding-bottom:10px;
	}
		#logo-left{
			display: flex;
			margin-right: auto;
			margin-left: 96px;
			align-items: center;
		}
			#aave-logo{
				height: 60px;
			}
			#aave-logo img{
				height: 60px;
			}
		#logo-center{
			display: flex;
			align-items: center;
		}
			#ccr-logo-wide{
				height: 160px;
			}
			#ccr-logo-wide img{
				height: 160px;
			}
			#ccr-logo{
				height: 160px;
				display: none;
			}
			#ccr-logo img{
				height: 160px;
			}			
			
		#logos-right{
			display: flex;
			margin-left: auto;
			margin-right: 96px;
			align-items: center;
		}
			#ghost-and-ghost-logo{
				height: 160px;
			}
			#ghost-and-ghost-logo img{
				height: 160px;
			}
			#chainlink-logo{
				height: 76px;
				margin-bottom: 30px;
				margin-right: 16px;
			}
			#chainlink-logo img{
				height: 76px;
			}
	#thin-header{
		background: rgb(241, 241, 243);
		height: 60px;
		width: 100%;
		margin: 0;
		padding: 0;
		display: flex;
		position: absolute;
		justify-content: center;
		text-align: center;
		top: 0;
	}
		#aave-logo-thin-header{
			display: flex;
			align-items: center;
			margin-top: 10px;
			margin-right: auto;
			margin-left: 96px;
			height: 40px;
		}
		#aave-logo-thin-header img{	
			height: 40px;
		}
		#credit-delegation-roulette-logo-thin-header{
			display: flex;
			margin-top: 10px;
			margin-right: 96px;
			height: 40px;
		}
		#credit-delegation-roulette-logo-thin-header img{
			height: 40px;
		}

	/******************************************
					CONTENT CSS
	*******************************************/
	
	#content{
		max-width: unset;
		padding-left: 96px;
		padding-right: 96px;
	}
	#page-title-01{
		margin-top: 32px;
	}
	#page-title-02, #page-title-03, #page-title-04{
		margin-top: 4px;
	}
	.text-box-white{
		background-color: #FFFFFF;
		color: #303549;
			-webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
		border-radius: 4px;
		box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.05), 0px 0px 1px rgba(0, 0, 0, 0.25);
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;
		display: flex;
			-webkit-flex-direction: column;
			-ms-flex-direction: column;
		flex-direction: column;
			-webkit-align-items: center;
			-webkit-box-align: center;
			-ms-flex-align: center;
		align-items: center;
			-webkit-box-pack: center;
			-ms-flex-pack: center;
			-webkit-justify-content: center;
		justify-content: center;
		text-align: center;
		padding: 16px;
		padding-bottom: 28px;
		flex: 1;
			-webkit-flex: 1;
			-ms-flex: 1;
		
		margin-bottom:20px;
	}
	.text-box-white-02{
		background-color: #FFFFFF;
		color: #303549;
			-webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
		border-radius: 4px;
		box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.05), 0px 0px 1px rgba(0, 0, 0, 0.25);
		padding: 16px;
		padding-bottom: 28px;
		margin-bottom:20px;
	}
	.txt-box-heading{
		margin-bottom: 10px;
		font-size: 1.1em;
	}
	.step-num-title-div, .underline-here{
		box-shadow: rgba(242, 243, 247, 0.16) 0px -1px 0px inset;
		padding-bottom: 5px;
	}
	.centerTxt{
		display: flex;
		justify-content: center;
	}
	#connect-button-div{
		display: flex;
		justify-content: center;
		margin: 2em;
	}
	.connected-as{
		display: flex;
		justify-content: right;
		margin: 10px 10px 0 0;
		font-size: .8em;
	}
	h3{
		margin-block-start: .8em;
		margin-block-end: .8em;
	}
	#player-status-div{
		display: flex;
		justify-content: center;
	}
	.pStatusItem{
		max-height: 200px;
		min-width: 200px;
		margin: .5em 1em;
	}
	.pStatusItem img{
		max-height: 200px;
		
	}
	#connected-as-02, #connected-as-03{
		margin-top: 72px;
	}
	#gameShareLink{
		display: flex;
		justify-content: center;
		text-align: center;
		margin-top: 16px;
	}
	#linkToGame{
		margin: .2em 0;
		font-size: 1.5em;
	}
	#gameShareLinkDiv{
		width: 50%;
		background-color: #FFFFFF;
		color: #303549;
			-webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
		border-radius: 4px;
		box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.05), 0px 0px 1px rgba(0, 0, 0, 0.25);
		padding: 8px;
		padding-bottom: 8px;
		margin-bottom:6px;
		border-style: solid;
		border-color: rgba(183,80,159,0.0);
		opacity: .5;
		
	}
	#gameShareLinkDiv:hover{
		-webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		opacity: 1;
		border-color: rgba(183,80,159,1);
		
	}
	#copy-status{
		text-align: center;
		display: flex;
		justify-content: center;
	}
	#gResultsBody{
		font-size: 1.2em;
	}
	#gStatusHdrTxt{
		font-size: 1.5em;
	}
	#end-game-report-div{
		color: #f1f1f3;
		background-image: linear-gradient(#2eb9c7, #b7509f);
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
		border-radius: 4px;
		box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.05), 0px 0px 1px rgba(0, 0, 0, 0.25);
		padding: 16px;
		padding-bottom: 16px;
		margin-bottom:16px;
		font-size: 1.05em;
	}
	/******************************************
					INPUT CSS
	*******************************************/
	input {
		text-align: center;
	}
	#pSliderHeading{
		justify-content: center;
		text-align: center;
		width: 100%;
		margin:10px 10px 22px;
	}
	
	#playerSlider{
		display: flex;
		justify-content: center;
		margin-top: 20px;
	}
	#playerCountDisp{
		font-size: 1.2em;
		font-weight: 700;
		margin-top: 22px;
	}
	.redInput{
		color: red;
	}
	.greenInput{
		color: green;
	}
	/* SLIDER */
	.slider{
		width: 40%;
		height: 25px;
		opacity: .7;
		transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
		-webkit-appearance: none;  /* Override default CSS styles */
  appearance: none;
  		background: #2eb9c7;
	}
	.slider:hover {
		opacity: 1;
		background: #2eb9c7;
	}
	.slider-lbl{
		font-weight: 700;
	}
	.slider::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		width: 50px;
		height: 50px;
		background: #b7509f;
		cursor: pointer;
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
	}
	.slider::-moz-range-thumb {
		width: 50px;
		height: 50px;
		background: #b7509f;
		cursor: pointer;
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
	}
	/* END SLIDER */
	.inputHeading{
		font-size: 1.2em;
	}
	.button{
		display: inline-flex;
		text-align: center;
		justify-content: center;
		position: relative;
		box-sizing: border-box;
			-webkit-tap-highlight-color: transparent;
		opacity: 1;
		outline: 0px;
		margin: 0px;
		cursor: pointer;
		user-select: none;
		vertical-align: middle;
		appearance: none;
		text-decoration: none;
		transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;		
		box-shadow: none;
		border-radius: 4px;
		font-family: Inter, Arial;
		font-weight: 500;
		line-height: 1.5rem;
		font-size: 0.875rem;
		color: rgb(255, 255, 255);
		border: 1px solid rgba(235, 235, 237, 0.12);
		background-color: rgb(56, 61, 81);
		padding: 7px 8px;
		min-width: unset;
		gap: 8px;
			-webkit-box-align: center;
		align-items: center;
	}
	.button:hover {
		opacity: .7;
	}
	.largeButton{
		font-size: 1em;
		padding: 1em;
	}
	/*Dollar Input*/
	#transaction-value-input-div{
		margin: 10px 0 20px;
		display: flex;
		justify-content: center;
	}
	#transaction-value-input{
		width: 20%;
		height: 2em;
		font-size: 1.75em;
		padding: .5em;
	}
	/*Payment Address Input*/
	#payment-address-input-div{
		margin: 10px 0 20px;
		display: flex;
		justify-content: center;
	}
	#payment-address-input{
		width: 40%;
		height: 2em;
		font-size: 1.1em;
		padding: .5em;
	}
	#pymAddressDisp{
		margin-top: 20px;
		font-size: 1.2em;
	}
	#initialize-game-button-div{
		margin-top: 30px;
	}
	.center-button-div{
		margin: 10px 0 20px;
		display: flex;
		justify-content: center;
	}
	button:disabled, button[disabled], button[disabled]:hover{
		border: 1px solid #999999;
		background-color: #cccccc;
		color: #666666;
		opacity: 1;
	}
	.bigSymbol{
		font-size: 3em;
		margin: -0.5em 0 0 .5em;
	}
	input[type=checkbox] {
		transform: scale(1.5);
	}
	#lock-player-in-div{
		min-height: 60px;
	}
	/*CCIP Check box*/
	#ccipCheckBoxDiv{
		margin-top: .5em;
		display: flex;
		justify-content: center;
	}
	#ccipCheckBox{
		margin-right: 1em;
	}
	/******************************************
				SYSTEM MESSAGE BOXES CSS
	*******************************************/
	#sysMsgBoxBG{
		position: absolute;
		top: 0;
		height: 150%;
		left: 0;
		width: 100%;
		background: #000000;
		opacity: .75;
		display: none;
	}
	.sysMsgBox{
		position: absolute;
		background: rgba(235, 235, 237);
		color: rgb(27, 32, 48);
		border: 5px solid #9c8ae8;
		border-radius: 4px;
		box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 0px 1px 1px 0px rgba(0,0,0,0.14), 0px 1px 3px 0px rgba(0,0,0,0.12);
		border-radius: 4px;
		box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.05), 0px 0px 1px rgba(0, 0, 0, 0.25);
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;
		top: 20%;
		height: 60%;
		width: 60%;
		margin-left: auto;
		margin-right: auto;
		left: 0;
		right: 0;
		text-align: left;
	}
	.sysMsgBoxTitle{
		font-size: 2.25em;
		font-weight: 700;
		margin: 1.25em 0em .25em;
		text-align: center;
		z-index: 101;
	}
	.sysMsgBoxBody{
		margin: 1.25em 2em .25em;
		font-weight: 400;
		font-size: 1.5em;
		z-index: 100;
	}
	#alertBox{
		display: none;
	}
	#confirmBox{
		display: none;
	}
	#inputBox{
		display: none;
	}
	#miningInfoBox{
		display: none;
		background: #FFFFFF;
	}
	#miningInfoLoadingWheelDiv{
		max-height: 25vh;
		z-index: -100;
	}
	#miningInfoLoadingWheelDiv img{
		max-height: 25vh;
		z-index: -99;
	}
	#eth-input-field{
		margin-bottom: 3em;
	}
	#eth-input{
		width: 20%;
		height: 2em;
		font-size: 1.75em;
		padding: .5em;
	}
	.sysMsgBoxButtons{
		position: absolute;
		bottom: 20px;
		margin-left: auto;
		margin-right: auto;
		left: 0;
		right: 0;
		text-align: center;
	}
	.sysMsgButton{
		padding: .5em 2em;
		font-size: 2em;
		margin: 1em 2em;
		cursor: pointer;
	}
	
	/******************************************
					RESPONSIVE CSS
	*******************************************/
	
	/*Mobile (Thin) Screens*/
	@media screen and (max-width: 900px) { 
		.sysMsgBox{
			height: 50%;
			width: 80%;
		}
		.sysMsgBoxTitle{
			font-size: 1em;
			margin: .6em;
		}
		.sysMsgBoxBody{
			margin: .6em;
			font-size: .8em;
		}
		#content{
			padding-left: 10px;
			padding-right: 10px;
		}
		#header{
			max-height: 80px;
			padding-bottom:10px;
		}
		#logo-left{
			margin-left: 10px;
			margin-top: 5px;
		}
			#aave-logo{
				height: 20px;
			}
			#aave-logo img{
				height: 20px;
			}
			#ccr-logo-wide{
				height: 40px;
			}
			#ccr-logo-wide img{
				height: 40px;
			}
			#ccr-logo{
				height: 40px;
				display: none;
			}
			#ccr-logo img{
				height: 40px;
			}			
		#logo-center{
			margin-top: 5px;
		}
		#logos-right{
			margin-right: 10px;
		}
			#ghost-and-ghost-logo{
				height: 40px;
			}
			#ghost-and-ghost-logo img{
				height: 40px;
			}
			#chainlink-logo{
				height: 25px;
				margin-bottom: 0px;
				margin-right: 16px;
			}
			#chainlink-logo img{
				height: 25px;
			}
		#thin-header{
			height: 30px;
		}
			#aave-logo-thin-header{
				margin-top: 5px;
				margin-left: 10px;
				height: 20px;
			}
			#aave-logo-thin-header img{	
				height: 20px;
			}
			#credit-delegation-roulette-logo-thin-header{
				margin-top: 5px;
				margin-right: 10px;
				height: 20px;
			}
			#credit-delegation-roulette-logo-thin-header img{
				height: 20px;
			}
		.connected-as{
			font-size: .01em;
			margin: 10px 5px 6px 0;
		}
		.center-button-div{
			margin: 10px 0 10px;
		}
		#page-title-01{
			margin: 16px 0 16px 0;
			font-size: 1.3em;
		}
		#page-title-02{
			margin-top:6px;
			font-size: 1.3em;
		}
		.button{
			line-height: 1rem;
			font-size: 0.5rem;
		}
		.step-num-title-div{
			font-size: .7em;
		}
		h3{
			font-size: .96em;
			margin-block-start:.65em;
			margin-block-end: .65em;
		}
		.inputHeading, #playerCountDisp, #pymAddressHeading, #payment-address-input{
			font-size: .7em;
		}
		#playerCountDisp{
			margin-top: 12px;
		}
		#pSliderHeading{
			margin:12px 10px 6px;
		}
		#playerSlider{
			margin-top: 6px;
		}
		#playerCountSlider{
			width: 60%;
		}
		#transaction-value-input-div {
			margin: 8px 0 8px;
		}
		#transaction-value-input{
			width: 60%;
			font-size: 1em;
		}
		#payment-address-input{
			width: 90%;
		}
		#pymAddressDisp{
			font-size: .5em;
		}
		.slider{
			height: 10px;
		}
		.slider-lbl{
			font-size: .7em;
		}
		.slider::-webkit-slider-thumb {
			width: 20px;
			height: 20px;
		}
		.slider::-moz-range-thumb {
			width: 20px;
			height: 20px;
		}
		#initialize-game-button-div{
			margin-top: 10px;
		}
		 .underline-here{
			padding-bottom: 0;
		}
		#payment-address-input-div{
			margin: 4px 0 8px;
		}
		.sysMsgButton{
			padding: .25em .75em;
			font-size: 1em;
			margin: .6em;
		}
		#transactionValueDisp, #paymentAddressDisp{
			font-size: .7em;
		}
	}
	/* Wider Screens */
	@media screen and (max-width: 1299px) { 
		#ccr-logo{
			display: flex;
		}
		#ccr-logo-wide{
			display: none;
		}
	}
	
	/******************************************
		TRANSITION ANIMATIONS (GO AT THE BOTTOM)
	*******************************************/
	.visible{
		display: block;
		  -o-transition: all .5s ease-in-out 0s;
		transition: all .5s ease-in-out 0s;
		pointer-events:auto;
	}
	.visible-no-block{
		  -o-transition: all .5s ease-in-out 0s;
		transition: all .5s ease-in-out 0s;
		pointer-events:auto;
	}
	.invisible {
		display: block;
		opacity: 0;
		 -o-transition: all .5s ease-in-out 0s;
		transition: all .5s ease-in-out 0s;
		pointer-events:none;
	}
	.invisible-no-block {
		opacity: 0;
		 -o-transition: all .5s ease-in-out 0s;
		transition: all .5s ease-in-out 0s;
		pointer-events:none;
	}
	.gone {
	  display: none !important;
	  pointer-events:none;
	}
	
	
	
	/******************************************
					END CSS
	*******************************************/
</style>