<?php

	
/*  VID{ONE} INSTALLATION
/*---------------------------*/

	function vidone_install()
		{
			
			/*GLOBALS*/
				global $wpdb;
				global $current_user;
			
			/*CRATE DATABASE TABLES*/
				vidone_create_tables($wpdb->get_blog_prefix());
				
			/*TRACK INSTALLATION*/
				$domain	= DOMAIN;
				$url	= 'http://vidtok.co/vidone/activate';
				$args	= array('method' => 'POST', 'body' => array('domain' => $domain));
				
				wp_remote_post($url, $args); 

			/*VARIABLES*/
				$user	 	= get_currentuserinfo();
				$data	 	= get_userdata($current_user->ID);
				
				$fname 		= ucwords(strtolower($current_user->user_firstname)); 
				$lname 		= ucwords(strtolower($current_user->user_lastname));
				$email 		= strtolower($current_user->user_email); 
				$password	= $data->user_pass; 

			/*CHECK IF TO ALLOW*/
				if(($email != '') && ($password != '')){ 
			
					/*REGISTER*/	
						$domain		= DOMAIN;
						$reg_url	= 'http://vidtok.co/vidone/register';
						$args		= array('method' => 'POST', 'body' => array('fname' => $fname, 'lname' => $lname, 'email' => $email, 'password' =>$password, 'domain' => $domain));
						
						$response = wp_remote_post($reg_url, $args);
					
					/*VARIABLES*/	
						$url 		= 'http://vidtok.co/vidone/get_account?email='.$email; 
						
					/*GET ACCOUNT*/           	
						if(ini_get('allow_url_fopen')) {

							$content 	= file_get_contents($url);
							$json		= json_decode($content, true);
						
						}else{
						
							$ch = curl_init(); 
							$timeout = 0; 
							curl_setopt ($ch, CURLOPT_URL, $url); 
							curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
							$content = curl_exec($ch); 
							$json		= json_decode($content, true);
							curl_close($ch); 
						
						}

					/*STORE VALUES IN OPTION ARRAY*/		
						$update = array('vapi' => $json['vapi'], 'registered' => 'yes', 'fname' => $fname, 'lname' => $lname, 'email' => $email);  
											
					/*UPDATE OPTIONS*/				
						update_option('vidone_options', $update);
				  
				}

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
