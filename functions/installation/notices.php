<?php


/*  VID{ONE} ACTIVATION SETTINGS NOTICE
/*---------------------------*/
	
	function vidone_settings_notice()
		{
			
			/*OPTIONS*/
				$options = get_option('vidone_options');
			
			/*MESSAGES*/
				if($options['registered'] == 'no'){ 
					 
					/*VIDTOK API KEY NEEDED*/
						echo '<div class="error"><p><strong>VIDTOK REGISTRATION REQUIRED</strong><br/> You will need to register with Vidtok before using the vid{one} video chat plugin. Go to your <a href="options-general.php?page=vidone_plugin_settings">Plugin Settings Page</a> and enter your information.</p></div>';
					
				}

		}
	























