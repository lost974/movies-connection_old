<div class="name">Modifier votre profil :</div>
<?php echo form::open_multipart('user/edit_profil/'.$user->username); ?>
<table>
	<tr>
		<td class="img"><?php echo html::image('images/user.png');?></td>
		<td class="label">Pseudo :</td>
		<td class="value"><?php echo $user->username; ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/cadenas.gif');?></td>
		<td class="label">Mot de passe :</td>
		<td class="value"><?php echo form::password("old_password",""); ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/cadenas.gif');?></td>
		<td class="label">Nouveau mot de passe :</td>
		<td class="value"><?php echo form::password("new_password",""); ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/cadenas.gif');?></td>
		<td class="label">Retaper le mot de passe :</td>
		<td class="value"><?php echo form::password("new_password_confirm",""); ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/email.gif');?></td>
		<td class="label">Adresse email :</td>
		<td class="value"><?php echo $user->email; ?></td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/avatar_min.gif');?></td>
		<td class="label">Avatar :</td>
		<td class="value"><?php $avatar = $user->display_avatar($user->id); 
								echo $avatar.'<br />';
								echo form::upload('avatar'); ?>
			</td>
	</tr>
	<tr>
		<td class="img"><?php echo html::image('images/eye.png');?></td>
		<td class="label">Confidentialite :</td>
		<td class="value">En construction</td>
	</tr>
</table>
<?php echo form::submit('submit', 'Modifier');
echo form::close();?>