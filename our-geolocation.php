<?php
/*
	Plugin Name: Our Geolocation
	Plugin URI: www.wpcue.com
	Description: Simply show your geographical location to your visitor.
	Version: 1.0
	Author: digontoahsan
	Author URI: www.wpcue.com
	License: GPL2
*/
	
	function our_geolocation_modify_menu(){
		add_menu_page( 'Our Geolocation', 'Geolocation', 'manage_options', 'our-geolocation', 'our_geolocation_options' );
	}
	
	add_action('admin_menu','our_geolocation_modify_menu');

	function our_geolocation_options(){
		include('our-geolocation-admin.php');
	}
	
	define('OUR_GEOLOCATION_URL',WP_PLUGIN_URL."/our-geolocation/");
	
	register_activation_hook(WP_PLUGIN_DIR.'/our-geolocation/our-geolocation.php','set_geoloc_options');
	register_deactivation_hook(WP_PLUGIN_DIR.'/our-geolocation/our-geolocation.php','unset_geoloc_options');
	
	function set_geoloc_options(){
		add_option('our-geolocation-width',100);
		add_option('our-geolocation-height',320);
		add_option('our-geolocation-getdir','yes');
	}
	
	function our_geolocation_admin_enqueue() {	
		if(isset($_GET['page'])){
			$pgslug = $_GET['page'];
			$menuslug = array('our-geolocation');
			if(!in_array($pgslug,$menuslug))
        		return;
			wp_enqueue_script( 'our-geolocation-js-script', OUR_GEOLOCATION_URL . 'js/script.our.geolocation.admin.js', array( 'jquery' ) );
			wp_localize_script( 'our-geolocation-js-script', 'our_geolocationajx', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'our_geolocationAjaxReqChck' => wp_create_nonce( 'our_geolocationauthrequst45' )));
		}
	
	}
	add_action( 'admin_enqueue_scripts', 'our_geolocation_admin_enqueue' );
	
	function our_geolocation_enqueue() {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'ourgeolocation',OUR_GEOLOCATION_URL.'js/script.our.geolocation.js',array( 'jquery' ) );	
	}
	add_action( 'wp_enqueue_scripts', 'our_geolocation_enqueue' );
	
	function our_geolocation_head ($atts) {
		ob_start();
	?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script type="text/javascript">
			var directionDisplay;
			var directionsService = new google.maps.DirectionsService();
			var map;
			
			var dirLoc = new google.maps.LatLng(<?php echo get_option('our-geolocation-latitude')?>,<?php echo get_option('our-geolocation-longitude')?>);
			function our_geolocationInitialize() {
				directionsDisplay = new google.maps.DirectionsRenderer();
				var mapOptions = {
					mapTypeControl: true, 
					streetViewControl: true, 
					overviewMapControl: true, 
					scaleControl: true, 
					panControl: true, 
					zoomControl: true, 
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: dirLoc, 
					zoom:15
				}
				map = new google.maps.Map(document.getElementById('our-geolocation-map-canvas'), mapOptions);
			
				if(document.getElementById("direction-from").value==""){
					var our_geolocationmarker = new google.maps.Marker({map: map, position:
					new google.maps.LatLng(<?php echo get_option('our-geolocation-latitude')?>,<?php echo get_option('our-geolocation-longitude')?>)});
				}
			
				directionsDisplay.setMap(map);	
				directionsDisplay.setPanel(document.getElementById("directionsPanel"));			
			}
        </script>
<?php
		$our_geolocation_res = ob_get_contents();
		ob_end_clean();
		echo $our_geolocation_res;
	}
	add_action('wp_head','our_geolocation_head');
	
	function dg_our_geolocation($atts) {
		//global $wpdb;
		ob_start();
	?>
<!-- This map output is generated with a simple WordPress geolocation plugin 'Our Geolocation' version 1.0 - http://www.wpcue.com/wordpress-plugins/geolocation/ -->
<style>
#our-geolocation-map-canvas {
 width:<?php if(get_option('our-geolocation-width')) {
echo get_option('our-geolocation-width');
}
?>%;
 height:<?php if(get_option('our-geolocation-height')) {
echo get_option('our-geolocation-height');
}
?>px;
}
.our-geolocation-button {
	background-color: #24890D;
	border: 0 none;
	border-radius: 2px;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: 700;
	padding: 10px 30px 11px;
	text-transform: uppercase;
	vertical-align: bottom;
	cursor:pointer;
}
.pac-container {
	width:320px !important;
}
.our-geolocation-input {
	border: 1px solid rgba(0, 0, 0, 0.1);
	border-radius: 2px;
	color: #2B2B2B;
	padding: 8px 10px 7px;
}
input:focus {
	border: 1px solid rgba(0, 0, 0, 0.3);
	outline:none;
}
</style>
<div class="our-geolocation-map" style="position:relative; width:100%; float:left; margin-top:10px;">
  <div <?php if(get_option('our-geolocation-getdir') == 'no'){echo 'style="display:none;';}?>>
    <form method="post" onsubmit="return false">
      <p>
        <input class="our-geolocation-input" type="text" id="direction-from" name="direction-from" value="" style="width:320px;" />
      </p>
      <input type="hidden" value="<?php echo get_option('our-geolocation-address');?>" name="our-geolocation-end-dir" id="our-geolocation-end-dir" />
      <input class="our-geolocation-button" type="button" onclick="our_geolocationShwDir();" value="Get Directions" />
    </form>
  </div>
  <div id="our-geolocation-map-canvas" style="margin-top:15px;"></div>
  <div id="directionsPanel"></div>
</div>
<!-- / Our Geolocation a simple WordPress geolocation plugin -->
<?php
		$dggeoloc_res = ob_get_contents();
		ob_end_clean();
		return $dggeoloc_res;
	}
	add_shortcode('our-geolocation', 'dg_our_geolocation');
