<?php if ( ! defined( 'ABSPATH' ) || ! current_user_can( 'manage_options' ) ) exit;?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<style>
.pac-container {
	width:320px !important;
}
.geoloc-col-left{
	width:75%;
	float:left;
	position:relative;
}
.geoloc-col-right{
	width:22%;
	float:right;
	position:relative;
	background-color:#fff;
	padding:10px;
	height:400px;
}
.geoloc-col-right li{
	list-style:inside;
	color:#0074a2;
	text-decoration:underline;
}
</style>
<div class="wrap">
  <div id="icon-themes" class="icon32"> <br>
  </div>
  <h2>Our Geolocation</h2>
  <?php
	if(isset($_POST['our-geolocation-submit'])){		
		our_geolocation_update_opt();
	}
	
	function our_geolocation_update_opt(){
		$our_geolocation_succ = 0;
		$our_geolocation_err = 0;
		
		if(!isset($_POST['our-geolocation-getdir'])){
			if(update_option('our-geolocation-getdir', 'no')){
				$our_geolocation_succ++;
			}
			else
			{
				$our_geolocation_err++;
			}
		}
		
		foreach( $_POST as $key => $val ){
			
			if( get_option( $key ) != trim( $val ) && $key != 'our-geolocation-submit'){				
				$sanitized_val = sanitize_text_field(trim( $val ));
				$chk = update_option( $key, $sanitized_val);
				if( $chk ){
					$our_geolocation_succ++;
				}
				else{
					$our_geolocation_err++;
				}
			}
		}
		
	?>
  <div id="message" class="updated fade">
    <p><?php echo $our_geolocation_succ .' field updated successfully. ' . $our_geolocation_err .' errors.';?></p>
  </div>
  <?php	} ?>
  <div style="margin-top:30px;">
    <div class="geoloc-col-left">
      <p>Put your location address at the below field. If you know the exact Latitude and Longitude value of your locatoin then put it also.If not click on <strong>Generate</strong> button.</p>
      <form action="" method="post" onsubmit="return false" id="location-frm">
        <table class="form-table">
          <tr>
            <th scope="row">Your address</th>
            <td><input type="text" name="our-geolocation-address" id="address" value="<?php if(get_option('our-geolocation-address')){echo get_option('our-geolocation-address');}?>" style="width:320px;" />
              <input type="button" value="Generate" class="button-secondary" onclick="ourgeolocationCodeAddress()" /></td>
          </tr>
          <tr>
            <th scope="row">Latitude</th>
            <td><input type="text" name="our-geolocation-latitude" id="latitude" value="<?php if(get_option('our-geolocation-latitude')){echo get_option('our-geolocation-latitude');}?>" /></td>
          </tr>
          <tr>
            <th scope="row">Longitude</th>
            <td><input type="text" name="our-geolocation-longitude" id="longitude" value="<?php if(get_option('our-geolocation-longitude')){echo get_option('our-geolocation-longitude');}?>" /></td>
          </tr>
          <tr>
            <th scope="row">Map dimension</th>
            <td>Width
              <input type="text" name="our-geolocation-width" value="<?php if(get_option('our-geolocation-width')){echo get_option('our-geolocation-width');}?>" style="width:6%" onkeypress="return onlyNum(event);" />
              % <span style="padding:0px 5px">Height</span>
              <input type="text" name="our-geolocation-height" value="<?php if(get_option('our-geolocation-height')){echo get_option('our-geolocation-height');}?>" style="width:6%" onkeypress="return onlyNum(event);" />
              px </td>
          </tr>
          <tr>
            <th scope="row">Enable get direction module</th>
            <td><input type="checkbox" value="yes" name="our-geolocation-getdir" <?php if(get_option('our-geolocation-getdir') == 'yes'){echo 'checked="checked"';}?>/></td>
          </tr>
          <tr>
            <th scope="row">&nbsp;</th>
            <td><input type="submit" name="our-geolocation-submit" value="Save changes" class="button-primary" onclick="ourgeolocationChkFrm()" /></td>
          </tr>
        </table>
      </form>
    </div>
    <div class="geoloc-col-right">
      <h2>Our Geolocation 1.0</h2>
      <ul>
        <li><a href="http://www.wpcue.com/wordpress-plugins/geolocation/" target="_blank">Plugin Homepage</a></li>
        <li><a href="http://www.wpcue.com/support/forum/geolocation/" target="_blank">Help / Support</a></li>
      </ul>
      <h3>Do you like this Plugin?</h3>
      <p>Any kind of participation will be highly appreciated and real inspiration for me to work more for this plugin.</p>
      <ul>
        <li>Write a small blog for Our Geolocation and give link to our site.</li>
        <li>Share it to your social media.</li>
        <li><a href="http://wordpress.org/support/view/plugin-reviews/our-geolocation" target="_blank">Give it a good rating and review</a></li>
        <li><a href="http://wordpress.org/plugins/our-geolocation/" target="_blank">Vote that it work</a></li>
      </ul>
    </div>
  </div>
</div>
