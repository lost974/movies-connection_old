<?php
$user = $this->session->get('user');
if ($user->id > 0)
	{
		echo "<span id='menu_principal' class='transition'>";
		//echo html::image('images/news.png');
		echo html::anchor('page/news', 'News');
		
		//echo html::image('images/movie.png');
		echo html::anchor('movie/index', 'Films');
		
		//echo html::image('images/mur.png');
		echo html::anchor('friend/wall', 'Mur');

		//echo html::image('images/profil.gif');
		echo html::anchor('user/profil/'.$user->username, $user->username);

		echo html::anchor('friend/members', 'Membres');
		
		/*$moderateur = $this->moderateur();
		if($moderateur == 2)
		{
			echo html::anchor('user/admin', 'Admin');
		}*/

		echo "</span>";
	}
else
{
	echo "<span id='menu_principal' class='transition'>";
	
	echo html::anchor('/', 'Accueil');
	
	echo html::anchor('movie/index', 'Films');


	echo "</span>";
}
?>
