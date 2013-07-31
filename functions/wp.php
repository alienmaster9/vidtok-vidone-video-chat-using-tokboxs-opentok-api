<?php


/*  SET UP WORDPRESS FOR VID{ONE}
/*---------------------------*/

	function wp_set()
		{
			
			/*UPDATE JQUERY*/
				add_action('wp_enqueue_scripts', 'prefix_load_scripts');
				
			/*REGISTER SCRIPT*/
				wp_register_script('vidone_widget', VIDONE_PLUGINFULLURL.'js/vidtok-vidone-widget-v1.1.min.js'); 
			
			/*LOCALIZE SCRIPT*/
				wp_localize_script('vidone_widget', 'vidoneAjax', array('ajaxurl' => admin_url('admin-ajax.php')));	 
			
			/*ENQUEUE JQUERY*/
				wp_enqueue_script('jquery'); 
			
			/*ENQUEUE VID{ONE} WIDGET*/	 
				wp_enqueue_script('vidone_widget');	
				
				wp_enqueue_style('vidone', plugins_url() . '/vidtok-vidone-video-chat-using-tokboxs-opentok-api/css/vidone.css'); 
				wp_enqueue_style('bootstrap', plugins_url() . '/vidtok-vidone-video-chat-using-tokboxs-opentok-api/css/bootstrap.min.css'); 
				
				wp_enqueue_script('tokbox', 'http://static.opentok.com/v1.1/js/TB.min.js'); 
				wp_enqueue_script('watermark', plugins_url() . '/vidtok-vidone-video-chat-using-tokboxs-opentok-api/js/jquery.watermark.js', array('jquery'));
				wp_enqueue_script('purl', plugins_url() . '/vidtok-vidone-video-chat-using-tokboxs-opentok-api/js/purl.js', array('jquery')); 
				wp_enqueue_script('vidtok-vidone', 'http://static.vidtok.co/vidone/v1.0/stable/vidtok.vidone.v1.0.min.js', array('jquery'));
			
			
			
		}


/*  REQUIRE JQUERY 1.8.3
/*---------------------------*/		

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
	
