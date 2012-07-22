<div id="wall_left">
	<?php echo $user->display_avatar($user->id); ?>
</div>
<div id="wall_right">
	<div class="name">Mur d'Activités</div>
	<?php 
	foreach($events as $e)
	{
		$ligne = $e->display_event($e);
		echo $ligne;
	}
	?>
</div>
<div class="clear"></div>
<div class="pagination" ><?php echo $pagination->render('digg'); ?></div>