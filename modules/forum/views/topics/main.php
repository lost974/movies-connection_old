<h1><?= Kohana::lang('forum.title') ?></h1>
<div id="prelude"><?= Kohana::lang('forum.prelude') ?></div>

<p><b>Derniers topics</b></p>
<p>
<table class="forum">
	<tr class="top">
		<th></th>
		<th>Topic
			<?php 
			if ( $user->loaded and ($type != "update" or $type != "announce") ) 
			{
				echo ' - '.html::anchor('forum/topic/add/0', 'Nouveau »');
			}
			?>
		</th>
		<th>Posts</th>
		<th>Users</th>
		<th>Dernier<br />message</th>
	</tr>
	
	<?php
$blank = html::image('images/forum/blank.png');
foreach ($last_topics as $n => $topic) {
	$last_comment = $topic->get_last_comment();
    $dark = "";
    if ($n % 2 == 0) 
    {
    	$dark = ' class="dark"';
    }
    if ($topic->main_sticky) 
    {
    	$dark = ' class="sticky"';
    }
    ?>
    <tr<?= $dark?>>
    	<td class="icons">
    		<?php
    		echo $blank.' ';
    		echo $blank.' ';
    		echo (($topic->locked) ? html::image('images/forum/cadenas.gif') : $blank);
    		echo ' ';
    		echo (($topic->main_sticky) ? html::image('images/forum/etoile.png') : $blank);
    		echo ' ';
    		$icon = "_new";
    		if ($user->loaded and $user->notif_forum)
    		{ 
    			$icon = ($topic->is_notified($user)) ? "_new" : "";
    		}
    		echo html::anchor(
    			$topic->get_url_last_comment(), 
				html::image('images/forum/types/'.$topic->type.$icon.'.png')
			);
    		?>
    	</td>
    	<td class="title">
    		<?= html::anchor('forum/'.$topic->type.'/'.$topic->id, $topic->title) ?>
    	</td>
    	<td class="posts">
    		<?= count($topic->comments) ?>
    	</td>
    	<td class="lastposter">
    		<?= $topic->get_nbr_users() ?>
    	</td>
		<td class="refreshness">
			<?= $last_comment->user->username ?>
			<br /><?= gen::time_left($last_comment->created) ?>
		</td>
	</tr>
<?php } ?>
</table>
</p><br />

<p><b>Catégories</b></p>
<p>
<table class="forum">
	<tr class="top">
		<th></th>
		<th>Catégorie</th>
		<th>Topics</th>
		<th>Posts</th>
	</tr>
	<?php
foreach ($categories as $n => $category) {
	$type = $category['type'];
    $dark = ($n % 2 == 0) ? ' class="dark"' : "";
    ?>
    <tr<?= $dark ?>>
    	<td class="icons">
    		<?php
			echo $blank.' ';
			echo $blank.' ';
			echo $blank.' ';
			echo $blank.' ';
			echo html::image('images/forum/types/'.$type.'_new.png');
    		?>
    	</td>
    	<td class="title">
        	<?= html::anchor('forum/'.$type, Kohana::lang('forum.types.'.$type.'.title')) ?>
        	- <small><?= Kohana::lang('forum.types.'.$type.'.subtitle') ?></small>
		</td>
		<td class="topics">
			<?= $category['nbr_topics'] ?>
		</td>
		<td class="posts">
			<?= $category['nbr_comments'] ?>
		</td>
    </tr>
<?php } ?>
</table>
</p><br /><br />

<?php
if ($user->loaded and ! $user->notif_forum) {
	?>
	<div class="msgInfo">
		Actuellement, vous ne recevrez aucune notifications du forum pour les nouveaux messages.<br />Vous pouvez changer cela dans les préférences de user.
	</div>
	<?php
}
?>
