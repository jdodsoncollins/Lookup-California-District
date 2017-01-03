<?php

/*Create a sub menu for Find Your Reps plugin to the Settings menu by calling the fyr_create_menu function*/
add_action( 'admin_menu', 'fyr_create_menu');

function fyr_create_menu() {

/*Calls the fyr_settings function to create the Find Your Reps menu page*/

add_options_page( 'Find Your Reps', 'Find Your Reps', 'manage_options', 'fyr_slug', 'fyr_settings' );

}

function fyr_save_settings() {

$fyr_plugin_options = array(
'fyr_sunlight_key' =>
$_POST["fyr_sunlight_key"],
);

update_option('fyr_plugin_options', $fyr_plugin_options);

?>
<div class="wrap">
  
  <h2>
    Your Settings Have Been Saved
  </h2>
  
</div>

<?php  
}

function fyr_settings () {

if (isset($_POST['fyr_sunlight_key'])) {
fyr_save_settings();
return;
}
else {
$fyr_options = get_option('fyr_plugin_options');
$fyr_sunglight_key = $fyr_options['fyr_sunlight_key'];

?>
<div class="wrap">
  <h2>
    Find Your Representatives Settings
  </h2>
  <form name="fyr_save_settings" method="POST" action="" >
    <table class="form-table">
      <tr>
        <td>
          Sunlight Foundation Key:
        </td>
        <td>
          <input maxlength="32" size="32" name="fyr_sunlight_key" value="<?php echo $fyr_sunglight_key;?>">
                 <p>
                   You can get this at the 
                   <a href="http://sunlightfoundation.com/api/accounts/register/" target="_blank" >
                     The Sunlight Foundation's Website
                   </a>
                 </p>
             </td>
             
             </tr>
             <tr>
               <td>
                 <h3>
                   Shortcode
                 </h3>
               </td>
               <td>
               </td>
             </tr>
             <tr>
               <td>
                 Find State Representatives:
               </td>
               <td>
                 [fyr_find_state_reps]
               </td>
             </tr>
             
             <tr>
               <td>
                 <input type="submit" name="save" value="Save Settings" class="button-primary"/>
               </td>
             </tr>
             </table>
          </form>
          
</div>

<?php  
}
}
?>