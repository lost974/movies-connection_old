<?php defined('SYSPATH') OR die('No direct access allowed.');

class Friend_Model extends ORM {

	
	protected $belongs_to = array('friend'=>'user');
	
	
}