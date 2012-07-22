<?php 
$user = $this->session->get('user');
if ($user->id > 0)
	{
		echo '<div id="search">';
		echo form::open('movie/search');
		echo form::input('title');
		echo '<span id="search_hide">';
		echo form::submit('submit', '');
		echo '</span>';
		echo form::close();
		echo '</div>';
	}

?>