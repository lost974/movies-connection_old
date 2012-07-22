<?php defined('SYSPATH') OR die('No direct access allowed.');

class Mark_Model extends ORM {

	protected $belongs_to = array('user','movie','event');
	
	public function mark_moyenne($id)
	{
		$marks = ORM::factory('mark')
			->where('movie_id', $id)
			->find_all();
			
		$res = 0;
			
		$total = count($marks);
		
		$mark = array();
		foreach($marks as $m)
		{
			$mark[]= $m->mark;
		}
		
		if($total >= 1)
		{
			$t = array_sum($mark);
			$res = $t / $total;
		}
		return $res;
	}
	
	public function nbr_user_mark($id)
	{
		$marks = ORM::factory('mark')
			->where('movie_id', $id)
			->find_all();
			
		$total = count($marks);
		
		return $total;
	}
	
	public function star($nbr)
	{
		$star='Non Noté';
		
		if(0 < $nbr AND $nbr<= 1)
		{
			$star = html::image('images/1star.png');
		}
		elseif(1 < $nbr AND $nbr <= 2)
		{
			$star = html::image('images/2star.png');
		}
		elseif(2 < $nbr AND $nbr <= 3)
		{
			$star= html::image('images/3star.png');
		}
		elseif(3 < $nbr AND $nbr <= 4)
		{
			$star= html::image('images/4star.png');
		}
		elseif(4 < $nbr AND $nbr <= 5)
		{
			$star= html::image('images/5star.png');
		}
		return $star;
	}
}