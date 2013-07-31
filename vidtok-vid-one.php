<?php
/*
Plugin Name: 	vid{one} video chat using Tokbox
Plugin URI: 	http://vidtok.co/vidone
Description: 	vid{one} was created to allow WordPress users the ability to create and host 1:1 video chats on their website.
Version: 		1.0
Author: 		the Blacc Spot Media team
Author URI: 	http://blaccspot.com
License: 		GPLv3 http://www.gnu.org/licenses/gpl.html
*/


/*  DEFINE CONSTANTS
/*---------------------------*/	
	
	/*VARIABELS*/
		$url = str_replace('www.', '', parse_url(site_url()));  
	
	/*VERSION*/
		define("VIDONE_VERSION", "1.0");
		
	/*DOMAIN*/	
		define("DOMAIN", $url['host']);
	
	/*PLUGIN PATH*/
		define("VIDONE_PLUGINPATH", "/" . plugin_basename(dirname(__FILE__)) . "/");
	
	/*PLUGIN FULL URL*/
		define("VIDONE_PLUGINFULLURL", trailingslashit(plugins_url(null, __FILE__ )));
	
	/*PLUGIN FULL DIRECTORY*/
		define("VIDONE_PLUGINFULLDIR", WP_PLUGIN_DIR . VIDONE_PLUGINPATH);
		
	/*PLUGIN WWW PATH*/
		define("VIDONE_WWWPATH", str_replace($_SERVER['DOCUMENT_ROOT'], '', VIDONE_PLUGINFULLDIR));	

/* JQUERY
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_enqueue_scripts', 'prefix_load_scripts');
	
	/*REQUIRE 1.9.1*/		
		function prefix_load_scripts() {
			if(is_admin()) return;
		 
			global $wp_scripts;
		 
			if($wp_scripts->registered['jquery']->ver != '1.8.3'){ 
				
				wp_deregister_script( 'jquery' );
				wp_enqueue_script('jquery', 'http://code.jquery.com/jquery-1.8.3.min.js');
				
			}else{
				
				wp_enqueue_script('jquery');
				
			}
		}
	
	
/* ACTIVATION
/*---------------------------*/

	/*INSTALLATION*/
		register_activation_hook(__FILE__,'vidone_install');

	/*PLUGIN ACTIVATION IMPLEMENATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/installation/install.php');
	
	/*ACTIVATION NOTICE*/
		add_action('admin_notices', 'vidone_settings_notice');
		
	/*PLUGIN ACTIVATION IMPLEMENATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/installation/notices.php');



/*  UNINSTALL
/*---------------------------*/
	
	/*PLUGIN REMOVAL*/
		register_deactivation_hook( __FILE__, 'vidone_uninstall' );
	
	/*PLUGIN REMOVAL IMPLEMENATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/installation/uninstall.php');



/*  ADMIN MENUS
/*---------------------------*/
	
	/*ADD VIDTOK ADMIN MENU*/
		add_action('admin_menu', 'vidone_admin_menu');  

	/*VIDTOK ADMIN MENU IMPLEMENTAION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/admin/menu.php');



/* 	ADMIN SETTINGS
/*---------------------------*/

	/*SAVE SETTINGS*/
		add_action('admin_init', 'vidone_admin_options'); 
	
	/*SAVE SETTING IMPLEMENTATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/admin/options.php'); 




/*  WIDGET
/*---------------------------*/
	
	/*OPTIONS*/
		$options = get_option('vidone_options');
		
		if($options['registered'] == 'yes'){
	
			/*ADD VID{ONE} WIDGET*/
				add_action('widgets_init', 'vidone_widget');
				 
			/*WIDGET IMPLEMENATION*/
				include_once(VIDONE_PLUGINFULLDIR.'functions/dashboard/widgets.php'); 
		
		}



/*  AJAX REQEUST :: CREATE SESSION
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_ajax_create_session', 'vidone_create_session');
		add_action('wp_ajax_nopriv_create_session', 'vidone_create_session');
		
	/*CREATE SESSION*/	
		include_once(VIDONE_PLUGINFULLDIR.'functions/widget/create.php');



/*  AJAX REQEUST :: JOIN SESSION
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_ajax_join_session', 'vidone_join_session');  
		add_action('wp_ajax_nopriv_join_session', 'vidone_join_session');
		
	/*CREATE SESSION*/	
		include_once(VIDONE_PLUGINFULLDIR.'functions/widget/join.php'); 



/*  AJAX REQEUST :: INVITE EMAIL
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_ajax_invite_email', 'vidone_invite_email');  
		add_action('wp_ajax_nopriv_invite_email', 'vidone_invite_email');
		
	/*CREATE SESSION*/	
		include_once(VIDONE_PLUGINFULLDIR.'functions/widget/invite.php');   






		
