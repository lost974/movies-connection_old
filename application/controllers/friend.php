<?php defined('SYSPATH') OR die('No direct access allowed.');

class Friend_Controller extends Template_Controller {

	public function wall($page=null,$number=1)
	{
		$this->authorize('logged_in');
		$view = new View('friends/wall');
		$user = $this->get_user();
		$followings = $user->get_followings();
		$events = array();
		foreach($followings as $following)
		{
			$event = ORM::factory('event')
			->where('user_id', $following->id)
			->orderby('id', 'DESC')
			->find_all();

			foreach($event as $e)
			{
				$events[] = $e;
			}
		}
		
		$e_u = ORM::factory('event')
			->where('user_id', $user->id)
			->orderby('id', 'DESC')
			->find_all();
		foreach($e_u as $e)
			{
				$events[] = $e;
			}
		
		arsort($events);//extraire des donne d'un tableau
		$nbr_events = count($events);
		$items_per_page = 40;
		$e_p = array_slice($events, ($number-1)*$items_per_page, $items_per_page);
		
		$pagination = new Pagination(array(
		    'uri_segment'    => 'page', 
		    'total_items'    => $nbr_events,
		    'items_per_page' => $items_per_page, 
		    'style'          => 'digg' 
			));
			
		$view->user = $user;
		$view->events = $e_p;
		$view->pagination = $pagination;
		$this->template->content = $view;
	}
	
	public function search()
	{
		$this->authorize('logged_in');
		$view = new View('friends/search');
		$user = $this->get_user();
		$users = array();
		
		$post = new Validation($_POST);
		$post->add_rules('username', 'required');
		if ($post->validate())
		{
			$users = ORM::factory('user')
				->like('username', $post->username)
				->find_all(10);
			
			$view->post_username = $post->username;
		}
		$view->users = $users;
		$view->user = $user;
		$this->template->content = $view;
	}
	
	public function members()
	{
		$this->authorize('logged_in');
		$view = new View('friends/members');
		$user = $this->get_user();
		$users = ORM::factory('user')
			->find_all();

		$view->users = $users;
		$view->user = $user;
		$this->template->content = $view;
	}
	
	public function add($following_id)
	{
		$this->authorize('logged_in');
		$user = $this->get_user();
		$following = ORM::factory('follow');
		$following->user_id = $user->id;
		$following->following_id = $following_id;
		$following->status = 1;
		$following->updated = time();
		$following->save();
		
		$type = '2';
		$argument = $following->id;
		$event = ORM::factory('event');
		$event->create($user->id, $type, $argument);
		
		url::redirect('friend/wall');
		
	}
	
	public function confirm($u_id)
	{
		$this->authorize('logged_in');
		$user = $this->get_user();
		$friend = ORM::factory('friend')
			->where('friend_id', $user->id)
			->where('user_id', $u_id)
			->find();
		$friend->status = 1;
		$friend->save();
		
		$type = '2';
		$argument = $friend->id;
		$event = ORM::factory('event');
		$event->create($user->id, $type, $argument);
		
		$friend = ORM::factory('friend');
		$friend->user_id = $user->id;
		$friend->friend_id = $u_id;
		$friend->status = 1;
		$friend->updated = time();
		$friend->save();
		
		$type = '2';
		$argument = $friend->id;
		$event = ORM::factory('event');
		$event->create($u_id, $type, $argument);

		url::redirect('friend/wall');
	}
	
}