<div id="map" style="width:800px;height:500px;float:left;">
	adsf
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFOzxKd4vBpuj8jl4p3gzGxPFt12P74H0&callback=initMap" async defer></script>
<script>

	var trans = {
		DefaultLat			: 40.7127837,
		DefaultLng			: -74.0059413,
		DefaultAddress		: "New York, NY, USA",
		Geolocation			: "Geolocalización:",
		Latitude			: "Latitud:",
		Longitude			: "Longitud:",
		GetAltitude			: "Obtener Altitud",
		NoResolvedAddress	: "Sin dirección resuelta",
		GeolocationError	: "Error de geolocalización.",
		GeocodingError		: "Error de codificación geográfica: ",
		Altitude			: "Altitud: ",
		Meters				: " metros",
		NoResult			: "No result found",
		ElevationFailure	: "Elevation service failed due to: ",
		SetOrigin			: "Establecer como origen",
		SetDestination		: "Establecer como destino",
		Address				: "Dirección: ",
		Bicycling			: "En bicicleta",
		Transit				: "Transporte público",
		Walking				: "A pie",
		Driving				: "En coche",
		Kilometer			: "Kilómetro",
		Mile				: "Milla",
		Avoid				: "Evitar",
		DirectionsError		: "Calculating error or invalid route.",
		North				: "N",
		South				: "S",
		East				: "E",
		West				: "O",
		Type				: "tipo",
		Lat					: "latitud",
		Lng					: "longitud",
		Dd					: "GD",
		Dms					: "GMS",
		CheckMapDelay		: 7e3
	};
	var map;
	var marker = false;
	var geocoder;
	var infowindow;
	var elevator;
	var fromPlace = 0;
	var locationFromPlace;
	var addressFromPlace;
	var placeName;

	function initMap(){
		infowindow = new google.maps.InfoWindow;

		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 25.6714, lng: -100.309},
			zoom: 8,
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.HYBRID
		});

		google.maps.event.addListener(map, 'click', function(event) {                
	        var clickedLocation = event.latLng;
	        if(marker === false){
	            marker = new google.maps.Marker({
	                position	: clickedLocation,
	                map			: map,
	                draggable	: true //make it draggable
	            });

	            google.maps.event.addListener(marker, 'dragend', function(event){
	                markerLocation();
	            });
	        }
	        else{
	            marker.setPosition(clickedLocation);
	        }
	        markerLocation();
	        obtenerDireccion();
	    });
	}

	function obtenerDireccion(){
		geocoder			= new google.maps.Geocoder;
		var currentLocation = marker.getPosition();
		var pos				= new google.maps.LatLng(currentLocation.lat(), currentLocation.lng());

		geocoder.geocode({
			latLng: pos
		}, function(results, status) {
			console.log(results);
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					if (marker != null) marker.setMap(null);
					marker = new google.maps.Marker({
						position: pos,
						map: map
					});
					var infoText = '<span id="geocodedAddress">' + results[0].formatted_address + "</span><br>";
					console.log(pos.lat(), pos.lng());
					//document.getElementById("address").innerHTML = results[0].formatted_address;
					infowindow.setContent(infoText);
					infowindow.open(map, marker);
				}
			} else {
				if (marker != null) marker.setMap(null);
				marker = new google.maps.Marker({
					position: pos,
					map: map
				});
				var infoText = "<strong>" + trans.Geolocation + '</strong> <span id="geocodedAddress">' + trans.NoResolvedAddress + "</span>";
				infowindow.setContent(infowindowContent(infoText, position.coords.latitude, position.coords.longitude));
				document.getElementById("latitude").value = position.coords.latitude;
				document.getElementById("longitude").value = position.coords.longitude;
				//Wdocument.getElementById("address").value = trans.NoResolvedAddress;
				bookUp(trans.NoResolvedAddress, position.coords.latitude, position.coords.longitude);
				infowindow.open(map, marker);
				ddversdms()
			}
		})
	}




	function markerLocation(){
		//Get location.
		var currentLocation = marker.getPosition();
		//Add lat and lng values to a field that we can save.
		document.getElementById('txtNLatitud').value	= currentLocation.lat(); //latitude
		document.getElementById('txtNLongitud').value	= currentLocation.lng(); //longitude
	}


</script>