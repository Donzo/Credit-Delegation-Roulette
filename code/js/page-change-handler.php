<script>
		
		const params = new Proxy(new URLSearchParams(window.location.search), {
			get: (searchParams, prop) => searchParams.get(prop),
		});
		
		function verifyDataLoad(){
			//If players is -1 then the data didn't load properly so load it now.
			var thisManyPlayers = parseInt(document.getElementById('tb-pCount').innerHTML);
			if (thisManyPlayers < 0){
				getGameData(gID);
			}
		}
		//Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
		if (params.gameID){
			theGameID = params.gameID; // "some_value"
			setTimeout(verifyDataLoad, 5000, theGameID)
		}
	</script>