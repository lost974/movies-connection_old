<?php
$user = $this->session->get('user');
if ($user->id != 0)
	{
		echo '<div id="logout" class="transition">';
		echo html::anchor('user/logout', 'Déconnexion');
		echo "</div>";
	}

	
?>