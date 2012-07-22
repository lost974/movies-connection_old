<span id="alphabetic">
<?php
$l = '65';
echo '| ';
while($l <= 90)
{
	echo html::anchor('movie/alphabetic/'.chr($l),chr($l));
	echo ' | ';
	$l++;
}
?>
</span>
<br />
<div id="block">
<div id="name_block"><?php echo $letter; ?></div>
<?php
if (count($movies)==0)
{
	echo "Désoler il n'y a pas de film commençant par ".$letter;
}
else
{
	foreach($movies as $movie)
	{
		?><span id="movie_<?php echo $movie->id; ?>"><?php
		echo $movie->title.'<br />';
		?>
		<div id="popup_<?php echo $movie->id; ?>" style="display:none;">
			<?php $display_image = $movie->display_image();
			echo $display_image; ?>
		</div>
		<script type="text/javascript">
   			$(window).bind('load', function() {
        		$('#movie_<?php echo $movie->id; ?>').bubbletip(
        			$('#popup_<?php echo $movie->id; ?>'), 
        			{
        				deltaDirection: "right",
        				delayHide: 100
        			}
        		);
			});
		</script>
		<?php 
			}
		?></span><?php
}
		?>
</div>