<?php defined('SYSPATH') OR die('No direct access allowed.');

class Movies_genre_Model extends ORM {

	
	protected $belongs_to = array('movie');
	
	
}