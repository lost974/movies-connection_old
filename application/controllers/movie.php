<?php defined('SYSPATH') OR die('No direct access allowed.');

class Movie_Controller extends Template_Controller {

	public function index()
	{
		//$this->authorize('logged_in');
		$islog = $this->islog();
		$movies = ORM::factory('movie')
			->orderby('id', 'DESC')
			->find_all(29);
			
		$nbr_movies = ORM::factory('movie')
			->count_all();
		
		$view = new View('movies/index');
		if($islog)
		{
			$moderateur = $this->moderateur();
			$view->moderateur = $moderateur;
		}
		$view->islog = $islog;
		$view->movies = $movies;
		$view->nbr_movies = $nbr_movies;
		$this->template->content = $view;
	}
	
	public function all($page=null,$number=1)
	{
		$islog = $this->islog();
		
		$nbr_movies = ORM::factory('movie')
			->orderby('id', 'DESC')
			->count_all();
			
		$items_per_page = 50;
		
		$movies = ORM::factory('movie')
			->orderby('id', 'DESC')
			->find_all($items_per_page,($number-1)*$items_per_page);
		
		$pagination = new Pagination(array(
		    'uri_segment'    => 'page', 
		    'total_items'    => $nbr_movies,
		    'items_per_page' => $items_per_page, 
		    'style'          => 'digg' 
			));
			
		$view = new View('movies/all');
		if($islog)
		{
			$moderateur = $this->moderateur();
			$view->moderateur = $moderateur;
		}
		$view->islog = $islog;
		$view->pagination = $pagination;
		$view->movies = $movies;
		$this->template->content = $view;
		
	}
	
	public function view($id)
	{
		//$this->authorize('logged_in');
		
		$islog = $this->islog();
		
		$movie = ORM::factory('movie')->find($id);
		
		$mark = ORM::factory('mark');
		
		if($islog)
		{
			$user = $this->session->get('user');
			$mark = ORM::factory('mark')
					->where('user_id', $user->id)
					->where('movie_id', $id)
					->find();
					
			$critique_u = ORM::factory('critique')
				->where('movie_id', $id)
				->where('user_id', $user->id)
				->orderby('id','DESC')
				->find();
				
			$movie_saw = ORM::factory('moviesaw')
				->where('user_id', $user->id)
				->where('movie_id', $id)
				->find();
				
			$intention_u = ORM::factory('intention')
				->where('user_id', $user->id)
				->where('movie_id', $id)
				->find();
				
			$followings = $user->get_followings();
			$following_marks = array();
			$following_moviesaw = array();
			foreach($followings as $following)
			{
				$following_mark = ORM::factory('mark')
					->where('user_id', $following->id)
					->where('movie_id', $id)
					->find();
				
				if($following_mark->loaded)
				{
					$following_marks[] = $following_mark;
				}
						
				$moviesaw = ORM::factory('moviesaw')
						->where('user_id', $following->id)
						->where('movie_id', $id)
						->find();
				
				if($moviesaw->loaded)
				{
					$following_moviesaw[]=$following->username;
				}
			
			}
			
			$followers = $user->get_followers();
			$followers_ad = array();
			foreach($followers as $follower)
			{
				$intention = ORM::factory('intention')
						->where('user_id', $follower->id)
						->where('movie_id', $id)
						->find();
						
				$recommend = ORM::factory('recommend')
					->where('friend_id', $follower->id)
					->where('user_id', $user->id)
					->where('movie_id', $id)
					->find();
				
				$moviesaw = ORM::factory('moviesaw')
						->where('user_id', $follower->id)
						->where('movie_id', $id)
						->find();
						
				if($intention->loaded OR $recommend->loaded OR $moviesaw->loaded) 
				{
				
				}
				else 
				{
					$followers_ad[$follower->id] = $follower->username;
				}
			}
			
			$following_recommend = array();
			$f_recommend = ORM::factory('recommend')
						->where('friend_id', $user->id)
						->where('movie_id', $id)
						->find_all();
			foreach($f_recommend as $f_r)
			{
				$u = ORM::factory('user')->where('id', $f_r->user_id)->find();
				$following_recommend[] = $u->username;
			} 
		}
		
		$critiques = ORM::factory('critique')
			->where('movie_id', $id)
			->orderby('id','DESC')
			->find_all();
		
		$view = new View('movies/view');
		$view->movie = $movie;
		$view->islog = $islog;
		$view->mark = $mark;
		if($islog)
		{
			$view->user = $user;
			$view->following_marks = $following_marks;
			$view->movie_saw = $movie_saw;
			$view->critique_u = $critique_u;
			$view->intention_u = $intention_u;
			$view->following_moviesaw = $following_moviesaw;
			$view->followers_ad = $followers_ad;
			$view->following_recommend = $following_recommend;
		}
		$view->critiques = $critiques;
		$this->template->content = $view;
	}
	
	public function add()
	{
		$this->authorize('logged_in');
		$user = $this->session->get('user');
		$post = new Validation($_POST);
		$post->add_rules('title', 'required');
		$post->add_rules('release', 'required');
		$post->add_rules('synopsis', 'required');
		$files = Validation::factory($_FILES)->add_rules('image', 'upload::valid', 'upload::type[gif,jpg,jpeg,png]', 'upload::size[1M]');
		if ($post->validate() and $files->validate())
		{
			$movie = ORM::factory('movie');
			$movie->title = $post->title;
			$movie->release = $post->release;
			$movie->genre_id = $post->genre_id;
			$movie->synopsis = $post->synopsis;
			$movie->useradd_id = $user->id;
			$movie->b_a = $post->b_a;
			$movie->save();
			
			$filename = upload::save('image');
			if (file_exists($filename)) 
			{
				$name = $movie->id.'.'.substr(strrchr($filename, '.'), 1);
				Image::factory($filename)
					->resize(134, 193, Image::NONE)
					->save(DOCROOT.'upload/movies/posters/'.$name);
				unlink($filename);
				$movie->image = $name;
				$movie->save();
			}
			
			//$this->addJgrowl($message);
			//$message = Kohana::lang('jgrowl.movies_add');
			$message = "Film ajouté avec succès";
			$this->session->set('jgrowl', $message);
			url::redirect('movie/index');
			
		}
		/*else
		{
			$message = "il y a eu une erreur";
			$this->session->set('jgrowl', $message);
		}*/
		
		$genres = array();
		$g = ORM::factory('movies_genre')->find_all();
		foreach($g as $genre)
		{
			$genres[$genre->id]= $genre->name;
		}
		$view = new View('movies/add');
		$view->genres = $genres;
		$this->template->content = $view;
		
	}
	
	public function edit($id)
	{
		$this->authorize('logged_in');
		$post = new Validation($_POST);
		$post->add_rules('title', 'required');
		$post->add_rules('release', 'required');
		$post->add_rules('synopsis', 'required');
		$files = Validation::factory($_FILES)->add_rules('image', 'upload::valid', 'upload::type[gif,jpg,jpeg,png]', 'upload::size[1M]');
		if ($post->validate()and $files->validate())
		{
			$movie = ORM::factory('movie')->find($id);
			
			$filename = upload::save('image');
			if (file_exists($filename)) 
			{
				if ($movie->image != "") 
				{
					unlink('upload/movies/posters/'.$movie->image);
				}
				$name = $movie->id.'.'.substr(strrchr($filename, '.'), 1);
				Image::factory($filename)
					->resize(134, 193, Image::NONE)
					->save(DOCROOT.'upload/movies/posters/'.$name);
				unlink($filename);
				$movie->image = $name;
			}
               
			$movie->title = $post->title;
			$movie->release = $post->release;
			$movie->genre_id = $post->genre_id;
			$movie->synopsis = $post->synopsis;
			$movie->b_a = $post->b_a;
			$movie->save();
			$message = "Film modifié";
			$this->session->set('jgrowl', $message);
			url::redirect('movie/view/'.$id);
			
		}

			// TODO message ajout échec
		
		else	
		{
			$movie = ORM::factory('movie')->find($id);
			$genres = array();
			$g = ORM::factory('movies_genre')->find_all();
			foreach($g as $genre)
			{
				$genres[$genre->id]= $genre->name;
			}
			$view = new View('movies/edit');
			$view->movie = $movie;
			$view->genres = $genres;
			$this->template->content = $view;
		}
	}
	
	public function delete($id)
	{
		$movie = ORM::factory('movie')->find($id);
		$mark = ORM::factory('mark')->where('movie_id', $id)->find_all();
		$moviesaw = ORM::factory('moviesaw')->where('movie_id', $id)->find_all();
		$critique = ORM::factory('critique')->where('movie_id', $id)->find_all();
		foreach($mark as $m)
		{
			$event = ORM::factory('event')->where('type', 1)->where('argument', $m->id)->find();
			$event->delete();
		}
		foreach($moviesaw as $m)
		{
			$event = ORM::factory('event')->where('type', 3)->where('argument', $m->id)->find();
			$event->delete();
		}
		foreach($critique as $m)
		{
			$event = ORM::factory('event')->where('type', 4)->where('argument', $m->id)->find();
			$event->delete();
		}
		$movie->delete();
		url::redirect('movie/index');
	}
	
	public function mark($id, $post_mark)
	{
			$user = $this->session->get('user');
			$mark = ORM::factory('mark');
			$mark->user_id = $user->id;
			$mark->movie_id = $id;
			$mark->mark = $post_mark;
			$mark->save();
			
			$type = '1';
			$argument = $mark->id;
			$event = ORM::factory('event');
			$event->create($user->id, $type, $argument);
			
			$data = array();
			$data['success'] = 'true';
			$data['star'] = $post_mark.'star.png';
			echo json_encode($data);
		    $this->auto_render = false;
		    header('content-type: application/json');
			
	}
	
	public function delete_mark($id)
	{
		$user = $this->session->get('user');
		$mark = ORM::factory('mark')
			->where('movie_id', $id)
			->where('user_id', $user->id)
			->find();
		
		$event = ORM::factory('event')
			->where('type', '1')
			->where('user_id', $user->id)
			->where('arguments', $mark->id)
			->find();
			
		$mark->delete();
		$event->delete();
		
		url::redirect('movie/view/'.$id);
	}
	
	public function add_critique($movie_id)
	{
		$post = new Validation($_POST);
		$post->add_rules('critique', 'required');
		if ($post->validate())
		{
			$user = $this->session->get('user');
			$critique = ORM::factory('critique');
			$critique->user_id = $user->id;
			$critique->movie_id = $movie_id;
			$critique->critique = $post->critique;
			$critique->save();
			
			$event = ORM::factory('event');
			$type = '4';
			$argument = $critique->id;
			$event->create($user->id, $type, $argument);
		}
		url::redirect('movie/view/'.$movie_id);
	}
	
	public function delete_critique($id)
	{
		$user = $this->session->get('user');
		$critique = ORM::factory('critique')
			->where('id', $id)
			->where('user_id', $user->id)
			->find();
		$movie_id = $critique->movie_id;
		$critique->delete();
		url::redirect('movie/view/'.$movie_id);
	}
	
	public function moviesaw($movie_id)
	{
		$user = $this->session->get('user');
		$moviesaw = ORM::factory('moviesaw');
		$moviesaw->user_id = $user->id;
		$moviesaw->movie_id = $movie_id;
		$moviesaw->save();
		
		$event = ORM::factory('event');
		$type = '3';
		$argument = $moviesaw->id;
		$event->create($user->id, $type, $argument);
		
		$intention = ORM::factory('intention')
			->where('user_id', $user->id)
			->where('movie_id', $movie_id)
			->find();
		if($intention->loaded)
		{
			$intention->delete();
		}
		
		$recommend = ORM::factory('recommend')
			->where('movie_id', $movie_id)
			->where('friend_id', $user->id)
			->find_all();
		if($recommend != null)
		{
			foreach($recommend as $r)
			{
				$r->delete();
			}
		}
		
		$data = array();
		$data['success'] = 'true';
		echo json_encode($data);
        $this->auto_render = false;
        header('content-type: application/json');
	}
	
	public function intention($movie_id)
	{
		$user = $this->session->get('user');
		$intention = ORM::factory('intention');
		$intention->user_id = $user->id;
		$intention->movie_id = $movie_id;
		$intention->save();
		
		$recommend = ORM::factory('recommend')
			->where('movie_id', $movie_id)
			->where('friend_id', $user->id)
			->find_all();
		if($recommend != null)
		{
			foreach($recommend as $r)
			{
				$r->delete();
			}
		}
		$data = array();
		$data['success'] = 'true';
		$data = json_encode($data);
		echo $data;
        $this->auto_render = false;
        header('content-type: application/json');
	}
	
	public function recommend($movie_id)
	{
		$user = $this->session->get('user');
		$post = new Validation($_POST);
		$recommend = ORM::factory('recommend');
		$recommend->user_id = $user->id;
		$recommend->friend_id = $post->friends;
		$recommend->movie_id = $movie_id;
		$recommend->save();
			
		url::redirect('movie/view/'.$movie_id);
	}
	
	public function search()
	{
		$this->authorize('logged_in');
		
		$post = new Validation($_POST);
		$post->add_rules('title', 'required');
		if($post->validate())
		{
			$movies = ORM::factory('movie')
				->like('title', $post->title)
				->find_all(10);
			if (count($movies)==1)
			{
				url::redirect('movie/view/'.$movies[0]->id);
			}
			
			else
			{
				$view = new View('movies/search');
				$view->movies = $movies;
				$view->post_title = $post->title;
				$this->template->content = $view;
			}
		}
		else
		{
			url::redirect('movie/index');
		}
	}
	
	public function alphabetic($letter="A")
	{
		$this->authorize('logged_in');
		
		$movies = ORM::factory('movie')
				->like('title', $letter.'%', FALSE)
				->orderby('title','ASC')
				->find_all();
		$view = new View('movies/alphabetic');
		$view->movies = $movies;
		$view->letter = $letter;
		$this->template->content = $view;
	}
	
	/**
    * Autocompletion
    * 
    */
   public function autocompletion()
   {
       $q = strtolower($_GET["q"]);
       $items = ORM::factory('movie')
           ->orderby('title', 'asc')
           ->like('title', $q)
           ->find_all();
       
       $this->auto_render = false;
   
       $response = "";
       foreach ($items as $item)
       {
           echo $item->title."\n";
       }
   }
   
   public function forceMark()
   {
   		$movies = ORM::factory('movie')->find_all();
   		foreach($movies as $movie)
   		{
   			$marks = ORM::factory('mark')
			->where('movie_id', $movie->id)
			->find_all();
			
			$res = 0;
				
			$total = count($marks);
			
			$mark = array();
			foreach($marks as $m)
			{
				$mark[]= $m->mark;
			}
			
			if($total >= 1)
			{
				$t = array_sum($mark);
				$res = $t / $total;
			}
			
			$nb_vues = ORM::factory('moviesaw')
				->where('movie_id',$movie->id)
				->find_all();
			
			$movie->nb_vues = count($nb_vues);
			
			$movie->moyenne =  $res;
			$movie->nb_mark = $total;
			$movie->save();
   		}
   		$message = "Moyenne mise a jour";
			$this->session->set('jgrowl', $message);
			url::redirect('movie/index');
   		
   }
}