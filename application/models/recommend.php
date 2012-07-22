<?php defined('SYSPATH') OR die('No direct access allowed.');

class Recommend_Model extends ORM {

	
	protected $belongs_to = array('user','movie', 'friend'=>'user');
	
	
}