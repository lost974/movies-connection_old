<?php 
$nbr_topics = count($topics);
$blank = html::image('images/forum/blank.png');

if ($type == 'private')
{ 
	echo '<h1>'.Kohana::lang('letter.title').'</h1>';
	echo '<div id="prelude">'.Kohana::lang('letter.prelude').'</div>';
	$link = "letter/";
	$lang = "letter.";
} 
else 
{
	?>
	<h1><?=Kohana::lang('forum.title') ?></h1>
	<div id="prelude"><?= Kohana::lang('forum.prelude') ?></div>
	<?php
	$link = "forum/$type/";
	$lang = "forum.";
	
	?>
	<p>
	<table>
		<tr>
			<td><?= html::anchor('forum', 'Forums') ?> » </td>
			<td><?= html::image('images/forum/types/'.$type.'_new.png') ?></td>
			<td><b><?= Kohana::lang("forum.types.$type.title") ?></b> 
			- <small><?= Kohana::lang("forum.types.$type.subtitle") ?></small></td> 
			<td><small>(<?= $nbr_topics ?>)</small></td>
		</tr>
	</table>
	</p>	
	<?php
}

echo $pagination->render(); 
?>

<p>
<table class="forum">
	<?php
	$new_topic = ($user->loaded and ($user->is_administrator() or ! $locked)) 
			   ? html::anchor(
			  		$link.'edit', 
			  		' - '.Kohana::lang($lang.'new_one').' »'
				 ) 
			   : "";
    ?>
    <tr class="top">
    	<th></th>
    	<th><?= Kohana::lang($lang.'topics').$new_topic ?></th>
    	<th><?= Kohana::lang($lang.'posts') ?></th>
        <th><?= Kohana::lang($lang.'users') ?></th>
        <th><?= Kohana::lang($lang.'last_post') ?></th>
    </tr>
    <?php
    if ($nbr_topics > 0) {
    	foreach ($topics as $n => $topic) {
           	$nbr_comments = count($topic->comments);
            $last_comment = $topic->comments[$nbr_comments-1];
            $dark = "";
            if ($n % 2 == 0) $dark = ' class="dark"';
            if ($topic->sticky) $dark = ' class="sticky"';
		?>
	<tr<?= $dark ?>>
		<td class="icons">
    		<?php
    		// edit button
    		if ($user->loaded and $user->is_moderator() and $type != 'private')
    		{
				echo html::anchor(
					$link.'edit/'.$topic->id, 
					html::image('images/forum/edit.gif')
				).' ';
			}
			else
			{
				echo $blank.' ';
			}
			
			// delete button
			if ($user->loaded and $topic->is_moderator($user))
			{
				echo html::anchor(
					$link.'delete/'.$topic->id, 
					html::image('images/forum/delete.gif'), 
					array('title'=>'Supprimer')
				).' ';
			}
			else
			{
				echo $blank.' ';
    		}
    		
    		// cadenas & star
    		echo (($topic->locked) ? html::image('images/theme/cadenas.gif') : $blank);
    		echo ' ';
    		echo (($topic->sticky) ? html::image('images/theme/etoile.png') : $blank);
    		echo ' ';
    		
    		// notification
    		$icon = ($user->loaded and $topic->is_notified($user)) ? "_new" : "";
			echo html::anchor(
				$topic->get_url_last_comment($link), 
				html::image('images/forum/types/'.$type.$icon.'.png')
			);
			?>
    	</td>
		<td class="title">
			<?php 
			echo html::anchor($link.$topic->id, $topic->title);
			if ($type == 'bug')
			{
				echo '<br /><span class="status">'.$topic->get_level().', '.$topic->get_status().'</span>';
			}
			?>
		</td>
        <td class="posts"><?= $nbr_comments ?></td>
        <td class="lastposter"><?= $topic->get_nbr_users(); ?></td>
        <td class="refreshness">
        	
        	<?= $last_comment->user->username.'<br />'.gen::time_left($last_comment->created) ?>
        </td>
	</tr>
	<?php
        }
    } else {
    ?>
	<tr>
		<td colspan="5">
			<center><i><?= Kohana::lang($lang.'no_messages') ?></i> - 
	        <?php 
	        if ($user->loaded) 
	        {	
	        	echo html::anchor(
	        		$link.'edit', 
	        		Kohana::lang($lang.'write_one')
	        	); 
	        }
	        ?>
        	</center>
        </td>
	</tr>
    <?php } ?>

</table>
</p><br />
