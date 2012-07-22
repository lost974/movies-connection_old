<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<style type="text/css" translate="none"> 
body
{
	width: 1000px;
  	margin: auto;
	background-color: white;
}
#page
{
	text-align: center;
	font-size: 60px;
}
#text
{
	font-size: 30px;
}
#form
{
	text-align: center;
}	
</style>
<script type="text/javascript">
$(document).ready(function()
	{
		$('#form').hide();
		$('#click_hide').hide();
		$('#click').click(function(){ 
					$('#form').show();
					$('#click').hide();
					$('#click_hide').show();
				});
		$('#click_hide').click(function(){ 
					$('#form').hide();
					$('#click_hide').hide();
					$('#click').show();
				});
	});
</script>

	<head>
		<title>| Movies Connection BETA | </title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
	<?php
$valid = new Validation($_POST);
$valid->add_rules('username', 'required');
$valid->add_rules('password', 'required');
if($valid->validate())
{
	if ($valid->username and $valid->password)
	{
		$user = ORM::factory('user')
			->where('username', $valid->username)
			->where('password', sha1($valid->password))
			->find();
		if ($user->id == '1')
		{
			$this->session->set('user', $user);
			url::redirect('page/news');
		}
		
	}
}
$site = ORM::factory('maintenance')->where('id', '1')->find();
if($site->open == "1")
{
	url::redirect('page/home');
}
?>
</html>
	<div id="page">
		<?php 
		echo html::image('images/maintenance.jpeg');
		echo $content; ?>
	</div>
	<div id="form">
		<?php
		echo "<div id='login'>";
		echo form::open('page/maintenance');
		echo form::input('username','');
		echo form::password("password","");
		echo form::submit('submit', 'Go');
		echo form::close();
		echo "</div>";
		?>
	</div>
	</body>
</html>