<?php defined('SYSPATH') or die('No direct script access.');
 
class Comment_Model extends ORM {
    
    protected $belongs_to = array('topic', 'user');
    protected $has_many = array('interests');
    
    /**
     * Checks if comment can be modified by $user
     * 
     * @access public
     * @param mixed $user
     * @return void
     */
    public function is_moderator($user) 
    {
    	$res = false;
    	if ($user->is_moderator()) $res = true;
    	if ($this->user->id == $user->id) $res = true;
    	return $res;
    }
    
    // TODO
    public function is_first() 
    {
    	$first_comment = $this->topic->comments[0];
    	return ($this->id == $first_comment->id);
    }
 
}
