<?php defined('SYSPATH') OR die('No direct access allowed.');

class Event_Model extends ORM {

	//$event = ORM::factory('event', 1);
	//echo $event->user->username;
	
	protected $belongs_to = array('user');
	
	protected $has_many = array('marks','movies');
	
	/* 
	 * Crée un évènement pour l'action realisée
	 * @param	$type		le type d'évènement
	 *			$argument	l'id de l'action
	 */

	public function create($user_id, $type, $argument)
	{
		$this->user_id = $user_id;
		$this->type = $type;
		$this->arguments = $argument;
		$this->save();
	} 
	
	public function display_event($event)
	{
			$user = ORM::factory('user')
				->where('id', $event->user_id)
				->find();
				
			$avatar = $user->display_avatar_min($user->id);
				
			if($event->type == 1)
			{
				$mark = ORM::factory('mark')
				->where('id', $event->arguments)
				->find();
				
				$movie = ORM::factory('movie')
				->where('id', $mark->movie_id)
				->find();
				
				$poster = $movie->display_min_image();
				
				$star = $mark->star($mark->mark);
				
				$ligne = '<div class="event_case transitionNA">
								<div class="event_user">'.$avatar.'</div>
								<div class="event_label">'.html::anchor('user/profil/'.$user->username, $user->username).' a noté '
														.html::anchor('movie/view/'.$movie->id, $movie->title).' : '.$star.
														'<div id="event_date">Il y a '.gen::time_left($mark->created).'</div>
									</div>
								<div class="event_movie_img">'.$poster.'</div>
								<div class="clear"></div>
							</div>';
			}
			
			elseif($event->type == 2)
			{
				$following = ORM::factory('follow')
				->where('id', $event->arguments)
				->find();
				
				$u = ORM::factory('user')
				->where('id', $following->following_id)
				->find();
				$u_avatar = $user->display_avatar_min($u->id);
				
				$us = ORM::factory('user')
				->where('id', $following->user_id)
				->find();
				$us_avatar = $user->display_avatar_min($us->id);
				
				$ligne ='<div class="event_case transitionNA">
							<div class="event_user">'.$avatar.'</div>
							<div class="event_label">'.html::anchor('user/profil/'.$us->username, $us->username).' suit '
													.html::anchor('user/profil/'.$u->username, $u->username).'
													<div id="event_date">Il y a '.gen::time_left($following->updated).'</div>
								</div>
							<div class="event_movie_img">'.$u_avatar.'</div>
							<div class="clear"></div>
						</div>';
			}
			
			elseif($event->type == 3)
			{
				$moviesaw = ORM::factory('moviesaw')
				->where('id', $event->arguments)
				->find();
				
				$movie = ORM::factory('movie')
				->where('id', $moviesaw->movie_id)
				->find();
				
				$poster = $movie->display_min_image();
				
				$ligne = '<div class="event_case transitionNA">
							<div class="event_user">'.$avatar.'</div>
							<div class="event_label">'.html::anchor('user/profil/'.$user->username, $user->username).' a vu '
													.html::anchor('movie/view/'.$movie->id, $movie->title).'
													<div id="event_date">Il y a '.gen::time_left($moviesaw->created).'</div>
								</div>
							<div class="event_movie_img">'.$poster.'</div>
							<div class="clear"></div>
						</div>';
			}
			
			elseif($event->type == 4)
			{
				$critique = ORM::factory('critique')
				->where('id', $event->arguments)
				->find();
				
				$movie = ORM::factory('movie')
				->where('id', $critique->movie_id)
				->find();
				
				$poster = $movie->display_min_image();
				
				$ligne ='<div class="event_case transitionNA">
							<div class="event_user">'.$avatar.'</div>
							<div class="event_label">'.html::anchor('user/profil/'.$user->username, $user->username).' a critiqué '
													.html::anchor('movie/view/'.$movie->id, $movie->title).' '
													.html::anchor('movie/view/'.$movie->id, ' Lire la critique').'
													<div id="event_date">Il y a '.gen::time_left($critique->created).'</div>
								</div>
							<div class="event_movie_img">'.$poster.'</div>
							<div class="clear"></div>
						</div>';
			}
			return $ligne;		
	}
	
}