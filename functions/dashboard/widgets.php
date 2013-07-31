<?php


/* VID{ONE} WIDGET 
/*---------------------------*/

	function vidone_widget()
		{
			
			/*REGISTER WIDGET*/
				register_widget('Vidone_widget'); 
			
		}

/*  DEFINE CLASS EXTENDS
/*---------------------------*/

	class Vidone_widget extends WP_Widget {
		
		/*CONSTRUCTOR*/
			function __construct ()
				{
					
					/*PARENT CONTRUCTOR*/
						parent::__construct('vidone_widget', 'vid{one}: Widget', array('description' => 'The vid{one} widget allows you to host live private 1:1 video chats within your WordPress website.'));
			
				}
		
		/*WIDGET*/
			function widget($args, $instance){
				
				/*REGISTER SCRIPT*/
					wp_register_script('vidone_widget', VIDONE_PLUGINFULLURL.'js/vidtok-vidone-widget-v1.0.min.js', array('jquery')); 
				
				/*LOCALIZE SCRIPT*/
					wp_localize_script('vidone_widget', 'vidoneAjax', array('ajaxurl' => admin_url('admin-ajax.php')));	 
				
				/*REQUIRE JQUERY*/
					wp_enqueue_script('jquery');
				
				/*REQUIRE VID{ONE} WIDGET SCRIPT*/	 
					wp_enqueue_script('vidone_widget');					

				/*DISPLAY WIDGET*/
				
					/*WIDGET START*/		
						echo $before_widget;                

					/*CONTENT*/	
						include_once(VIDONE_PLUGINFULLDIR.'widget.php');
						
					/*WIDGET END*/
						echo $after_widget;  
			
			}
	
	}  