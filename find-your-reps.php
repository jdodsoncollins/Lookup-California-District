<?php
    
/**
 * @package 
 */
/*
Plugin Name: Lookup California District
Description: This plugin finds the district number for your address. It uses the Google Maps Javascript API as well as the Open States API. This is based on https://wordpress.org/plugins/find-your-reps/
Author: Kathleen Malone, Jeremy Collins
Author Email: kathleenfmalone@gmail.com, jdodsoncollins@gmail.com
Version: 0.1
Author URI: https://profiles.wordpress.org/kathleenfmalone/, https://github.com/jdodsoncollins
*/

if (is_admin() ) {
    
    require_once( plugin_dir_path(__FILE__).'/includes/admin.php');
}

function fyr_scripts_method() {
		global $post;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'fyr_find_state_reps') ) {

    $googleMapsKey = 'YOUR GOOGLE MAPS API KEY GOES HERE';
    wp_enqueue_script('googleapis', 
        'https://maps.googleapis.com/maps/api/js?key=' . $googleMapsKey . '&sensor=false', false
    );
    
	wp_enqueue_script(
		'fyr_find_state_reps_script',
		plugins_url( '/js/fyr-find-state-reps.js' , __FILE__ ), false
	);

    wp_enqueue_script( 'jquery' );

    fyr_define_javascript_vars();
    }
}

function fyr_define_javascript_vars() {

   $fyr_plugin_options = get_option('fyr_plugin_options'); 
   wp_localize_script( 'fyr_find_state_reps_script', 'fyr_plugin_options_for_javascript', $fyr_plugin_options );
    
}

function fyr_styles_method() {
		global $post;	
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'fyr_find_state_reps') ) {
	
	$theme_file = get_stylesheet_directory() . '/fyr.css';
	$plugin_file = plugin_dir_path(__FILE__) . 'css/fyr.css';

	if ( @file_exists($plugin_file) ) { // if custom fyr.css not in theme directory then use plugin version
		wp_enqueue_style( 'fyr_find_state_reps_style', plugins_url( 'css/fyr.css', __FILE__ ) );
	}
	}
}

function fyr_shortcode_find_state_reps(){

 ?>
        
<div class="container-fluid">
<div class="row">

    <div id="fyr_find_reps">
        
        <form action="#" onsubmit="return fyr_get_state_rep_data(this);" style="display: block; padding-top: 30px">

  <div class="form-group ">
    <label for="fyr_street_address" style="color: white">Street Address</label>
      <input type="text" class="form-control" style="margin: auto" id="fyr_street_address" placeholder="Your street address, such as '1315 10th Street'">
  </div>
    <div class="form-group ">
    <label for="fyr_city" style="color: white">City</label>
      <input type="text" class="form-control" style="margin: auto" id="fyr_city" placeholder="Your city in California, such as 'Sacramento'">
  </div>
  <div class="form-group ">
      <button type="submit"class="fyr-submit-button btn btn-primary center-block" type="submit" value="Find" name="submit" style="margin-top: 25px;">Submit</button>
  </div>
</form>
</div>
    

    </div>
    <div id="adem_find_reps"></div>

     <div id="fyr_map_canvas"></div>

</div>
        


<?php  
    
}
add_action( 'wp_enqueue_scripts', 'fyr_scripts_method' );
add_action( 'wp_enqueue_scripts', 'fyr_styles_method' );
add_shortcode('fyr_find_state_reps', 'fyr_shortcode_find_state_reps');


?>