<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Model extends ORM {

//if ($user->is_friend_with($user2) ) echo true
//if (User_Model::are_friends($user1, $user2) ) echo true;

	protected $has_many = array('events','marks','events','friends', 'critiques','recommend', 'moviesaw','follow');
	
	/*
	 * Retourne le statut de la relation d'amiter avec un autre utilisateur.
	 * @param	$user	l'utilisateur
	 * @return			statut de la relation
	 */
	public function get_status($user)
	{
		//Ici $this = user car on est dans le model user.
		$followings = ORM::factory('follow')
			->where('user_id', $this->id)
			->where('following_id', $user->id)
			->find();
		
		if(empty($followings->status)) $status = 0;
		
		elseif($followings->status == 1) $status = 1;
		
		return $status;
	}
	
	/*
	 * Retourne la liste d'utilisateur qui ont des demandes avec un autre utilisateur.
	 * @param	$user	l'utilisateur
	 * @return			list de la relation
	 */
	public function get_Followers()
	{
		$followers = ORM::factory('follow')
			->where('following_id', $this->id)
			->where('status', 1)
			->find_all();
			
		$res = array();
		foreach($followers as $follower)
		{
			$res[] = ORM::factory('user', $follower->user_id);
		}
		
		return $res;
	}
	
	/*
	 * Retourne un lien pour faire evoluer la relation d'amiter avec un autre utilisateur.
	 * @param	$status		Le statut de la relation
	 *			$u			l'utilisateur
	 * @return				un lien ou une phrase
	 */
	public function display_friend($status, $u)
	{
		$message_friend ='';
		if($status == 0)
		{
			$message_friend = html::anchor('friend/add/'.$u->id, 'Suivre');
		}
		elseif($status == 1)
		{
			$message_friend = 'Déjà abonné';
		}
		elseif($status == 2)
		{
			$message_friend = 'En attente';
		}
		elseif($status == 3)
		{
			$message_friend = html::anchor('friend/confirm/'.$u->id, 'Confirmer la demande en  Ami');
		}
		return $message_friend;
	}
	
	/* $friends =  $user->get_friends(); // users
	 * Retourne la liste d'amis du user.
	 * @return				une liste d'amis
	 */
	public function get_followings()
	{
		$followings = ORM::factory('follow')
			->where('user_id', $this->id)
			->where('status', 1)
			->find_all();
			
		$res = array();
		foreach($followings as $following)
		{
			$res[] = ORM::factory('user', $following->following_id);
		}
		
		return $res;
	}
	
	public function display_avatar($user_id)
	{
		$user = ORM::factory('user')
			->where('id', $user_id)
			->find();
			
		if ($user->avatar != "0")
		{
			$avatar = html::image('upload/users/avatar/'.$user->avatar);
		}
		else
		{
			$avatar = html::image('images/noavatar.jpg');
		}
		return $avatar;
	}
	
	public function display_avatar_min($user_id)
	{
		$user = ORM::factory('user')
			->where('id', $user_id)
			->find();
			
		if ($user->avatar != "0")
		{
			$avatar = html::image(array('src' => 'upload/users/avatar/'.$user->avatar, 'width' => '50', 'height' => '50'));
		}
		else
		{
			$avatar = html::image(array('src' => 'images/noavatar.jpg', 'width' => '50', 'height' => '50'));
		}
		return $avatar;
	}
	

}