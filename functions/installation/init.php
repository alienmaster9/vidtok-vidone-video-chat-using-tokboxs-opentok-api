<?php


	function vidone_init_script()
		{
			
			/*REGISTER SCRIPT*/
				wp_register_script('vidone_widget', VIDONE_PLUGINFULLURL.'js/vidtok-vidone-widget-v1.0.min.js', array('jquery')); 
			
			/*LOCALIZE SCRIPT*/
				wp_localize_script('vidone_widget', 'vidoneAjax', array('ajaxurl' => admin_url('admin-ajax.php')));	 
			
			/*REQUIRE JQUERY*/
				wp_enqueue_script('jquery');
			
			/*REQUIRE VID{ONE} WIDGET SCRIPT*/	 
				wp_enqueue_script('vidone_widget');  
				 
		
		}