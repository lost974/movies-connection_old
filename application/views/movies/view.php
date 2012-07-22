<div class="movie_interaction">
	<div class="movie_poster"><?php echo $movie->display_image();?></div>
	<div class="movie_i">
		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				Note des utilisateurs : <br /><?php 
				$star = $mark->star($movie->moyenne);
				echo $star; 
				if($star != 'Non Noté') 
				{
					echo ' ('.$movie->nb_mark.')';
				}?>
			</div>
			<div class="ribbon-edge-topleft"></div>
			<div class="ribbon-edge-topright"></div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-edge-bottomright"></div>
			<div class="ribbon-back-left"></div>
			<div class="ribbon-back-right"></div>
		</div>

	</div>
	<?php 
	if($islog)
	{
		?>
		<div class="movie_i">
				<?php 
				if($movie_saw->user_id > 0)
				{
					if($mark->loaded)
					{
						echo 'Ma note : <br />';
						$star = $mark->star($mark->mark);
						echo $star.' ';
						echo html::anchor('movie/delete_mark/'.$movie->id, html::image('images/edit.gif'));
						echo html::anchor('movie/delete_mark/'.$movie->id, html::image('images/delete.png'));
					}
					else
					{ ?>
						<div class="click_mmark_2">
							<span class="click_mmark_txt" style="float:left;">Noter : </span>
							<div class="star1 star_mark">
								<?php echo html::image('images/star_gray.png'); ?>
							</div>
							<div class="star2 star_mark">
								<?php echo html::image('images/star.png'); ?>
							</div>
							<div class="star3 star_mark">
								<?php echo html::image('images/star_gray.png'); ?>
							</div>
							<div class="star4 star_mark">
								<?php echo html::image('images/star.png'); ?>
							</div>
							<div class="star5 star_mark">
								<?php echo html::image('images/star_gray.png'); ?>
							</div>
							<div class="star6 star_mark">
								<?php echo html::image('images/star.png'); ?>
							</div>
							<div class="star7 star_mark">
								<?php echo html::image('images/star_gray.png'); ?>
							</div>
							<div class="star8 star_mark">
								<?php echo html::image('images/star.png'); ?>
							</div>
							<div class="star9 star_mark">
								<?php echo html::image('images/star_gray.png'); ?>
							</div>
							<div class="star10 star_mark">
								<?php echo html::image('images/star.png'); ?>
							</div>
							<span class="load star_mark_load">
								<?php echo html::image(array('src'=>'images/load.gif', 'width'=>'15px', 'heigt'=>'15px')); ?>
							</span>
					</div>
					<div class="clear"></div>
					<div class="click_mmark_result">
						<?php echo 'Ma note : '.html::image(array('src'=>'images/star.png', 'id'=>'click_mmark_result_img')); ?>
					</div> <?php
	
					}
				}
				else
				{
					?>
					<div class="click_msaw" style="cursor: pointer;">
						<?php echo "Je l'ai vu"; ?>
						<span class="load click_msaw_load">
							<?php echo html::image(array('src'=>'images/load.gif', 'width'=>'15px', 'heigt'=>'15px')); ?>
						</span>
					</div>
					<div class="click_mmark">
						<span class="click_mmark_txt" style="float:left;">Noter : </span>
						<div class="star1 star_mark">
							<?php echo html::image('images/star_gray.png'); ?>
						</div>
						<div class="star2 star_mark">
							<?php echo html::image('images/star.png'); ?>
						</div>
						<div class="star3 star_mark">
							<?php echo html::image('images/star_gray.png'); ?>
						</div>
						<div class="star4 star_mark">
							<?php echo html::image('images/star.png'); ?>
						</div>
						<div class="star5 star_mark">
							<?php echo html::image('images/star_gray.png'); ?>
						</div>
						<div class="star6 star_mark">
							<?php echo html::image('images/star.png'); ?>
						</div>
						<div class="star7 star_mark">
							<?php echo html::image('images/star_gray.png'); ?>
						</div>
						<div class="star8 star_mark">
							<?php echo html::image('images/star.png'); ?>
						</div>
						<div class="star9 star_mark">
							<?php echo html::image('images/star_gray.png'); ?>
						</div>
						<div class="star10 star_mark">
							<?php echo html::image('images/star.png'); ?>
						</div>
						<span class="load star_mark_load">
							<?php echo html::image(array('src'=>'images/load.gif', 'width'=>'15px', 'heigt'=>'15px')); ?>
						</span>
					</div>
					<div class="clear"></div>
					<div class="click_mmark_result">
						<?php echo 'Ma note : '.html::image(array('src'=>'images/star.png', 'id'=>'click_mmark_result_img')); ?>
					</div> 
					<div class="gp_intention">
						<?php
						if($intention_u->loaded)
						{
							echo "Dans ma liste 'A Voir'.";
						}
						else
						{ ?>
							<div class="intention" style="cursor: pointer;">
								<?php echo "Je veux le voir"; ?>
								<span class="load intention_load">
									<?php echo html::image(array('src'=>'images/load.gif', 'width'=>'15px', 'heigt'=>'15px')); ?>
								</span>
							</div>
							<div class="intention_result"></div>
						<?php
						} ?>
					</div> <?php
				}?>
		</div>
		<div class="movie_i">
				<?
				if($following_moviesaw != null)
				{
					echo 'Followings qui ont déjà vu le film :<br /> ';
					foreach($following_moviesaw as $following_ms)
					{
						echo html::anchor('user/profil/'.$following_ms, $following_ms).', ';
					}
				}
				else
				{
					echo "Aucun Followings n'a vu le film";
				}?>
		</div><?
		if($following_marks != null)
		{?>
		<div class="movie_i"><?php
				echo 'Note moyenne des Followings :<br /> ';
				$moy = 0;
				$total = count($following_marks);
				$following_m = array();
				$nbr_following_mark = 0;
				foreach($following_marks as $m)
				{
					$following_m[]= $m->mark;
					$nbr_following_mark++;
				}
				
				if($total >= 1)
				{
					$t = array_sum($following_m);
					$moy = $t / $total;
				}
				$star = $mark->star($moy);
				echo $star;
				echo ' ('.$nbr_following_mark.')';
			?>
		</div>
			
	<?php } ?>
		<div class="movie_i">
				<? 
				if($followers_ad != null)
				{
					echo '<span class="conseil_i" style="cursor:pointer;">';
					echo 'Conseiller ce film à un follower';
					echo '</span>';
					echo '<span class="conseil">';
					echo 'Conseiller ce film à : ';
					echo form::open('movie/recommend/'.$movie->id);
					echo form::dropdown('friends',$followers_ad);
					echo form::submit('submit', 'OK');
					echo form::close();
					echo '</span>';
				}
				else
				{
					echo 'Vous ne pouvez pas conseiller vos followers';
				} ?>
		</div>
		<?php 
		if($following_recommend != null)
		{?>
			<div class="movie_i">
					<?php
					echo 'Follower(s) qui vous conseillent ce film :<br /> ';
					foreach($following_recommend as $f_r)
					{
						echo html::anchor('user/profil/'.$f_r, $f_r).', ';
					}
					?>
			</div>
		<?php } 
	
	}?>
</div>
<div class="movie_table" >
	<div id="movie_title"><?php echo $movie->title; ?></div>
	<div class="movie_middle"><span style="font-weight: bold;">Date de sortie : </span><?php echo $movie->release ;?></div>
	<div class="movie_middle">
			<span style="font-weight: bold;">Genre : </span><?php echo $movie->display_genre($movie->genre_id);?>
	</div>
	<div  class="movie_middle"><span style="font-weight: bold;">Synopsis : </span><br /> <?php echo nl2br($movie->synopsis);?></div>
	<div class="movie_youtube"><?php
		if($movie->b_a != "0")
		{
			echo '<br /><span><iframe title="YouTube video player" width="640" height="390" src=http://www.youtube.com/embed/'.$movie->b_a.' frameborder="0" allowfullscreen></iframe></span>';
		}
		echo '<br /><br />';
		?>
	</div>
</div>
<div class="clear"></div>


<br />

<div id="critique_name">Critiques</div>
<?php
	if($islog)
	{
		if($critique_u->loaded)
		{	
			$star = $mark->star($moy);	?>
			<div class="critique">
				<div class="critique_user_name_show" style="cursor:pointer;">
					<span><?php echo html::image('images/triangle_right.png'); ?></span>
					<span style="font-weight: bold;">Ma critique</span>
				</div>
				<div class="critique_user_name_hide" style="cursor:pointer;">
					<span><?php echo html::image('images/triangle_down.png'); ?></span>
					<span style="font-weight: bold;">Ma critique</span>
				</div>
				<div class="critique_user">
					<div class="critique_left"><?php echo $user->display_avatar_min($user->id);?></div>
					<div class="critique_right">
						<span class="bold"><?php echo $user->username;?></span>
						<span class="critique_mark"><?php echo $star;?></span>
					</div>
					<div class="critique_right"><?php echo nl2br($critique_u->critique); ?></div>
					<div id="event_date" class="critique_right">Il y a <?php echo gen::time_left($critique_u->created); ?>
					<span class="critique_mark"><?php echo 'Modifier - '.html::anchor('movie/delete_critique/'.$critique_u->id ,'Supprimer');?></span></div>
					<div class="clear"></div>
				</div>
			</div>
			<?php
		}
		elseif($movie_saw->user_id > 0)
		{ ?>
			<?php
			echo form::open('movie/add_critique/'.$movie->id);?>
			<div class="critique">
				<div class="critique_user_name_show" style="cursor:pointer;">
					<span><?php echo html::image('images/triangle_right.png'); ?></span>
					<span style="font-weight: bold;">Rédiger une critique</span>
				</div>
				<div class="critique_user_name_hide" style="cursor:pointer;">
					<span><?php echo html::image('images/triangle_down.png'); ?></span>
					<span style="font-weight: bold;">Rédiger une critique</span>
				</div>
				<div class="critique_user">
					<div class="critique_left"><?php echo $user->display_avatar_min($user->id);?></div>
					<div class="critique_right">
						<span class="bold"><?php echo $user->username;?></span>
					</div>
					<div class="critique_right"><?php echo form::textarea(array('name'=>'critique','rows'=>'6','cols'=>'60'));?></div>
					<div class="critique_right"><?php echo form::submit('submit', 'Critiquer'); ?></div>
					<div class="clear"></div>
				</div>
			</div>	
			<?php
			
			echo form::close();
		}
	}?>
		<?php
		foreach($critiques as $critique)
		{
			if($islog AND $critique_u->loaded AND $critique_u->id == $critique->id)
			{
			}
			else
			{
				$u = ORM::factory('user')->where('id', $critique->user_id)->find();
				$m = ORM::factory('mark')->where('user_id', $u->id)->where('movie_id', $movie->id)->find();
				$star = $m->star($m->mark);
				?>
				<div class="critique">
					<div class="critique_left"><?php echo $u->display_avatar_min($u->id);?></div>
					<div class="critique_right">
						<span class="bold"><?php echo $u->username;?></span>
						<span class="critique_mark"><?php echo $star;?></span>
					</div>
					<div class="critique_right"><?php echo nl2br($critique->critique); ?></div>
					<div id="event_date" class="critique_right">Il y a <?php echo gen::time_left($critique->created); ?></div>
					<div class="clear"></div>
				</div>
				
				<?php
			}
		}?>
</div>
<script>
$('.star2').hide();
$('.star4').hide();
$('.star6').hide();
$('.star8').hide();
$('.star10').hide();
$('.star1, .star2').mouseover(function() {
				$('.star1').hide();
				$('.star2').show();
				$('.star3').show();
				$('.star4').hide();
				$('.star5').show();
				$('.star6').hide();
				$('.star7').show();
				$('.star8').hide();
				$('.star9').show();
				$('.star10').hide();
		    });
$('.star3, .star4').mouseover(function() {
				$('.star1').hide();
				$('.star2').show();
				$('.star3').hide();
				$('.star4').show();
				$('.star5').show();
				$('.star6').hide();
				$('.star7').show();
				$('.star8').hide();
				$('.star9').show();
				$('.star10').hide();
		    });
$('.star5, .star6').mouseover(function() {
				$('.star1').hide();
				$('.star2').show();
				$('.star3').hide();
				$('.star4').show();
				$('.star5').hide();
				$('.star6').show();
				$('.star7').show();
				$('.star8').hide();
				$('.star9').show();
				$('.star10').hide();
		    });
$('.star7, .star8').mouseover(function() {
				$('.star1').hide();
				$('.star2').show();
				$('.star3').hide();
				$('.star4').show();
				$('.star5').hide();
				$('.star6').show();
				$('.star7').hide();
				$('.star8').show();
				$('.star9').show();
				$('.star10').hide();
		    });
$('.star9, .star10').mouseover(function() {
				$('.star1').hide();
				$('.star2').show();
				$('.star3').hide();
				$('.star4').show();
				$('.star5').hide();
				$('.star6').show();
				$('.star7').hide();
				$('.star8').show();
				$('.star9').hide();
				$('.star10').show();
		    });

$('.click_msaw_load').hide();
$('.click_mmark').hide();
$('.click_msaw').click(function(){
	$('.click_msaw_load').show();
	$.post(baseUrl+'movie/moviesaw/<?php echo $movie->id; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.gp_intention').hide();
			$('.click_msaw').hide();
			$('.click_mmark').show();
		}
		else
		{
			$('.click_msaw').html("Oops, une erreur s'est produite");
			$('.click_msaw_load').hide();
		}
	});
});

$('.star_mark_load').hide();
$('.click_mmark_result').hide();
$('.star2').click(function(){
	$('.star_mark_load').show();
	$.post(baseUrl+'movie/mark/<?php echo $movie->id.'/1'; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.click_mmark').hide();
			$('.click_mmark_2').hide();
			$('#click_mmark_result_img').attr('src', baseUrl+'images/'+data.star);
			$('.click_mmark_result').show();
			
		}
		else
		{
			$('.click_mmark_2').hide();
			$('.click_mmark_result').html("Oops, une erreur s'est produite");
			$('.click_msaw_load').hide();
		}
	});
});

$('.star_mark_load').hide();
$('.click_mmark_result').hide();
$('.star4').click(function(){
	$('.star_mark_load').show();
	$.post(baseUrl+'movie/mark/<?php echo $movie->id.'/2'; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.click_mmark').hide();
			$('.click_mmark_2').hide();
			$('#click_mmark_result_img').attr('src', baseUrl+'images/'+data.star);
			$('.click_mmark_result').show();
			
		}
		else
		{
			$('.click_mmark_2').hide();
			$('.click_mmark_result').html("Oops, une erreur s'est produite");
			$('.click_msaw_load').hide();
		}
	});
});

$('.star_mark_load').hide();
$('.click_mmark_result').hide();
$('.star6').click(function(){
	$('.star_mark_load').show();
	$.post(baseUrl+'movie/mark/<?php echo $movie->id.'/3'; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.click_mmark').hide();
			$('.click_mmark_2').hide();
			$('#click_mmark_result_img').attr('src', baseUrl+'images/'+data.star);
			$('.click_mmark_result').show();
			
		}
		else
		{
			$('.click_mmark_2').hide();
			$('.click_mmark_result').html("Oops, une erreur s'est produite");
			$('.click_msaw_load').hide();
		}
	});
});

$('.star_mark_load').hide();
$('.click_mmark_result').hide();
$('.star8').click(function(){
	$('.star_mark_load').show();
	$.post(baseUrl+'movie/mark/<?php echo $movie->id.'/4'; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.click_mmark').hide();
			$('.click_mmark_2').hide();
			$('#click_mmark_result_img').attr('src', baseUrl+'images/'+data.star);
			$('.click_mmark_result').show();
			
		}
		else
		{
			$('.click_mmark_2').hide();
			$('.click_mmark_result').html("Oops, une erreur s'est produite");
			$('.click_msaw_load').hide();
		}
	});
});

$('.star_mark_load').hide();
$('.click_mmark_result').hide();
$('.star10').click(function(){
	$('.star_mark_load').show();
	$.post(baseUrl+'movie/mark/<?php echo $movie->id.'/5'; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.click_mmark').hide();
			$('.click_mmark_2').hide();
			$('#click_mmark_result_img').attr('src', baseUrl+'images/'+data.star);
			$('.click_mmark_result').show();
			
		}
		else
		{
			$('.click_mmark_2').hide();
			$('.click_mmark_result').html("Oops, une erreur s'est produite");
			$('.click_msaw_load').hide();
		}
	});
});

$('.intention_load').hide();
$('.intention').click(function(){
	$('.intention_load').show();
	$.post(baseUrl+'movie/intention/<?php echo $movie->id; ?>', '', function(data){
		console.log(data);
		console.log(data.success); // true, false
		if (data.success == "true")
		{
			$('.intention_result').html("Film ajouté à ma liste");
			$('.intention').hide();
		}
		else
		{
			$('.intention_result').html("Oops, une erreur s'est produite");
			$('.intention').hide();
		}
	});
});
</script>