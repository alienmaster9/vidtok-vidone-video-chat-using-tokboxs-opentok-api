<?php
	
	
	function vidone_join_session()
		{

			/*OPENTOK LIBRARY*/
				require_once(VIDONE_PLUGINFULLDIR.'libs/opentok-sdk/OpenTokSDK.php');
				require_once(VIDONE_PLUGINFULLDIR.'libs/opentok-sdk/API_Config.php');
				
			/*WORDPRESS DATABAE*/
				global $wpdb;
				
			/*VARIABLES*/	
				$vid		= $_POST['vid']; 
		
			/*QUERY*/				
				$query = 'select * from ' . $wpdb->get_blog_prefix() . "vidone_sessions WHERE vid = %s"; 
				
				$vidone = $wpdb->get_row($wpdb->prepare($query, $vid)); 
				
			/*RESULT*/	
				if($vidone != false){
				
					/*CREATE TOKEN*/
						$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET); 
				
						$token = $apiObj->generateToken($vidone->opentok_session_id);
					
					/*RESPONSE*/
						echo json_encode(array('status' => 'exists', 'vid' => $vid, 'session_id' => $vidone->opentok_session_id, 'token' => $token));	
				
				}else{
					
					/*RESPONSE*/
						echo json_encode(array('status' => 'non-existing', 'vid' => $vid)); 
					
					
				}

			/*KILL*/
				die();
		
		}
	
	
		