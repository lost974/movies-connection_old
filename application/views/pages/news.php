<!-- <h1 class="test">ici</h1>
<script type="text/javascript">
	var baseUrl = "http://localhost:8888/MoviesConnection/www/movies-connection/";
	$('.test').click(function(){
		$.ajax({
		   type: "POST",
		   url: baseUrl+"page/testajax",
		   dataType: 'json',
		   success: function(data){
		     console.log(data);
		     $('.test').html(data.test);
		   }
		 });
	 });

</script>
!-->

<?php
if($moderateur == 2)
{
	echo '<div class="bouton transition ajout_news">'.html::anchor('page/addnews', 'Ajouter une News').'</div>';
}
?>

<?php 
foreach($news as $news)
{ ?>
	<div id="block">
	<div class="name"><?php echo $news->title.'   |   Version : '.$news->version; ?></div>
	<?php
	echo nl2br($news->content);
	echo '<br /><br />';

	
	$comments = ORM::factory('news_comment')
		->where('news_id', $news->id)
		->orderby('id','ASC')
		->find_all();
	$nbr = count($comments);
	echo '<span class="view_comment_'.$news->id.'" style="cursor: pointer;">';
	if($nbr > 0)
	{
		echo 'Voir les commentaires ('.$nbr.')';
	}
	else
	{
		echo 'Commenter ';
	}
	echo '</span>';
	echo '<span class="hide_comment_'.$news->id.'" style="cursor: pointer;">Cacher les commentaires </span>';
	echo html::image('css/images/comment.png');
	?>
	
	<span class="bottom_news"><?php
	echo 'Par Lost974, publié il y a '.gen::time_left($news->created);
	if($news->updated != '')
	{
		echo ', modifié il y a '.gen::time_left($news->updated);
	}
	if($moderateur == 2)
	{
		echo ' '.html::anchor('page/editnews/'.$news->id, html::image('images/edit.gif'));
		echo html::anchor('page/deletenews/'.$news->id, html::image('images/delete.png'));
	}?>
	</span>
	<div class="comment_<?php echo $news->id; ?>">
	<table>
		<?php
		if($nbr > 0)
		{
			foreach($comments as $comment)
			{
				$u = ORM::factory('user')->where('id', $comment->user_id)->find();
				?>
				<tr>
					<td rowspan="2" class=""><?php echo $user->display_avatar_min($u->id);?></td>
					<td class=""><?php echo $u->username.' : '?></td>
				</tr>
				<tr>
					<td class=""><?php echo nl2br($comment->comment).'<div id="event_date">Il y a '.gen::time_left($comment->created).'</div>';?></td>
				</tr>
				
				<?php
			}
		}?>
	</table>
	<?php echo form::open('page/comment_news/'.$news->id); ?>
	<table>
		<tr>
			<td rowspan="2" class=""><?php echo $user->display_avatar_min($user->id);?></td>
			<td class=""><?php echo $user->username.' : ';?></td>
		</tr>
		<tr>
			<td class=""><?php echo form::textarea(array('name'=>'comment','rows'=>'3','cols'=>'80'));?></td>
		</tr>		
	</table>
	<?php echo form::submit('submit', 'Commenter');
	echo form::close();?>
	</div>
	<script type="text/javascript">
		$('.hide_comment_<?php echo $news->id; ?>').hide();
		$('.comment_<?php echo $news->id; ?>').hide();
		$('.view_comment_<?php echo $news->id; ?>').click(function(){
			$('.comment_<?php echo $news->id; ?>').slideDown('slow');
			$('.view_comment_<?php echo $news->id; ?>').hide();
			$('.hide_comment_<?php echo $news->id; ?>').show();
		});
		$('.hide_comment_<?php echo $news->id; ?>').click(function(){
			$('.comment_<?php echo $news->id; ?>').slideUp('slow');
			$('.hide_comment_<?php echo $news->id; ?>').hide();
			$('.view_comment_<?php echo $news->id; ?>').show();
		});
	</script>
	</div><?php
}

?>