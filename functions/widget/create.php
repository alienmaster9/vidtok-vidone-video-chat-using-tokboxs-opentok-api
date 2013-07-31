<?php
	
	function vidone_create_session()
		{

			/*WORDPRESS DATABAE*/
				global $wpdb;
				
			/*VARIABLES*/	
				$vid		= rand(10,99).'-'.rand(100,999).'-'.rand(10,99);
		
			/*OPENTOK LIBRARY*/
				require_once(VIDONE_PLUGINFULLDIR.'libs/opentok-sdk/OpenTokSDK.php');
				require_once(VIDONE_PLUGINFULLDIR.'libs/opentok-sdk/API_Config.php');			
			
			/*CREATE SESSION*/
				$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
				
				$session = $apiObj->createSession($_SERVER["REMOTE_ADDR"]);
				
				$sessionId = $session->getSessionId();
		
			/*CREATE TOKEN*/
				$token 	= $apiObj->generateToken($session_id, RoleConstants::MODERATOR, NULL, NULL);
				
			/*DATABASE VARIABLES*/
				$insert = array();	
				
				$insert['vid'] 					= $vid;
				$insert['opentok_session_id'] 	= $sessionId; 
		
			/*INSERT INTO DATABASE*/
				$wpdb->insert($wpdb->get_blog_prefix() . 'vidone_sessions', $insert);  
				
			/*RESPONSE*/
				echo json_encode(array('vid' => $vid, 'session_id' => $sessionId, 'token' => $token));
		
			/*KILL*/
				die();
		}

		