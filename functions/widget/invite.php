<?php
	
	function vidone_invite_email()
		{
			
			
			/*VARIABLES*/	
				$vid 		= $_POST['vid']; 
				$email  	= $_POST['email'];
				$url		= $_POST['url'];
				$valid 		= validateEmail($email);
				$subject 	= 'Vidtok :: Video Chat Invitation';  
				$message	= "
								
								<h3>vid{one} 1:1 video chat invitation</h3>
								
								<p>You have been invited to video chat by a friend.<br/>
								Click on the following URL to view the conversation.</p>
								
								<strong>" . $url . $vid . "</strong><br/>
								
								<p>To get your very own copy of Vidtok's vid{one} video chat plugin, please visit <a href='http://wordpress.org/plugins/vidtok-vidone-video-chat-using-tokboxs-opentok-api/' target='_blank'>WordPress</a> to download.</p>
								
								<p>Cheers,<br/>
								the Vidtok team</p><br/>
								
								If you have any questions please contact <a href='mailto:support@vidtok.co'>support@vidtok.co</a>.		
		
							";
				
				$headers  = "From: the Vidtok team <messages@vidtok.co>\r\n";
				$headers .= "Reply-To: the Vidtok team <messages@vidtok.co>\r\n";			  
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";			  
				   
			/*Mail*/
				if($valid == 0){
					
					/*RESPONSE*/
						echo json_encode(array('status' => 'invalid', 'vid' => $vid));
					
				}else{
					
					/*SEND MAIL*/
						mail($email, $subject, $message, $headers);
					
					/*RESPONSE*/
						echo json_encode(array('status' => 'valid', 'vid' => $vid));
					
				}
		
			/*KILL*/
				die(); 
		}


/*  VALIDATE EMAIL ADDRESS
/*---------------------------*/

	function validateEmail($email){
		return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
	}
		