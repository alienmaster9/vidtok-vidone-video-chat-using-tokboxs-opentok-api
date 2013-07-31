<?php


/*  ADMIN INIT 
/*---------------------------*/

	function vidone_admin_options(){
		
		/*ADD ACTION*/	
			add_action('admin_post_save_vidone_options', 'procss_vidone_options');
		
	}



/*  VID{ONE} SETTINGS
/*---------------------------*/
	
	function procss_vidone_options() 
		{
			
			/*VARIABLES*/
				$fname 		= ucwords(strtolower($_POST['fname'])); 
				$lname 		= ucwords(strtolower($_POST['lname']));
				$email 		= strtolower($_POST['email']); 
				$valid 		= preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
				$password	= $_POST['password']; 

			/*CHECK IF TO ALLOW*/
				if(($email != '') && ($password != '') && ($valid != 0)){ 
			
					/*REGISTER*/	
						$domain		= DOMAIN;
						$reg_url	= 'http://vidtok.co/vidone/register';
						$args		= array('method' => 'POST', 'body' => array('fname' => $fname, 'lname' => $lname, 'email' => $email, 'password' =>$password, 'domain' => $domain));
						
						$response = wp_remote_post($reg_url, $args);
					
					/*VARIABLES*/	
						$url 		= 'http://vidtok.co/vidone/get_account?email='.$email; 
						
					/*GET ACCOUNT*/           	
						if( ini_get('allow_url_fopen') ) {

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
				  
			/*REDIRECT*/	
				wp_redirect(add_query_arg(array('page' => 'vidone_plugin_settings', 'message' => '1'), admin_url('options-general.php')));  
				
			/*EXIT FUNCTION*/	
				exit;					
					
					
		}

