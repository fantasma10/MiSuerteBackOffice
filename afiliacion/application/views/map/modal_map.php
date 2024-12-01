<input type="text" id="address" style="width:700px"/>
<button type="button" onclick="codeAddress()">Ver en Mapa</button>
<br/>
<br/>
<br/>
<div id="map" style="width:500px;height:400px;">
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFOzxKd4vBpuj8jl4p3gzGxPFt12P74H0&callback=initMap&libraries=places&sensor=false" async defer></script>
<!--script src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false" type="text/javascript"></script-->
<script>

	var lat = '<?php echo $lat;?>';
	var lng = '<?php echo $lng;?>';

	var map;
	var marker;
	function initMap(){
		map = new google.maps.Map(document.getElementById('map'),{
			center	:
			{
				lat	: 25.6714,
				lng	: -100.309
			},
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.HYBRID
		});

		var newLatLng = new google.maps.LatLng(lat, lng);
		//marker.setPosition(newLatLng);
		marker = new google.maps.Marker({
			position	: newLatLng,
			map			: map,
			draggable	: false //make it draggable
		});
		map.setCenter(marker.getPosition());

		google.maps.event.addListener(marker, 'click', function(){
			map.panTo(this.getPosition());
		});


		marker.addListener('click', function(){
			maxZoomService = new google.maps.MaxZoomService();
			maxZoomService.getMaxZoomAtLatLng(newLatLng, function(response){
				console.log(response);
				if (response.status !== google.maps.MaxZoomStatus.OK){
					map.setZoom(17);
				}
				else {
					map.setZoom(response.zoom);
				}
				map.setCenter(marker.getPosition());
			});
		});

		var input = document.getElementById("address");
		var options = {};
		autocomplete = new google.maps.places.Autocomplete(input, options);
		google.maps.event.addListener(autocomplete, "place_changed", function() {
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				fromPlace = 0;
				return
			}
			fromPlace = 1;
			locationFromPlace = place.geometry.location
		});
	}

	function codeAddress() {
		var address = document.getElementById("address").value;
		if (fromPlace == 1) {
			map.setCenter(locationFromPlace);
			if (marker != null) marker.setMap(null);
			marker = new google.maps.Marker({
				map: map,
				position: locationFromPlace
			});
			latres = locationFromPlace.lat();
			lngres = locationFromPlace.lng();
			document.getElementById("txtLat").value = latres;
			document.getElementById("txtLng").value = lngres;
			ddversdms()
		} else {
			geocoder.geocode({
				address: address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					if (marker != null) marker.setMap(null);
					marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location
					});
					document.getElementById("latitude").value = results[0].geometry.location.lat();
					document.getElementById("longitude").value = results[0].geometry.location.lng();
					ddversdms()
				} else {
					alert(trans.GeocodingError + status)
				}
			})
		}
	}


</script><!--20.5567316,-101.1975615-->
<!--25.687546,-100.279274-->