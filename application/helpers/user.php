<?php defined('SYSPATH') OR die('No direct access allowed.');

class User extends user_core {

	public function friend_helper($status)
	{
		$u->username = 0;
		if($status == 0)
		{
			$message_friend = html::anchor('friend/add/'.$u->username, Ajouter comme Ami);
		}
		elseif($status == 1)
		{
			$message_friend = 'Ami';
		}
		elseif($status == 2)
		{
			$message_friend = 'En attende de confirmation';
		}
		return $message_friend;
	}

}