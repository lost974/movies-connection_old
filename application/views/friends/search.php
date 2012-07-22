<div class="name">
<?php 

echo form::open('friend/search');
echo 'Rechercher un Memebre : ';
echo form::input('username');
echo form::submit('submit', 'Rechercher');
echo form::close();
?>
</div>
<?php
if (count($users) > 0)
{
	echo 'Résultat pour : '.$post_username.'<br /><br />';
	
	?><table>
	<?php
	foreach($users as $u)
	{
		$verify_u = $this->session->get('user');
		if($u->id != $verify_u->id)
		{
			$status = $user->get_status($u);
			?>
			<tr>
				<td class=""><?php echo $u->display_avatar_min($u->id);?></td>
				<td class="member_name"><?php echo html::anchor('user/profil/'.$u->username, $u->username);?></td>
				<td><?php echo $user->display_friend($status, $u);?></td>
			</tr>
			<?php
		}
	}?>
	</table><?php
}
