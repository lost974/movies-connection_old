<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller extends Controller_Core {

	public $template = "templates/default";

	// Variable de classe (à quoi se sert)
	// get -> prendre
	// set -> mettre
	public $session;
	
	// Initialise ou reprend la session
	// Initialise ou reprend la variable de session 'user'
	public function __construct() 
	{
		parent::__construct();
		
		// Session : sac de variables
		
		// On regarde si la session existe
		// si elle existe on la reprend telquel (les autres fois qu'on visite la page)
		// et si elle existe pas, on la crée (la première fois qu'il visite la page)
		// la session est un ensemble de variables
		$this->session = Session::instance(); // new Session()
		
		$this->db = Database::instance();
		
		// On prend le contenu de la variable user qui est dans la session
		$user = $this->session->get('user'); // $_SESSION['user']
		
		// tu prends la langue ds la session
		// Tuparamètres la lague : $this->locale();
		// $lang = $this->session->get('locale');
		//Kohana::config_set('locale', $lang);
		
		// On voit si la variable user prise est vide ou pleine
		// Si elle est vide, alors on la crée
		if ($user ==  NULL)
		{
			$user = ORM::factory('user'); // user - id=0, name=, password=
			// on modifie le contenu de la variable user (qui est dans la session) par $user
			$this->session->set('user', $user);
		}
	}
	
	public function authorize()
	{
		$user = $this->session->get('user');
		if ($user->id == 0)
		{
			url::redirect('page/home');
		}
		
	}
	
	public function islog()
	{
		$user = $this->session->get('user');
		return $user->id != 0;
	}
	
	public function get_user()
	{
		$user = $this->session->get('user');
		return $user;
	}
	
	public function moderateur()
	{
		$user = $this->session->get('user');
		$moderateur = $user->moderateur;
		return $moderateur;
		
	}
	
	public function site()
	{
		$site = ORM::factory('maintenance')->where('id', '1')->find();
		$user = $this->session->get('user');
		if ($site->open == 0)
		{
			if($user->id != '1')
			{
				url::redirect('page/maintenance');
			}
		}
		
	}
	
	public function user_connect()
	{
		$user = $this->session->get('user');
		if ($user->id > 0)
		{
			$u = ORM::factory('user')->where('id', $user->id)->find();
			$u->actif = time();
			$u->save();
		}
		
	}
}