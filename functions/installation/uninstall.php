<?php



/*  VID{ONE} UNINSTALL
/*---------------------------*/
	
	function vidone_uninstall()
		{
			
			/*WORDPRSS DATABASE*/	
				global $wpdb;			
			
			/*VIDTOK DROP TABLE*/
				vidone_drop_tables($wpdb->prefix); 
				
			/*DELETE OPTIONS*/
				$existing_options = get_option('vidone_options');
				
				delete_option('vidone_options');
			
			/*TRACK INSTALLATION*/
				$domain	= DOMAIN;
				$url	= 'http://vidtok.co/vidone/deactivate';
				$args	= array('method' => 'POST', 'body' => array('domain' => $domain));
				
				wp_remote_post($url, $args);  	

			
		}
	
		
/*  VID{ONE} DROP TABLES
/*---------------------------*/

	function vidone_drop_tables($prefix)
		{
			
			/*WORDPRSS DATABASE*/	
				global $wpdb;					
			
			/*DROP VIDTOK ACCOUNT*/
				$wpdb->query( $wpdb->prepare( 'DROP TABLE ' . $prefix . 'vidone_sessions' ));
				
			
		}




		