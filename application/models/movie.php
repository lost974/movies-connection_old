<?php defined('SYSPATH') OR die('No direct access allowed.');

class Movie_Model extends ORM {

	protected $has_many = array('mark','event', 'critique', 'moviesaw', 'recommend','movies_genre');

	public function display_image()
	{
		if ($this->image != "")
		{
			$poster = html::image('upload/movies/posters/'.$this->image);
		}
		else
		{
			$poster = html::image('images/noimage.jpg');
		}
		return $poster;

	}
	
	public function display_min_image()
	{
		if ($this->image != "")
		{
			$poster = html::image(array('src' => 'upload/movies/posters/'.$this->image, 'width' => '69', 'height' => '100'));
		}
		else
		{
			$poster = html::image(array('src' => 'images/noimage.jpg', 'width' => '69', 'height' => '100'));
		}
		return $poster;

	}
	
	public function movie_like($movie)
	{		
		$poster = $movie->display_min_image();
			
		$message = '<div class="profil_movie">'.html::anchor('movie/view/'.$movie->id, $poster).'</div>';
		return($message);
	}
	
	public function movie_intention($movie, $user_u)
	{		
		$poster = $movie->display_min_image();
		if($user_u == 1)
		{
			$message = '<table class="profil_movie_intention">
							<tr>
								<td>'
									.html::anchor('movie/view/'.$movie->id, $poster).'
								</td>
							</tr>
							<tr>
								<td>'
									.html::anchor('movie/moviesaw/'.$movie->id, "Je l'ai vu").'
								</td>
							</tr>
						</table>';
		}
		else
		{
			$message = '<div class="profil_movie">'.html::anchor('movie/view/'.$movie->id, $poster).'</div>';
		}
		return($message);
	}
	
	public function display_genre($genre_id)
	{
		$genre = ORM::factory('movies_genre')
			->where('id', $genre_id)
			->find();
		return($genre->name);
	}
	
	public function profil_movie_plus($username)
	{
		$message = '<div class="profil_movie">'.html::anchor('user/profil_movie/'.$username, html::image('images/movies_plus_min.png')).'</div>';
		return($message);
		
	}
	
	public function title_min($title)
	{  
		$lg_max = 40; //nombre de caractère autoriser 
		$title_min = $title;
		if (strlen($title) > $lg_max) 
		{ 
			$title_m = substr($title, 0, $lg_max); 
			$last_space = strrpos($title_min, " "); 
			$title_min = substr($title_m, 0, $last_space)."..."; 
		} 
		
		return $title_min; 
	}
	
	/*public function best_movie()
	{		
		$movies = ORM::factory('movie')->find_all();
		$mark = ORM::factory('mark');
		$classement = array();
		foreach($movies as $movie)
		{
			$moy = $mark->mark_moyenne($movie->id);
			;
		}
		arsort($classment);
		$class = array_slice($moy, '0', '5');
		
		return($class);
	}*/

}