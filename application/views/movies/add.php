<div id="block">
<div id="name_block">Ajouter un film :</div>
<?php
echo form::open_multipart('movie/add');
?>
<table>
	<tr>
		<td class="label">Titre du film :</td>
		<td class="value"><?php echo form::input('title',''); ?></td>
	</tr>
	<tr>
		<td class="label">Date de sortie :</td>
		<td class="value"><?php echo form::input('release',''); ?></td>
	</tr>
	<tr>
		<td class="label">Genre :</td>
		<td class="value"><?php echo form::dropdown('genre_id', $genres, 'Inconnu'); ?></td>
	</tr>
	<tr>
		<td class="label">Affiche :</td>
		<td class="value"><?php echo form::upload('image'); ?></td>
	</tr>
	<tr>
		<td class="label">Synopsis :</td>
		<td class="value"><?php echo form::textarea(array('name'=>'synopsis','rows'=>'10','cols'=>'100')); ?></td>
	</tr>
	<tr>
		<td class="label">Bande annonce Youtube :<br /> (Pas de video => Laisser le zéro)</td>
		<td class="value"><?php echo 'http://www.youtube.com/watch?v='.form::input("b_a","0"); ?></td>
	</tr>
</table>
<?php 
echo form::submit('submit', 'Ajouter');
echo form::close();
?>
</div>