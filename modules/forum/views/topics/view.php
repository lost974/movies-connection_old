<?php

$icon = "";
if ($topic->locked) $icon .= ' '.html::image('images/theme/cadenas.gif');
if ($topic->sticky) $icon .= ' '.html::image('images/theme/etoile.png');
$nbr_comments = count($topic->comments);

if ($topic->type == 'private') 
{
	echo '<h1>'.Kohana::lang('letter.title').'</h1>';
	echo '<div id="prelude">'.Kohana::lang('letter.prelude').'</div>';
	$link = "letter/";
}
else
{
	echo '<h1>'.Kohana::lang('forum.title').'</h1>';
	echo '<div id="prelude">'.Kohana::lang('forum.prelude').'</div>';
	$link = "forum/topic/";
	
	?>
	<p>
	<table>
		<tr>
			<td><?= html::anchor('forum', 'Forums') ?> »</td>
			<td><?= html::image('images/forum/types/'.$topic->type.'_new.png') ?></td>
			<td>
				<?php 
				echo html::anchor(
					'forum/'.$topic->type, 
					Kohana::lang('forum.types.'.$topic->type.'.title')
				); 
				?> »
			</td>
	    	<td><?= $icon ?></td>
	    	<td>
	    		<b><?= $topic->title ?></b> 
	    		<small>(<?= $nbr_comments ?>)</small>
	    	</td>
		</tr>
	</table>
	</p>
	<?php
}

if ($topic->type == 'private') 
{
	echo '<p><b>'.Kohana::lang('letter.participants').'</b>';
	$res = array();
	foreach ($topic->flows as $flow) $res[] = $flow->user->username;
	echo implode(', ', $res).'.</p>';
}

echo $pagination->render();

if (count($nbr_comments) == 0) {
	?><div class="msgInfo"><?= Kohana::lang('forum.post.no_posts') ?></div><?php
} else {
	?>
	<p>
	<table class="forum2">
    <?php
    $tr = 0;
    $last_user_id = 0;
    $first_comment_id = $topic->comments[0]->id;
    $last_dark = " error";
    foreach ($comments as $comment) {
        $inc = true;
        $dark = ($tr % 2 == 0) ? ' dark' : "";
        if ($comment->user->status == 1) {$dark = ' modo'; $inc = false;}
        if ($comment->user->status == 2) {$dark = ' admin'; $inc = false;}
        if ($last_user_id == $comment->user_id) {$dark = $last_dark; $inc = false;}
        if ($inc) $tr += 1;
        ?>
        <tr>
        	<td class="left">
        		<?php
	            if ($last_user_id != $comment->user_id) {
	                echo $comment->user->display_image('thumbmail');?><br />
	                <b><?= html::anchor('user/view/'.$comment->user->username, $comment->user->username) ?></b>
	            	<?php if ($comment->user->is_connected()) echo " ".html::image('images/icons/online.png'); ?><br />
	                <?php echo $comment->user->display_status();
	            }
            	?>
        	</td>
        	<td class="right<?= $dark ?>" id="comment<?= $comment->id ?>">
        		<div class="signature">
        		
        			<div style="float:right;" class="interests">
	        				<?php
		        			if ($user->is_moderator() and $topic->type != 'private') 
		        			{
		        				$interest = ORM::factory('interest')
			        				->where('user_id', $user->id)
			        				->where('comment_id', $comment->id)
			        				->find();
			        			
			        			echo "Intérêt: ";
			        			$bold = ($interest->value == -1) ? " red" : "";
			        			echo '<span class="minus '.$bold.'">';
			  		      		echo html::anchor('comment/interest/'.$comment->id.'/-1', "-");
			  		      		echo '</span> ';
			  		      		
			  		      		$bold = ($interest->value == 1) ? " green" : "";
			  		      		echo '<span class="plus '.$bold.'">';
			  		      		echo html::anchor('comment/interest/'.$comment->id.'/1', "+");
			  		      		echo '</span> ';
			  		      		
			  		      		$somme = 0;
			        			foreach ($comment->interests as $interest)
			        				$somme += $interest->value;
			        			$class = "";
			        			if ($somme < 0) $class = " red";
			        			if ($somme > 0) $class = " green";
			        			echo '<span class="somme'.$class.'">';
			        			if ($somme > 0) echo "+";
			        			echo $somme;
			        			echo "</span> ";
			        			
			        			$class = ($interest->value) ? " grey" : " none";
			  		      		echo '<span class="delete '.$class.'">';
			        			echo html::anchor('comment/interest/'.$comment->id.'/0', "x");
			  		      		echo '</span>';
		  		      		
		  		      		}
		  		      		else
		  		      		{
		  		      			$somme = 0;
			        			foreach ($comment->interests as $interest)
			        				$somme += $interest->value;
			        			if ($somme != 0)
			        			{
				        			echo "Intérêt: ";
				        			$class = "";
				        			if ($somme < 0) $class = " red";
				        			if ($somme > 0) $class = " green";
				        			echo '<span class="somme'.$class.'">';
				        			if ($somme > 0) echo "+";
				        			echo $somme;
				        			echo "</span>";
		  		      			}
		  		      		}
		        			?>
	        		</div>
        		
            		<?php 
	            	echo html::anchor(
	            		'topic/view/'.$topic->id.'#comment'.$comment->id, 
	            		'#', 
	                	array('name'=>'comment'.$comment->id)
	                ).' ';
	                
	                ?>Posté il y a <?php echo gen::time_left($comment->created);
	                
	            	if ($user->loaded 
	            		and $comment->is_moderator($user) 
	            		and $topic->type != 'private') 
	            	{
	                	if ($comment->is_first())
	                	{
	                		echo ' ['.html::anchor('forum/topic/edit/'.$comment->topic->id, 'Editer').']'; 
	            		}
	            		else
	            		{
	            			echo ' ['.html::anchor('forum/comment/edit/'.$comment->id, 'Editer').']'; 
	            		}
	            	}
			            	
	            	if (!empty($comment->updated))
	            	{
	            		?><br />&nbsp;&nbsp; Modifié il y a <?php echo gen::time_left($comment->updated);
	            	}
	            	?>
            	</div>
        		<?php
        		$textile = new Textile;
				$content = $textile->TextileThis($comment->content);
        		echo $content;
            	?>
            </td>
        </tr>
        <?php
        $last_user_id = $comment->user_id;
        $last_dark = $dark;
    }
    ?>
	</table>
	</p><br />
<?php
}

if ( ($user->loaded and ($user->is_moderator() or ! $topic->locked)) ) 
{ ?>

<h2>Répondre</h2>

<?= form::open($link.$topic->id) ?>

<div class="reply" name="reply">
    <p>
        <?= form::textarea(array(
        	'id'=>'textile', 
        	'name'=>'content', 
        	'value'=>$form['content'],
        	'cols'=>'100',
        	'rows'=>'12'
        )) ?>
    </p>

    <p>
        <?= form::submit('submit', 'Envoyer') ?>
    </p>
</div>

<?php 
form::close();
} ?>