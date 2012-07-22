<?php defined('SYSPATH') OR die('No direct access allowed.');

class Page_Controller extends Template_Controller {

	// url/pages/home
	public function home()
	{
		$user = $this->session->get('user');
		if ($user->id == 0)
		{
			$view = new View('pages/home');
			
			$this->template->content = $view;
		}
		else
		{
			url::redirect('page/news');
		}
	}
	
	public function news()
	{
		$this->authorize('logged_in');
		$user = $this->get_user();
		$moderateur = $this->moderateur();
		$last_news = ORM::factory('news')
			->orderby('id','DESC')
			->find_all(10);

		$view = new View('pages/news');
		$view->news = $last_news;
		$view->moderateur = $moderateur;
		$view->user = $user;
		$this->template->content = $view;
	}
	
	public function comment_news($id)
	{
		$this->authorize('logged_in');
		$user = $this->get_user();
		$post = new Validation($_POST);
		$post->add_rules('comment', 'required');
		if ($post->validate())
		{
			$comment = ORM::factory('news_comment');
			$comment->user_id = $user->id;
			$comment->news_id = $id;
			$comment->comment = $post->comment;
			$comment->save();	
		}
		url::redirect('page/news');
	}
	
	public function addnews()
	{
		//this->authorize (Lost974);
		$this->authorize('logged_in');

		// NON Verifier !! 
		$post = new Validation($_POST);
		$post->add_rules('title', 'required');
		$post->add_rules('version', 'required');
		$post->add_rules('content', 'required');
		if ($post->validate())
		{
			$news = ORM::factory('news');
			$news->title = $post->title;
			$news->version = $post->version;
			$news->content = $post->content;
			$news->save();
			
			// TODO messgae ajout succès
			url::redirect('page/news');
			
		}
		else
		{
			// TODO message ajout échec
		}

		$view = new View('pages/addnews');
		
		$this->template->content = $view;
	}
	
	public function editnews($id)
	{
		$this->authorize('logged_in');
		
		$post = new Validation($_POST);
		$post->add_rules('title', 'required');
		$post->add_rules('version', 'required');
		$post->add_rules('content', 'required');
		if ($post->validate())
		{
			$news = ORM::factory('news')->find($id);
               
			$news->title = $post->title;
			$news->version = $post->version;
			$news->content = $post->content;
			$news->save();
			// TODO messgae ajout succès
			url::redirect('page/news');
			
		}

		$view = new View('pages/editnews');
		$news = ORM::factory('news')->find($id);
		$view->news = $news;		
		$this->template->content = $view;
	}
	
	public function deletenews($id)
	{
		$movie = ORM::factory('news')->find($id);
		$movie->delete();
		url::redirect('page/news');
	}
	
	public function maintenance()
	{
		$view = new View('pages/maintenance');
		$this->template = new View('templates/closed');
		$this->template->content = $view;
	}
	
	/*public function locale($lang)
	{
		// Changement de lang ds la session->set('locale')
		// redirect
	}*/
	
	public function testajax()
	{
		
		$movies = ORM::factory('movie')->find_all(1);
		foreach($movies as $m)
			$res[$m->id] = $m->title;
		
		// header
		header('Content-type: application/json');
		$this->auto_render = false;
		echo json_encode($res);
	}

}