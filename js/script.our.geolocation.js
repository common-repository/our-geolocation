jQuery(document).ready(function($) {
  if($("#our-geolocation-map-canvas").length){
   		our_geolocationInitialize();
   		google.maps.event.addDomListener(window, 'load', ourgeolocationAutoCominitialize);
  }
});

function our_geolocationCalR(st,end,selMod) {
	var request = {
		origin: st,
		destination: end,
		travelMode: google.maps.TravelMode[selMod]
	};
	directionsService.route(request, function(response, status) {
	  if (status == google.maps.DirectionsStatus.OK) {
		directionsDisplay.setDirections(response);
	  }
	  else {
			  alert("Sorry, could not find any directions from your provided address.");
		  }
	});
  }//

function our_geolocationShwDir(){
	var stp = jQuery("#direction-from").val();
	var endp = jQuery("#our-geolocation-end-dir").val();
	var mod = 'DRIVING';
	
	our_geolocationCalR(stp,endp,mod);
}

function ourgeolocationAutoCominitialize() {
	var input = document.getElementById('direction-from');
    var autocomplete = new google.maps.places.Autocomplete(input);
}