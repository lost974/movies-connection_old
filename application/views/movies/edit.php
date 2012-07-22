<div id="block">
<div id="name_block">Modifier : <?php echo $movie->title; ?></div>
<?php
echo form::open_multipart('movie/edit/'.$movie->id);
?>
<table>
	<tr>
		<td class="label">Titre du film :</td>
		<td class="value"><?php echo form::input('title', $movie->title); ?></td>
	</tr>
	<tr>
		<td class="label">Date de sortie :</td>
		<td class="value"><?php echo form::input("release", $movie->release); ?></td>
	</tr>
	<tr>
		<td class="label">Genre :</td>
		<td class="value"><?php echo form::dropdown('genre_id', $genres, $movie->display_genre($movie->genre_id)); ?></td>
	</tr>
	<tr>
		<td class="label">Affiche :</td>
		<td class="value"><?php echo form::upload('image'); ?></td>
	</tr>
	<tr>
		<td class="label">Synopsis :</td>
		<td class="value"><?php echo form::textarea(array('name'=>'synopsis','value'=>$movie->synopsis,'rows'=>'10','cols'=>'100')); ?></td>
	</tr>
	<tr>
		<td class="label">Bande annonce Youtube :<br /> (Pas de video => Mettre un zéro)</td>
		<td class="value"><?php echo 'http://www.youtube.com/watch?v='.form::input("b_a", $movie->b_a); ?></td>
	</tr>
</table>
<?php 
echo form::submit('submit', 'Editer');
echo form::close();
?>
</div>