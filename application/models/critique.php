<?php defined('SYSPATH') OR die('No direct access allowed.');

class Critique_Model extends ORM {

	
	protected $belongs_to = array('user','movie', 'event');
	
	
}