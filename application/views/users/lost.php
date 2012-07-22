<h2>
<?php echo html::anchor('/', "< Retour a l'accueil"); ?>
</h2>
<div id="block">
<div id="name_block">
<?php
if($content == "password") echo "Mot de Passe" ;
elseif($content == "activate") echo "Lien d'Activation";
?> Perdu ?</div>
<?php echo form::open('user/lost/'.$content); ?>
<table>
	<tr>
		<td class="label">Pseudo :</td>
		<td class="value"><?php echo form::input('username',''); ?></td>
	</tr>
	<tr>
		<td class="label">Adresse email :</td>
		<td class="value"><?php echo form::input('email',''); ?></td>
	</tr>
</table>
<?php echo form::submit('submit', 'Valider');
	echo form::close();?>
</div>
