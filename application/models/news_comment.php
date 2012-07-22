<?php defined('SYSPATH') OR die('No direct access allowed.');

class News_comment_Model extends ORM {

	protected $belongs_to = array('user', 'news');

}