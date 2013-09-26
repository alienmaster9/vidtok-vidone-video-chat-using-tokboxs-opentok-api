<?php

	
/*  VID{ONE} INSTALLATION
/*---------------------------*/

	function vidone_install()
		{
			
			/*WORDPRESS DATABASE*/
				global $wpdb;
			
			/*CRATE DATABASE TABLES*/
				vidone_create_tables($wpdb->get_blog_prefix());
				
			/*TRACK INSTALLATION*/
				$domain	= DOMAIN;
				$url	= 'http://vidtok.co/vidone/activate';
				$args	= array('method' => 'POST', 'body' => array('domain' => $domain));
				
				wp_remote_post($url, $args); 

		}




/*  VID{ONE} CREATE DATABASE TABLES
/*---------------------------*/

	function vidone_create_tables($prefix)
		{
			
			/*WORDPRESS DATABASE*/
				global $wpdb;
			
			/*VIDTOK SESSIONS*/
				$sessions	= "CREATE TABLE IF NOT EXISTS `" . $prefix . "vidone_sessions` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `vid` varchar(18) NOT NULL,
								  `opentok_session_id` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
			
			
			/*VIDTOK SESSIONS*/
				$wpdb->query($sessions);
				
			/*INSERT DATA*/	
				$start_data = array('vid' => '11-111-11', 'opentok_session_id' => '2_MX4yMTQzNjE0Mn43Ni45Ny4zMC4xMjJ-VHVlIEp1bCAzMCAyMjo0MDozNCBQRFQgMjAxM34wLjAwMjcwMjU5Mzh-');
				$wpdb->insert( $wpdb->get_blog_prefix() . 'vidone_sessions', $start_data ); 
	
			/*OPTIONS*/	
				$new_options['version']			= VIDONE_VERSION;
				$new_options['registered'] 		= 'no';
				$new_options['vapi'] 			= '';   
				$new_options['fname'] 			= '';  	
				$new_options['lname'] 			= '';  	
				$new_options['email'] 			= '';  	 		

			/*SET DEFAULT OPTIONS*/
				if(get_option('vidone_options') === false){ 

					/*ADD OPTIONS*/
						add_option('vidone_options', $new_options);
						
				}else{
					
					/*DELETE OPTIONS*/
						$existing_options = get_option('vidone_options');
						
						delete_option('vidone_options');
						
					/*ADD OPTIONS*/
						add_option('vidone_options', $new_options);
					
					
				}

		}
