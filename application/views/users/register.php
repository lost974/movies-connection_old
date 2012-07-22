<?php echo html::anchor('/', "< Retour a l'accueil"); ?>
<div class="name">Inscription :</div>
<?php echo form::open('user/register'); ?>
<div class="erreur">
<?php
if($pb_username_use == 1)
{
	echo "- Ce pseudo est déjà prit par un autre membre";
	echo "<br />";
}
if($pb_username == 1)
{
	echo "- Ce pseudo n'est pas valide";
	echo "<br />";
}
if($pb_password == 1)
{
	echo "- Ce mot de passe n'est pas valide";
	echo "<br />";
}
if($pb_email == 1)
{
	echo "- Cette adresse email n'est pas valide";
	echo "<br />";
}
?>
</div>
<table>
	<tr>
		<td class="img"><?php echo html::image('images/user.png');?></td>
		<td class="label">Pseudo :</td>
		<td class="value"><?php echo form::input('username',''); ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/cadenas.gif');?></td>
		<td class="label">Mot de passe :</td>
		<td class="value"><?php echo form::password("password",""); ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/cadenas.gif');?></td>
		<td class="label">Retaper le mot de passe :</td>
		<td class="value"><?php echo form::password("password_confirm",""); ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/email.gif');?></td>
		<td class="label">Adresse email :</td>
		<td class="value"><?php echo form::input('email',''); ?></td>
	</tr>
</table>
<?php echo form::submit('submit', 'Inscription');
	echo form::close();?>