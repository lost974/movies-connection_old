<h3>
<?php
echo html::anchor('movie/index'," << Revenir a l'index des films");
?>
</h3>
<div id="block">
<?php
echo '<div id="name_block">Résultat pour : ';
echo $post_title;
echo '</div>';
foreach($movies as $movie)
{ ?>
	<div class="mini_fiche_film">
		<div class="mini_fiche_film_img">
			<?php
			$display_image = $movie->display_image();
			echo html::anchor('movie/view/'.$movie->id, $display_image);
			?>
			<br />
		</div>
		<div class="mini_fiche_film_titre">
			<?php
			echo html::anchor('movie/view/'.$movie->id, $movie->title);
			?>
								
		</div>
	</div>

<?php
	
}
?>
<div class="clear"></div>
</div>