<?php

if ($type == 'private') 
{
	echo '<h1>'.Kohana::lang('letter.title').'</h1>';
	echo '<div id="prelude">'.Kohana::lang('letter.prelude').'</div>';
	$link = "letter/edit";
}
else
{
	echo '<h1>'.Kohana::lang('forum.title').'</h1>';
	echo '<div id="prelude">'.Kohana::lang('forum.topic.edit.prelude').'</div>';
	$link = "forum/$type/edit/".$topic->id;
}

echo form::open($link);

$res = "";
foreach ($errors as $error) {
	if (!empty($error))
		$res .= "- ".$error.'<br />';
}
if (!empty($res)) {
	echo '<div class="msgAttention">'.$res."</div>";
}
?>

<h2>Informations</h2>

<div class="leftPart2">
	
	<p><table width="100%">
		
		<?php 
		if ($type != 'private') 
		{ 
			?>
			<tr>
				<td></td>
				<td class="label"><?= form::label('type', Kohana::lang('forum.topic.type')) ?></td>
				<td class="value">
					<?= form::dropdown('type', $list_types, $type) ?>
				</td>
			</tr>
			<?php 
		}
		else
		{
			echo form::hidden('type', 'private');
		}
		?>
		
		<?php if ($type == 'private') { ?>
		<tr>
			<td></td>
			<td class="label"><?= form::label('users', Kohana::lang('forum.topic.users')) ?></td>
			<td class="value">
				<?= form::dropdown('users') ?>
			</td>
		</tr> 
		<?php } ?>
		
		<?php 
		if ($type == 'bug' and $user->is_moderator()) 
		{ 
			?>
			<tr>
				<td></td>
				<td class="label"><?= form::label('level', Kohana::lang('forum.topic.level')) ?></td>
				<td class="value">
					<?= form::dropdown('level', $levels, $form['level']); ?>
				</td>
			</tr> 
			<?php 
		}
		else
		{
			echo form::hidden('level', 0);
		} 
		?>
		
		<?php 
		if ( ! empty($status) and $user->is_moderator()) 
		{ 
			?>
			<tr>
				<td></td>
				<td class="label">
					<?= form::label('status', Kohana::lang('forum.topic.status')) ?>
				</td>
				<td class="value">
					<?= form::dropdown('status', $status, $form['status']); ?>
				</td>
			</tr>
			<?php 
		}
		else 
		{
			echo form::hidden('status', 0);
		} 
		?>
		
		<tr>
			<td></td>
			<td class="label">
				<?= form::label('title', Kohana::lang('forum.topic.title')) ?>
			</td>
			<td class="value">
				<?= form::input('title', $form['title']) ?>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td class="label">
				<?= form::label('user_id', Kohana::lang('forum.topic.user')) ?>
			</td>
			<td class="value">
				<?php 
				echo '<b>'.gen::get_username($form['user_id']).'</b>';
				?>
			</td>
		</tr>
		
	</table></p>

</div>

<div class="leftPart">
	
	<?php if ($user->is_moderator() and $type != 'private') { ?>
	
		<p>
		<?= form::checkbox('sticky', '', $form['sticky']) ?>
		<?= form::label('sticky', Kohana::lang('forum.topic.sticky')) ?>
		<br />
		<?= form::checkbox('main_sticky', '', $form['main_sticky']) ?>
		<?= form::label('main_sticky', Kohana::lang('forum.topic.mainsticky')) ?></td>
		<br />
		<?= form::checkbox('locked', '', $form['locked']) ?>
		<?= form::label('locked', Kohana::lang('forum.topic.locked')) ?></td>
		<br />
		<?= form::checkbox('update', '', $form['update']) ?>
		<?= form::label('update', Kohana::lang('forum.topic.update')) ?></td>
		</p>
		
	<?php } ?>
	
</div>

<div class="clearBoth"></div>


<h2>Message</h2>

<?= form::textarea(array(
	'name'=>'content', 
	'value'=>$form['content'],
	'id'=>'textile'
)) ?>

<p>
	<?= html::anchor("forum/$type", html::image('images/buttons/back.gif')) ?>
	
	<?= form::submit('submit', 'Valider') ?>
</p>
	
<?php 
echo form::close();
?>
