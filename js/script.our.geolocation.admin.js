var geocoder; 
var latlang;   
var lat;
var lng; 
var newArray = [];

jQuery(document).ready(function($) {
   google.maps.event.addDomListener(window, 'load', ourgeolocationAdAutoCom);
   geocoder = new google.maps.Geocoder();
});

function ourgeolocationCodeAddress() {
	var address = document.getElementById('address').value;
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		latlang = results[0].geometry.location;
		for (var key in latlang) {  
			newArray.push(key);  
		}
		lat = latlang[newArray[0]];
		lng = latlang[newArray[1]];
		
		jQuery("#latitude").val(lat);
		jQuery("#longitude").val(lng);
	  } else {
		alert('Geocode was not successful for the following reason: ' + status);
	  }
	});
  }
	  
function ourgeolocationAdAutoCom() {
	var input = document.getElementById('address');
    var autocomplete = new google.maps.places.Autocomplete(input);
}

function ourgeolocationChkFrm(){
	var add = jQuery("#address").val();
	var lat = jQuery("#latitude").val();
	var lang = jQuery("#longitude").val();
	
	if(add == ''){
		alert("Enter your location.");
		return false;
	}
	if(lat == ''){
		alert("Enter latitude value of your location or generate.");
		return false;
	}
	if(lang == ''){
		alert("Enter longitude value of your location or generate.");
		return false;
	}
	
	jQuery("#location-frm").removeAttr('onsubmit');
	jQuery("#location-frm").submit();
}
function onlyNum(evt)
{
    var e = window.event || evt;
    var charCode = e.which || e.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;

}