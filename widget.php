    
    <?php wp_enqueue_style('vidone', plugins_url() . '/vidone/css/vidone.css') ?>
    <?php wp_enqueue_style('bootstrap', plugins_url() . '/vidone/css/bootstrap.min.css') ?>
    
    <?php wp_enqueue_script('tokbox', 'http://static.opentok.com/v1.1/js/TB.min.js') ?>
    <?php wp_enqueue_script('watermark', plugins_url() . '/vidone/js/jquery.watermark.js', array('jquery')) ?>
    <?php wp_enqueue_script('purl', plugins_url() . '/vidone/js/purl.js', array('jquery')); ?>
	<?php wp_enqueue_script('vidtok-vidone', 'http://static.vidtok.co/vidone/v1.0/stable/vidtok.vidone.v1.0.min.js', array('jquery')) ?>  
    
    <script type="text/javascript">
	
		VID						= ''; 
		TOKBOX_SESSION_ID		= '';
		TOKBOX_TOKEN			= '';		
		VIDONE_PLUGIN_URL		= '<?php echo VIDONE_PLUGINFULLURL; ?>';
		VIDONE_INVITE_URL		= "http://<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>?vid="; 
		DOMAIN					= '<?php echo DOMAIN; ?>';  
		VAPI					= '<?php $options = get_option('vidone_options'); echo $options['vapi']; ?>';
 
		function tw_click(e) {
			u = location.href;
			t = document.title; 
			text = "<?php echo urlencode('Join my live video chat! http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>?vid=" + VID + " <?php echo urlencode('Made possible using @vidtok vid{one} Wordpress Plugin.'); ?>";
			window.open("http://twitter.com/intent/tweet?text=" + text, 'sharer', 'toolbar=0,status=0,width=500,height=360'); 
			return false;
		}
		
		function fbs_click() {
			url = '<?php echo urlencode('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>?vid=' + VID;
			title = 'Join my live video chat!';
			image = 'http://vidtok.co/images/logos/vidtok-logo-v-large.png';
			summary = 'Made possible using @vidtok vid{one} Wordpress Plugin.';
			window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + url + '&p[title]=' + title + '&p[summary]=' + summary + '&p[images][0]=' + image, 'sharer', 'toolbar=0,status=0,width=500,height=360');
			return false;
		}
		
    </script>