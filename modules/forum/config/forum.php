<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * README FIRST
 * Steps to install forum module :
 * 1- Copy/paste this file into /application/config folder
 * 2- Configure this file like you want (read all)
 * 3- Create tables in your DB by importing /sql/base.sql
 * 4- Modify your {user} table
 * 5- Import css & images
 */

/**
 * Every topic belongs to a type, which defines his specifications. The order
 * is also important. Then configure them.
 ** locked means users can't create topic of that type, except admin
 */
$config['types'] = array(
	
	//topic			=> locked
	
	'update'		=> true, 
	'announce' 		=> true, 
	'topic'			=> false, 
	'question' 		=> false, 
	'idea' 			=> false, 
	'bug'			=> false, 
	'reaction'		=> false, 
	'private'		=> false 
	
);

/**
 * Topics per page.
 */
$config['topics_per_page'] = 15;

/**
 * Comments per page.
 */
$config['comments_per_page'] = 10;

/**
 * Pagination format.
 */
$config['pagination_format'] = 'punbb';

/**
 * Page name.
 */
$config['page_name'] = 'page';

/**
 * User object for private topic
 */
$config['class_user_name'] = 'user';

