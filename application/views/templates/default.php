<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<?php echo new View('elements/idevice'); ?> 

	<head>
		<title>| MoviesConnection BETA |</title>
		<link rel="icon" type="image/png" href="../images/favicon.png" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<! font google>
		<link href='http://fonts.googleapis.com/css?family=Prosto+One' rel='stylesheet' type='text/css'>
		<?php echo new View('elements/css');?>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		   <?php 
				$this->site('open');
				$this->user_connect();
		       
				echo html::script('js/autocomplete/jquery.autocomplete.pack.js'); 
				echo html::stylesheet('js/autocomplete/jquery.autocomplete.css', 'screen', false);
		       
				echo html::script('js/jquery.bubbletip.js'); 
				echo html::stylesheet('js/bubbletip/bubbletip.css', 'screen', false);
				
				echo html::script('js/jgrowl/jquery.jgrowl_minimized.js'); 
				echo html::stylesheet('js/jgrowl/jquery.jgrowl.css', 'screen', false);
				
				echo html::script('js/script.js');
		   ?>
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-21224705-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		  
		  var baseUrl = "<?php echo (IN_PRODUCTION ? 'http://'.$_SERVER['SERVER_NAME'].'/' : "http://localhost:8888/MoviesConnection/www/"); ?>";
		</script>
	</head>
	
	<body>
	
		<?php echo new View('elements/jgrowl');	 ?>
		<div id="en_tete">
		 <div id="beta_etiquette"></div> <div id="beta_texte">Beta</div> <div id="beta_shadow"></div>
			<div class="marginAuto">
				<div id="banniere"></div>
				<div id="menu">
					<?php echo new View('elements/first_menu');
					echo new View('elements/search');?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="shadow"></div>
		<div id="corps"> 
				<?php echo $content; ?>
			<div class="clear"></div>
		</div>
		<?php 
		$user = $this->session->get('user');
		if ($user->id > 0)
		{
			?>
			<div id="pied_de_page">        
				<?php echo new View('elements/logout'); ?>    
			</div>
		<?php } ?>
	</body>

</html>