<?
$user = $this->session->get('user');
if ($user->id == 0)
	{?>
		<div id='log'>
			<div id='login'>
				<?php echo form::open('user/login'); ?>
					<div class="name">Connexion</div>
					<table>
						<tr>
							<td>Pseudo</td>
							<td><?php echo form::input('username','');?></td>
						</tr>
						<tr>
							<td>Mot de Passe</td>
							<td><?php echo form::password('password','');?></td>
						</tr>
						<tr>
							<td></td>
							<td><?php echo form::submit('submit', 'Connexion');
								echo form::close();?></td>
						</tr>
					</table>
					<span id="lost">
						<?php echo html::anchor('user/lost/password',"J'ai perdu mon mot de passe"); ?>
					<br />
						<?php echo html::anchor('user/lost/activate',"J'ai perdu mon lien d'activation");?>
					</span>
			</div>
			<div id='register'>
				<div class="name transition"><?php echo html::anchor('user/register',"Inscription"); ?></div>
			</div>
		</div>
	<?php
	}
?>