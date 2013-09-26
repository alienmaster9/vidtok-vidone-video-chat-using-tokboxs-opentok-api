<?php


/*  ADMIN MENU
/*---------------------------*/
	
	function vidone_admin_menu()
		{
			
			/*VARIABLES*/
				$icon_url	= VIDONE_PLUGINFULLURL . 'img/vidtok-admin-logo.png';  
				
			/*ADD SETTINGS GROUP*/
				add_menu_page('vid{one} Settings', 'vid{one} Settings', 'activate_plugins', 'vidone_plugin_settings', 'vidone_account', $icon_url);   

		
		}



/*  VID{ONE} MAIN PAGE
/*---------------------------*/   

	function vidone_account() 
		{ 
		
			/*OPTIONS*/
				$options = get_option('vidone_options');
		
		?>  
			
            <h2 style="margin-bottom:0;">Welcome to Vidtok</h2>
            <cite>-stream video to the world-</cite>  

       	  	<br/><br/>

            <hr/>
            
            <?php if($options['registered'] == 'no'){ ?>
                <h2>Create Vidtok Account</h2>
                <p>To use the Vidtok vid{one} plugin you must regsiter with Vidtok first.</p>
            <?php }else{ ?>
                <h2>Vidtok Account</h2>
                <p>You have successfully registered your Vidtok account. Below you will find your account details.</p>
			<?php } ?>            
            
           	<form method="POST"  action="admin-post.php">
           		<table class="form-table">  
                    <tr valign="top">  
                        <th scope="row" align="right"><label for="fname" style="text-transform:uppercase">First Name</label></th>
                        <td width="10">&nbsp;</td>  
                        <td><input type="text" name="fname" size="32" value="<?php echo esc_html($options['fname']); ?>" autocomplete="off" /></td>
                        <td>&nbsp;</td>  
                    </tr>
                     <tr valign="top">  
                        <th scope="row align="right""><label for="lname" style="text-transform:uppercase">Last Name</label></th>
                        <td width="10">&nbsp;</td>  
                        <td><input type="text" name="lname" size="32" value="<?php echo esc_html($options['lname']); ?>" autocomplete="off" /></td>
                        <td align="left"></td>  
                    </tr>
                    <tr valign="top">  
                        <th scope="row" align="right"><label for="email" style="text-transform:uppercase">Email</label></th>  
                        <td width="10">&nbsp;</td> 
                        <td><input type="text" name="email" size="32" value="<?php echo esc_html($options['email']); ?>" autocomplete="off" /></td>
                        <td align="left"></td>  
                    </tr>
                    <?php if($options['registered'] == 'no'){ ?>
                    <tr valign="top">  
                        <th scope="row" align="right"><label for="password" style="text-transform:uppercase">Password</label></th>
                        <td width="10">&nbsp;</td>  
                        <td><input type="password" name="password" size="32" value="" autocomplete="off" /></td>
                        <td align="left"></td>  
                    </tr>
                    <tr valign="top">  
                        <th scope="row" align="right"></th>
                        <td width="10">&nbsp;</td>  
                        <td><input type="submit" value="Register Account" class="button-primary" style="text-transform:uppercase"/></td>
                        <td align="left"></td>  
                    </tr> 
                    <?php }else{ ?> 
                    <tr valign="top">  
                        <th scope="row" align="right"><label for="vapi" style="text-transform:uppercase">Vidtok API Key</label></th>
                        <td width="10">&nbsp;</td>  
                        <td><input type="text" name="vapi" disabled size="32" value="<?php echo esc_html($options['vapi']); ?>" /></td>
                        <td align="left"></td>  
                    </tr>
                    <?php } ?>                                  
                </table>
                <input type="hidden" name="domain" value="<?php echo DOMAIN; ?>" />  
           		<input type="hidden" name="action" value="save_vidone_options" />
               	<?php wp_nonce_field('vidone'); ?>
           	</form> 
            
            <br/><br/>

            <hr/>
            
            
            <?php if($options['registered'] == 'yes'){ ?>
            
                <h2></h2>
                <p></p>
            
            <?php } ?>
            

		<?php 
 		}



