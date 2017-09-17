<?php

/*Plugin Name: WP Login Register
Plugin URL: https://github.com/polashrp/wplogin.git
Description: Used By more, <a href="https://github.com/polashrp/wplogin.git">WP Login Registration </a> .....
Version: 0.01
Author: Habib
Auther URL: https://github.com/polashrp/wplogin.git
License: GPLv2 or later
Text Domina: wp login

*/

/**
* 
*/
class Wplogin
{
	
	public function __construct()
	{
		add_action( 'admin_menun',array($this,'wpa_add_menu'));
		register_activation_hook( __FILE__, array($this,'wpa_install'));
		register_deactivation_hook( __FILE__, array($this,'wpa_uninstall'));
		add_action( 'wp_enqueue_scripts',array($this,'add_frontend_scripts'));
	}
	public function add_frontend_scripts(){
		
    wp_enqueue_style('style', plugin_dir_url(__FILE__).'assets/css/front-end.css');		
    wp_enqueue_script('custom', plugin_dir_url(__FILE__).'assets/js/front-end.js', array('jquery'), '1.0', true);


	}
	public function wpa_add_menu(){
		
        add_menu_page( 'Wplogin', 'Wplogin', 'manage_options', 'wplogin-dashboard', array(
                          __CLASS__,
                         'wpa_page_file_path'
                        ), '','2.2.9');

        add_submenu_page('wplogin-dashboard', 'wplogin Dashboard', '<span class="dashicons dashicons-dashboard"></span><span class="admin_mt">Dashboard</span>', 'manage_options', 'wplogin-dashboard', array(__CLASS__, 'wpa_page_file_path'));
		
	}


}
new Wplogin();




// agent Registration form with sortcode
function wp_reg_form() {
?>
<h3 class="cp_arform-title"> Registration</h3>

<form id="add-new-agent" method="post" action="#" enctype="multipart/form-data">

   <div class="cp_arform-field">
       <label>User Name</label>
       <input required="required" class="arname" id="agentname" name="agentname" type="text"/>
   </div>
   <div class="cp_arform-field">
       <label>Email</label>
       <input required="required" class="aremail" id="agentemail" name="agentemail" type="email"/>
   </div>
   <div class="cp_arform-field">
       <label>Password</label>
       <input class="arpass" id="password" name="agentpass" type="password" required="required" />
   </div>
   <div class="cp_arform-field">
       <label>Repeat Password</label>
       <input class="arpass" id="confirm_password" name="arpassrepeat" type="password" required="required" />
   </div>
   <div class="arform-bottom">
       <input id="itemsave" type="submit" name="register" value="Submit"/>
   </div> 
</form>

<script type="text/javascript">


    jQuery( document ).ready(function() {



                var password = document.getElementById("password")
              , confirm_password = document.getElementById("confirm_password");

            function validatePassword(){


              if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
              } else {
                confirm_password.setCustomValidity('');
              }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;

            });

</script>

<?php

    if(isset($_POST['register'])) {

    global $wpdb;

    $agentname=$_POST['agentname'];
    $agentemail=$_POST['agentemail'];
    $agentpass=$_POST['agentpass'];
    $agentphone=$_POST['agentphone'];
    $agentcompany=$_POST['agentcompany'];



    $userdata = array(
                    'user_login' =>  $agentname,
                    'user_email' => $agentemail,
                    'user_pass' =>  $agentpass,
                    'role' => 'editor'
                );
                $user_id = wp_insert_user( $userdata );
       

    }
 }
add_shortcode('wpregform', 'wp_reg_form');



ob_start();
function wpl_form() {

?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
  <div class="login-form">
    <div class="form-group cp_arform-field">
      <input name="login_name" type="text" class="form-control login-field" value="" placeholder="Username" id="login-name" />
      <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
    <div class="form-group cp_arform-field">
      <input  name="login_password" type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" />
      <label class="login-field-icon fui-lock" for="login-pass"></label>
    </div>
    <div class="arform-bottom">
    <input class="btn btn-primary btn-lg btn-block" type="submit"  name="wpl_submit" value="Log in" />
    </div>
</form>
</div>
<?php
}

function wpl_auth( $username, $password ) {
global $user;
$creds = array();
$creds['user_login'] = $username;
$creds['user_password'] =  $password;
$creds['remember'] = true;
$user = wp_signon( $creds, false );
if ( is_wp_error($user) ) {
echo $user->get_error_message();
}
if ( !is_wp_error($user) ) {

wp_redirect(home_url('wp-admin'));
}
}

function wpl_process() {
if (isset($_POST['wpl_submit'])) {
  wpl_auth($_POST['login_name'], $_POST['login_password']);
}

wpl_form();
}


function wplogin_shortcode() {
ob_start();
wpl_process();
return ob_get_clean();
}

add_shortcode('wp_login_form', 'wplogin_shortcode');
