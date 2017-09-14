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
		add_action( 'admin_enqueue_scripts', array($this,'add_script'));
		add_action( 'wp_enqueue_script',array($this,'add_frontend_scripts'));
	}
	public function add_script(){

	}
	public function add_frontend_scripts(){

	}
	public function wpa_add_menu(){
		
	}

}
new Wplogin();