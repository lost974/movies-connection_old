<div id="movies_added">
	<div class="name">Deniers Films ajoutés :</div>
	<?php 
	Foreach($movies as $movie)
	{ ?>
		<table class="movie_fiche" style="height: <?php if($islog AND ($moderateur == 1 OR $moderateur == 2)) echo '280px;';
														else { echo '250px;'; }?>">
			<tr>
				<td>
				<?php 
				$display_image = $movie->display_image();
				echo html::anchor('movie/view/'.$movie->id, $display_image);
				?>
				</td>
			</tr>
			<tr>
				<td>
				<?php 
				echo html::anchor('movie/view/'.$movie->id, $movie->title);
				?>
				</td>
			</tr>
			<?php 
			if($islog AND ($moderateur == 1 OR $moderateur == 2))
			{ ?>
				<tr>
					<td> <?php
						echo html::anchor('movie/edit/'.$movie->id, html::image('images/edit.gif'));
						if($moderateur == 2)
						{
							echo html::anchor('movie/delete/'.$movie->id, html::image('images/delete.png')); 
						} ?>
					</td>
				</tr>
			<?php
			}	?>
		</table>
	<?php
	} ?>
</div>
<div id="movies_right">
	<?php
	if($islog AND ($moderateur == 1 OR $moderateur == 2))
	{
		echo '<spann class="bouton">'.html::anchor('movie/add', 'Ajouter').'</spann><br />';
	}
	echo html::anchor('movie/alphabetic', 'Rechercher par ordre alphabetique');
	?>

</div>
<div class="clear"></div>


<?php
echo '<div class="pagination" >';
echo $pagination->render('digg');
echo '</div>';
?>