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

				/*DISPLAY WIDGET*/
				
					/*WIDGET START*/		
						echo $before_widget;                

					/*CONTENT*/	
						include_once(VIDONE_PLUGINFULLDIR.'widget.php');
						
					/*WIDGET END*/
						echo $after_widget;  
			
			}
	
	}  