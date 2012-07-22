<table class="profil_left">
	<tr>
		<td id="profil_avatar"><?php echo $user->display_avatar($user->id); ?></td>
	</tr>
	<tr>
		<td>Followings :</td>
	</tr>
	<tr>
		<td>
		<?php
		foreach($followings as $following)
		{
			echo '<div class="profil_friend">';
			echo html::anchor('user/profil/'.$following->username, $following->display_avatar_min($following->id));
			echo '</div>';
		} ?>
		</td>
	</tr>
	<tr>
		<td>Followers :</td>
	</tr>
	<tr>
		<td>
		<?php
		foreach($followers as $follower)
		{
			echo '<div class="profil_friend">';
			echo html::anchor('user/profil/'.$follower->username, $follower->display_avatar_min($follower->id));
			echo '</div>';
		}
		
		?>
		</td>
	</tr>
</table>
<div id="profil_username"><?php echo $user->username; ?></div>
<table class="profil_movies">
	<tr>
		<td>Films : <?php echo '('.$nbr_moviesaw.')' ?></td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($marks5) != 0)
		{
			echo '<div class="movie_like">';
			echo html::image('images/5star.png').' : <br />';
			foreach($marks5 as $mark)
			{
				$movie = $mark->movie;
				echo $movie->movie_like($movie);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($marks4) != 0)
		{
			echo '<div class="movie_like">';
			echo html::image('images/4star.png').' : <br />';
			foreach($marks4 as $mark)
			{
				$movie = $mark->movie;
				echo $movie->movie_like($movie);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($marks3) != 0)
		{
			echo '<div class="movie_like">';
			echo html::image('images/3star.png').' : <br />';
			foreach($marks3 as $mark)
			{
				$movie = $mark->movie;
				echo $movie->movie_like($movie);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($marks2) != 0)
		{
			echo '<div class="movie_like">';
			echo html::image('images/2star.png').' : <br />';
			foreach($marks2 as $mark)
			{
				$movie = $mark->movie;
				echo $movie->movie_like($movie);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($marks1) != 0)
		{
			echo '<div class="movie_like">';
			echo html::image('images/1star.png').' : <br />';
			foreach($marks1 as $mark)
			{
				$movie = $mark->movie;
				echo $movie->movie_like($movie);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($moviesaw) != 0)
		{
			echo '<div class="movie_like">';
			echo 'Films vu (non notés) : <br />';
			foreach($moviesaw as $m)
			{
				$movie = ORM::factory('movie')
					->where('id', $m->movie_id)
					->find();
				echo $movie->movie_like($movie);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if(count($intention) != 0)
		{
			echo '<div class="movie_like">';
			echo 'Films à Voir : <br />';
			foreach($intention as $i)
			{
				$movie = ORM::factory('movie')
					->where('id', $i->movie_id)
					->find();
				echo $movie->movie_intention($movie, $user_u);
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}	?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		if($user_u == 1)
		{
			if(count($recommend) != 0)
			{
				echo '<div class="movie_recommend">';
				echo 'Film(s) conseillé(s) par vos amis : <br />';
				$movies = array();
				foreach($recommend as $r)
				{
					if($movies == null)
					{
						$movies[] = $r->movie_id;
					}
					elseif($movies != null)
					{
						foreach($movies as $m)
						{
							if($m != $r->movie_id)
							{
								$movies[] = $r->movie_id;
							}
						}
					}
				}
				foreach($movies as $movie)
				{
					echo ' - ';
					$m = ORM::factory('movie')->where('id',$movie)->find();
					echo html::anchor('movie/view/'.$m->id,$m->title).', conseillé par : ';
					$re = ORM::factory('recommend')->where('friend_id', $user->id)->where('movie_id', $movie)->find_all();
					foreach($re as $r)
					{
						$u = ORM::factory('user')->where('id', $r->user_id)->find();
						echo html::anchor('user/profil/'.$u->username, $u->username).', ';
					}
					echo '<br />';
					
				}
				echo '<div class="clear"></div>';
				echo '</div>';
			}
		}	?>
		</td>
	</tr>
</table>
<div class="clear"></div>