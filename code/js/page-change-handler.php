<script>
		
		const params = new Proxy(new URLSearchParams(window.location.search), {
			get: (searchParams, prop) => searchParams.get(prop),
		});
		//Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
		if (params.gameID){
			theGameID = params.gameID; // "some_value"
			console.log('theGameID = ' + theGameID);
		}
	</script>