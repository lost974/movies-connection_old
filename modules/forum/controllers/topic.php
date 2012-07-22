<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Topic Controller - Gestion des topics
 *
 * @author     Menencia
 * @copyright  (c) 2010
 */
class Topic_Controller extends Template_Controller 
{

	/**
	 * Vue de toutes les catégories du forum (all)
	 * ou d'une catégorie particulière.
	 * 
	 * @param $type	Type du forum
	 * @param $page	Format de page (par défault: null)
	 * @param $num	Numéro de page (par défaut: 1)
	 * @return void
	 */
	public function index($type='all', $page=null, $num=1) 
	{
		$user = $this->session->get('user');
		
		if ($type == 'all')
		{
			// On recherche les 10 derniers topics non privés
			$last_topics = ORM::factory('topic')
				->where('type !=', 'private')
				->orderby(array('main_sticky'=>'desc', 'updated'=>'desc'))
				->find_all(10);
			
			$view->last_topics = $last_topics;
			
			// On construit les informations de chaques catégories
			$types = Kohana::config('forum.types');
			foreach ($types as $type => $locked)
			{
				if ($type != 'private')
				{
					$topics = ORM::factory('topic')
						->where('type', $type)
						->find_all();
					
					$nbr_comments = 0;
					foreach($topics as $topic)
					{
						$nbr_comments += count($topic->comments);
					}
					
					$tmp = array();
					$tmp['type'] = $type;
					$tmp['nbr_topics'] = count($topics);
					$tmp['nbr_comments'] = $nbr_comments;
					$categories[] = $tmp;
				}
			}
			
			$view = new View('topics/main');
			$view->last_topics = $last_topics;
			$view->categories = $categories;
		}
		else
		{
			// On redirige si l'utilisateur non connecté regarde dans un topic privé.
			if ($type == 'private' and ! $user->loaded)
			{
				url::redirect('forum');
			}
			
			// On construit la pagination
			$page_name = Kohana::config('forum.page_name');
			$topics_per_page = Kohana::config('forum.topics_per_page');
			$pagination_format = Kohana::config('forum.pagination_format');
			
			if ($type == 'private')
			{
				$nbr_topics = ORM::factory('flow')
					->where('user_id', $user->id)
					->where('deleted', 0)
					->count_all();
			}
			else
			{ 
				$nbr_topics = ORM::factory('topic')
					->where('type', $type)
					->count_all();
			}
			
			$pagination = new Pagination(array(
		  		'uri_segment' 		=> $page_name, 
		    	'total_items' 		=> $nbr_topics, 
		    	'items_per_page' 	=> $topics_per_page, 
		    	'style' 			=> $pagination_format
			));
			
			// On recherche les topics
			if ($type == 'private')
			{
		    	$flows = ORM::factory('flow')
					->where('user_id', $user->id)
					->where('deleted', 0)
					->find_all($topics_per_page, ($num-1)*$topics_per_page);
				$topics = array();
				foreach ($flows as $flow) 
				{
					$topics[] = $flow->topic;
		    	}
		    } 
		    else
		    {
		    	$topics = ORM::factory('topic')
		    		->where('type', $type)
		    		->limit($topics_per_page, ($num-1)*$topics_per_page)
		    		->orderby(array('main_sticky'=>'desc', 'updated'=>'desc'))
		    		->find_all();
	    	}
	    	
	    	$types = Kohana::config('forum.types');
	    	$locked = $types[$type];
	    	
	    	// On lance la vue
			$view = new View('topics/index');
			$view->locked = $locked;
			$view->topics = $topics;
			$view->pagination = $pagination;
		}
		
		$view->type = $type;
		$view->user = $user;
		$this->template->content = $view;
	}
	
	/**
	 * Voir un topic du forum
	 * 
	 * @param $id	Identifiant du topic
	 * @param $page	Marqueur de page (par défault: null)
	 * @param $num	Numéro de page
	 * @return void
	 */
	public function view($id, $page=null, $num=1) 
	{
		$user = $this->session->get('user');
		
		$topic = ORM::factory('topic', $id);
		
		// On regarde si l'utilisateur a le droit d'y accéder
		if ( ( ! $user->loaded and $topic->type == 'private') 
			or ($user->loaded 
				and $topic->type == 'private' 
				and !$topic->is_moderator($user)) 
			)
    	{
    		url::redirect('forum');
    	}
    	
    	// On supprime les notfications du forum lié à l'utilisateur
		if ($user->loaded) $topic->delete_notifs($user);
		
		// On initialise le formulaire pour envoyer un nouveau commentaire
		$form = array(
			'content' => ''
		);
		$errors = $form;
		
		// Procédure pour gérer l'envoi d'un commentaire
		if ($_POST) 
		{
			$post = new Validation($_POST);
    	    $post->pre_filter('trim', TRUE);
            $post->add_rules('content', 'required');
        	
        	if ($post->validate()) 
        	{
				$comment = ORM::factory('comment');
				$comment->topic_id = $id;
				$comment->user_id = $user->id;
				$comment->content = $post->content;
				$comment->save();
				
				$comment->topic->updated = time();
				$comment->topic->save();
				
				// update flows
				foreach ($comment->topic->flows as $flow) 
				{
					$flow->deleted = 0;
					$flow->save();
				}
				
				// create topic notifications
				$topic->add_notifs();
				
				// redirect
				$link = ($topic->type == 'private') ? "letter/" : "forum/topic/";
				url::redirect($topic->get_url_last_comment($link));
            } 
            else 
            {
                $form = arr::overwrite($form, $post->as_array());
                $errors = arr::overwrite($errors, $post->errors('form_error_messages'));
            }
		}
		
		// pagination
		$page_name = Kohana::config('forum.page_name');
		$nbr_comments = ORM::factory('comment')->where('topic_id', $id)->count_all();
		$comments_per_page = Kohana::config('forum.comments_per_page');
		$pagination_format = Kohana::config('forum.pagination_format');
		
		$pagination = new Pagination(array(
		    'uri_segment' 		=> $page_name, 
		    'total_items' 		=> $nbr_comments, 
		    'items_per_page' 	=> $comments_per_page, 
		    'style' 			=> $pagination_format
		));
		
		$comments = ORM::factory('comment')
			->where('topic_id', $id)
			->find_all($comments_per_page, ($num-1)*$comments_per_page);
			
		$view 						= new View('topics/view');
		$view->topic 				= $topic;
		$view->comments 			= $comments;
		$view->user 				= $user;
		$view->form 				= $form;
		$view->pagination 			= $pagination;
		$this->template->content 	= $view;
	}
	
	/**
	 * Edit a topic
	 * 
	 * @access public
	 * @param int $id. (default: 0)
	 * @param mixed $type. (default: null)
	 * @return void
	 */
	public function edit($id=0, $type=null) 
	{
		// user
		$user = $this->session->get('user');
		
		// topic
		$topic = ORM::factory('topic')->find($id);
		$comment = ORM::factory('comment');
		
		// access
		if ( ! $user->loaded
			or ($topic->type == 'private' 
				and ! $topic->is_moderator($user)) )
		{
    		url::redirect('forum');
		}
		
		// form
		$form = array(
			'level' 		=> '',
			'status' 		=> '',
			'sticky' 		=> '',
			'main_sticky' 	=> '',
			'title' 		=> '',
			'locked' 		=> '',
			'update' 		=> '',
			'users' 		=> '',
			
			'user_id' 	=> '',
			'content' 		=> ''
		);
		$errors = $form;
		$form = arr::overwrite($form, $topic->as_array());
		
		// special default values
		if ($id > 0) 
		{
			$comment = $topic->comments[0];
			$form['user_id'] = $comment->user_id;
			$form['content'] = $comment->content;
			$type = $topic->type;
		}
		else
		{
			$form['user_id'] 	= $user->id;
		}
		
		// edit topic
		if ($_POST) 
		{
			$post = new Validation($_POST);
    	    $post->pre_filter('trim', TRUE);
            $post->add_rules('title', 'required');
            $post->add_rules('content', 'required');
            
            // 'private' conditions
            if ($type == 'private') 
            {
            	$post->add_rules('users', 'required');
            	$post->add_callbacks('users', array($this, '_valid_users'));
            }
        	
        	if ($post->validate()) 
        	{
        		// new topic
        		$topic->type 		= $post->type;
                $topic->level 		= $post->level;
                $topic->status 		= $post->status;
                $topic->sticky 		= (isset($post->sticky)) ? 1 : 0;
                $topic->main_sticky = (isset($post->main_sticky)) ? 1 : 0;
                $topic->title 		= $post->title;
                $topic->locked 		= (isset($post->locked)) ? 1 : 0;
                if ($id == 0) $topic->updated = time();
                $topic->save();
				
				// new comment
				$comment->topic_id 	= $topic->id;
				$comment->user_id = $user->id;
				$comment->content 	= $post->content;
				$comment->save();
				
				// 'update' operations
				if (isset($post->update)) 
				{
					$this->db->update(
		   				'users', 
		   				array('version' => 0),
		   				array('version' => 1)
		   			);
				}
				
				// 'private' operations
				if ($type == 'private') 
				{
					$user_ids = $post->users;
					$user_ids[] = $user->id;
					
					foreach ($user_ids as $user_id) 
					{
						$flow = ORM::factory('flow');
						$flow->user_id = $user_id;
						$flow->topic_id = $topic->id;
						$flow->deleted = 0;
						$flow->save();
					}
				}
				
				// create topic notification
				$topic->add_notifs();
				
				$link = ($type == 'private') ? "letter/" : "forum/topic/";
				
                // redirection
                url::redirect($link.$topic->id);
            } 
            else 
            {
                $form = arr::overwrite($form, $post->as_array());
                $errors = arr::overwrite($errors, $post->errors('form_error_messages'));
            }
		}
		
		// list_types
		$levels = $topic->list_levels($type);
		$status = $topic->list_status($type);
		$types = array_keys(Kohana::config('forum.types'));
		foreach ($types as $t)
		{
			if ($t != 'private')
			{
				$list_types[$t] = Kohana::lang("forum.types.$t.title");
			}
		}
		
		// Construction de la vue
		$view 						= new View('topics/edit');
		$view->user 				= $user;
		$view->topic 				= $topic;
		$view->list_types 			= $list_types;
		$view->type 				= $type;
		$view->levels				= $levels;
		$view->status				= $status;
		$view->form 				= $form;
		$view->errors 				= $errors;
		$this->template->content 	= $view;
	}
	
	/**
	 * Delete a topic
	 * 
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function delete($id)
    {
    	$this->authorize('modo');
    	
    	$user = $this->session->get('user');
    	$topic = ORM::factory('topic')->find($id);
    	
    	// nbr_flows
    	$nbr_flows = ORM::factory('flow')
    		->where('topic_id', $id)
   			->where('deleted', 0)
   			->count_all();
   		
   		// self delete
   		if ($nbr_flows >= 2)
   		{
   			$this->db->update(
   				'flows', 
   				array('deleted' => 1),
   				array(
   					'user_id' => $user->id, 
   					'topic_id' => $id
   				)
   			);
   		}
   		// all delete
   		else
   		{
   			ORM::factory('topic')->delete($id);
   		}
   			
   		$link = ($topic->type == 'private') ? "letter" : "forum";
    	
    	// Redirection
    	url::redirect($link);
    }
	
	/**
	 * Checks topic participants
	 * 
	 * @access public
	 * @param mixed Validation $array
	 * @param mixed $field
	 * @return void
	 */
	public function _valid_users(Validation $array, $field) 
	{
        $res = true;
        foreach ($array[$field] as $user_id) 
        { 
        	$user = ORM::factory('user')->find($user_id);
        	if ( ! $user->loaded) 
        	{
        		$res = false;
        	}
        }
        if (!$res) 
        {
        	$array->add_error($field, 'users_not_valid');
        }
    }
    
    /**
     * Autocompletion for 'private' topic
     * 
     * @access public
     * @return void
     */
    public function autocompletion()
    {
    	$user = $this->session->get('user');
    	
    	$users = ORM::factory('user')
    		->where('username !=', $user->username)
    		->orderby('username', 'asc')
    		->find_all();
    	
    	$response = array();
    	
    	$search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';

		foreach ($users as $user)
		{
			$username = $user->username;
			$response[] = array(
				'caption'=>$username, 
				'value'=>$user->id, 
			);
		}
    	
    	header('content-type: application/json');
    	$this->auto_render = false;
		echo json_encode($response);
    }
    
    /**
     * Generate 'update' feed (rss)
     * 
     * @access public
     * @return void
     */
    public function rss_updates()
	{
		$info = array(
			'title' 		=> 'Chocobo Riding - Mises à jour',
			'link'			=> 'http://chocobo-riding.menencia.com',
			'description' 	=> "Fil RSS des mises à jour de Chocobo Riding.");
		$items = array();
		
		$topics = ORM::factory('topic')
			->where('theme_id', 1)
			->where('status', 0)
			->orderby('created', 'desc')
			->find_all(20);
		
		foreach ($topics as $topic)
		{
		   	$comment = $topic->comments[0];
		   	
		   	$items[] = array(
		   		'title'			=> $topic->title,
		    	'link' 			=> 'http://chocobo-riding.menencia.com/topic/view/'.$topic->id,
		    	'guid' 			=> 'http://chocobo-riding.menencia.com/topic/view/'.$topic->id,
		    	'description' 	=> nl2br($comment->content),
		    	//'author' 		=> $post->user->username,
		    	'pubDate' 	=> date('D\, j M Y H\:i\:s ', $topic->created)."+0400"
		    );
		}
		
		echo feed::create($info, $items);
		$this->profiler = null;
        $this->auto_render = false;
        header("content-type: application/xml");
	}
	
}
