<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Controller extends Template_Controller {

	// url/user/login
	public function login()
	{
		// actions
		$valid = new Validation($_POST);
		if ($valid->username and $valid->password)
		{
			$user = ORM::factory('user')
				->where('username', $valid->username)
				->where('password', sha1($valid->password))
				->find();
			if ($user->id >0)
			{
				if($user->activate == "1")
				{
					$this->session->set('user', $user);
					$nbr_connection = $user->nbr_connection + 1;
					$user->nbr_connection = $nbr_connection;
					$user->last_connection = time();
					$user->save();
				}
				else
				{
					$message = 'Compte non activé, un mail vous a été envoyé.';
					$this->session->set('jgrowl', $message);
					url::redirect('page/home');
				}
			}
			else
			{
				$message = 'Pseudo ou Mot de passe invalide';
				$this->session->set('jgrowl', $message);
				url::redirect('page/home');
			}
			
		}
		
		url::redirect('page/news');
	}
	
	public function logout()
	{
		$this->session->delete('user');
		url::redirect('/');
	}
	
	public function activate($uniqid)
	{
		$users = ORM::factory('user')->where('activate','0')->find_all();
		foreach($users as $user)
		{
			$key = sha1($user->username.$user->activate_key);
			if($key == $uniqid)
			{
				$user->activate = "1";
				$user->save();
				$message = 'Compte activé.';
				$this->session->set('jgrowl', $message);
			}
		}
		url::redirect('page/home');
	}
	
	public function lost($content)
	{
		$valid = new Validation($_POST);
		$valid->add_rules('username', 'required');
		$valid->add_rules('email','required', array('valid','email'));
		if ($valid->validate())
		{
			if($content == "password")
			{
				$user = ORM::factory('user')
					->where('username', $valid->username)
					->where('email', $valid->email)
					->find();
				if($user->loaded)
				{
					$uniqid = uniqid();
					$password = sha1($uniqid);
					$user->password = $password;
					$user->save();
					$to      = $user->email; 
					$from    = 'mail@lost974.com';
					$subject = 'Movies Connection';
					$message = "Votre nouveau mot de passe sur Movies Connection, <br /><br /> Votre Pseudo : ".$user->username."<br /> Votre nouveau mot de passe : ".$uniqid.'<br /><br />Lien du site  : movies-connection.lost974.com';
					 
					email::send($to, $from, $subject, $message, TRUE);
					$message = 'Votre mot de passe a bien été changé, vous recevrez un nouveau dans un mail.';
					$this->session->set('jgrowl', $message);
				}
			}
			if($content == "activate")
			{
				$user = ORM::factory('user')
					->where('username', $valid->username)
					->where('email', $valid->email)
					->where('activate', "0")
					->find();
				if($user->loaded)
				{
					$uniqid = uniqid();
					$activate_key = sha1($user->username.$uniqid);
					$user->activate_key = $uniqid;
					$user->save();
					$to      = $user->email; 
					$from    = 'mail@lost974.com';
					$subject = 'Movies Connection';
					$message = "Votre nouvelle clé d'activation sur Movies Connection, <br /><br /> Votre Pseudo : ".$user->username."<br /> Votre nouveau lien d'activation : movies-connection.lost974.com/user/activate/".$activate_key.'<br /><br />Lien du site  : movies-connection.lost974.com';
					 
					email::send($to, $from, $subject, $message, TRUE);
					$message = "Votre nouvelle clé d'activation a été envoyé dans un mail.";
					$this->session->set('jgrowl', $message);
				}
			}
			url::redirect('page/home');
		}
		else
		{
			$view = new View('users/lost');
			$view->content = $content;
			$this->template->content = $view;
		}
	}
	
	public function register()
	{
		$pb_username_use = 0;
		$pb_username = 0;
		$pb_password = 0;
		$pb_email = 0;
		$username = 0;
		$password = 0;
		$email = 0;
		$user = ORM::factory('user');
		$post1 = new Validation($_POST);
		$post1->add_rules('username', 'required');
		if ($post1->validate())
		{
			$post1->add_rules('username', 'length[4,12]', 'alpha_numeric');
			if ($post1->validate())
			{
				$check = ORM::factory('user')->where('username', $post1->username)->find();
				if($check->loaded)
				{
					$pb_username_use = 1;
				}
				else
				{
					$username = 1;
					$user->username = $post1->username;
				}
			}
			else
			{
				$pb_username = 1;
			}
		}
		$post2 = new Validation($_POST);
		$post2->add_rules('password', 'required');
		if ($post2->validate())
		{
			$post2->add_rules('password', 'matches[password_confirm]');
			if ($post2->validate())
			{
				$password = 1;
				$user->password = sha1($post2->password);
			}
			else
			{
				$pb_password = 1;
			}
		}
		$post3 = new Validation($_POST);
		$post3->add_rules('email', 'required');
		if ($post3->validate())
		{
			$post3->add_rules('email', array('valid','email'));
			if ($post3->validate())
			{
				$email = 1;
				$user->email = $post3->email;
			}
			else
			{
				$pb_email = 1;
			}
		}
		if ($username == 1 AND $password == 1 AND $email == 1)
		{
			$uniqid = uniqid();
			$user->activate_key = $uniqid;
			//$user->save();
			$key = sha1($user->username.$uniqid);
			
			$to      = $user->email;
			$from    = 'mail@lost974.com';
			$subject = 'Movies Connection';
			$message = "Bienvenue sur Movies Connection, <br /><br />Votre Pseudo : ".$user->username." <br /><br />Voici le lien d'activation : movies-connection.lost974.com/user/activate/".$key."<br /><br />Lien du site  : movies-connection.lost974.com";
			email::send($to, $from, $subject, $message, TRUE);
			
			$message = 'Inscription effectuée';
			$this->session->set('jgrowl', $message);
			url::redirect('page/home');
		}
		else
		{
			//$message = "Erreur lors de l'inscription";
			//$this->session->set('jgrowl', $message);
		}
		
		$view = new View('users/register');
		$view->pb_username_use = $pb_username_use;
		$view->pb_username = $pb_username;
		$view->pb_password = $pb_password;
		$view->pb_email = $pb_email;
		$this->template->content = $view;
		
	}
	
	// user/profil/12
	public function profil($username)
	{ 
		$this->authorize('logged_in');
		
		$user = ORM::factory('user')->where('username', $username)->find();
		$user_u = 0;
		$u_s = $this->session->get('user');
		if($user->id == $u_s->id) $user_u = 1;
		
		$marks1 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 1)
				->orderby('ID','DESC')
				->find_all(4);
		$marks2 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 2)
				->orderby('ID','DESC')
				->find_all(4);
		$marks3 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 3)
				->orderby('ID','DESC')
				->find_all(4);
		$marks4 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 4)
				->orderby('ID','DESC')
				->find_all(4);
		$marks5 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 5)
				->orderby('ID','DESC')
				->find_all(4);
		
		$moviesaws = ORM::factory('moviesaw')
				->where('user_id', $user->id)
				->orderby('ID','DESC')
				->find_all();
				
		$moviesaw = array();
		$nbr = 0;
		foreach($moviesaws as $m)
		{
			$mark = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('movie_id', $m->movie_id)
				->find_all();
			
			if(count($mark) == 0 AND $nbr < 4)
			{
				$moviesaw[] = $m;
				$nbr++;
			}
		}
				
		$intention = ORM::factory('intention')
				->where('user_id', $user->id)
				->find_all(4);
				
		$recommend = ORM::factory('recommend')
				->where('friend_id', $user->id)
				->find_all();
		
		$events = ORM::factory('event')
			->where('user_id', $user->id)
			->orderby('id', 'DESC')
			->find_all(10);
			
		$view = new View('users/profil');
		$view->user = $user;
		$view->user_u = $user_u;
		$view->followings = $user->get_followings();
		$view->followers = $user->get_followers();
		//$view->movies = $movies;
		$view->marks1 = $marks1;
		$view->marks2 = $marks2;
		$view->marks3 = $marks3;
		$view->marks4 = $marks4;
		$view->marks5 = $marks5;
		$view->moviesaw = $moviesaw;
		$view->intention = $intention;
		$view->recommend = $recommend;
		$view->events =$events;
		$this->template->content = $view;
		
		
	}
	
	public function edit_profil($username)
	{
		$this->authorize('logged_in');
		
		$user = ORM::factory('user')->where('username', $username)->find();
		$u_s = $this->session->get('user');
		if($user->id == $u_s->id)
		{
			$post1 = new Validation($_POST);
			$post1->add_rules('password', 'matches[password_confirm]');
			if ($post1->validate())
			{
				if(sha1($post1->old_password) == $user->password)
				{
					$user->password = sha1($post1->new_password);
					$user->save();
					$message = 'Le mot de passe a été modifié.';
					$this->session->set('jgrowl', $message);
				}
			}
			$post2 = new Validation($_POST);
			$files = Validation::factory($_FILES)->add_rules('avatar', 'upload::valid', 'upload::type[gif,jpg,jpeg,png]', 'upload::size[1M]');
			if ($files->validate())
			{
				$filename = upload::save('avatar');
				if (file_exists($filename)) 
				{
					if ($user->avatar != "0") 
					{
						unlink('upload/users/avatar/'.$user->avatar);
					}
					$name = $user->id.'.'.substr(strrchr($filename, '.'), 1);
					Image::factory($filename)
						->resize(80, 80, Image::NONE)
						->save(DOCROOT.'upload/users/avatar/'.$name);
					unlink($filename);
					$user->avatar = $name;
					$user->save();
				}
			}
			
			$view = new View('users/edit_profil');
			$view->user = $user;
			$this->template->content = $view;
			
		}
		else
		{
			url::redirect('user/profil/'.$u_s->username);
		}
	}
	
	public function profil_movie($username)
	{
		$this->authorize('logged_in');
		
		$user = ORM::factory('user')->where('username', $username)->find();
		$user_u = 0;
		$u_s = $this->session->get('user');
		if($user->id == $u_s->id) $user_u = 1;
		
		$marks1 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 1)
				->orderby('ID','DESC')
				->find_all();
		$marks2 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 2)
				->orderby('ID','DESC')
				->find_all();
		$marks3 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 3)
				->orderby('ID','DESC')
				->find_all();
		$marks4 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 4)
				->orderby('ID','DESC')
				->find_all();
		$marks5 = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('mark', 5)
				->orderby('ID','DESC')
				->find_all();
		
		$moviesaws = ORM::factory('moviesaw')
				->where('user_id', $user->id)
				->orderby('ID','DESC')
				->find_all();
				
		$nbr_moviesaw = count($moviesaws);
				
		$moviesaw = array();
		foreach($moviesaws as $m)
		{
			$mark = ORM::factory('mark')
				->where('user_id', $user->id)
				->where('movie_id', $m->movie_id)
				->find_all();
			
			if(count($mark) == 0)
			{
				$moviesaw[] = $m;
			}
		}
				
		$intention = ORM::factory('intention')
				->where('user_id', $user->id)
				->find_all();
				
		$recommend = ORM::factory('recommend')
				->where('friend_id', $user->id)
				->find_all();
				
		$view = new View('users/profil_movie');
		$view->user = $user;
		$view->user_u = $user_u;
		$view->followings = $user->get_followings();
		$view->followers = $user->get_followers();
		//$view->movies = $movies;
		$view->marks1 = $marks1;
		$view->marks2 = $marks2;
		$view->marks3 = $marks3;
		$view->marks4 = $marks4;
		$view->marks5 = $marks5;
		$view->moviesaw = $moviesaw;
		$view->nbr_moviesaw = $nbr_moviesaw;
		$view->intention = $intention;
		$view->recommend = $recommend;
		$this->template->content = $view;
	}

}