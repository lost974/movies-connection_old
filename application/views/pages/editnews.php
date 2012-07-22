<div id="block">
<div id="name_block">Modifier la news:</div>
<?php

echo form::open('page/editnews/'.$news->id);

echo "Titre de la news : ";
echo form::input('title', $news->title);

echo "<br />Version : ";
echo form::input("version", $news->version);

echo "<br />Contenu de la news : <br />";
echo form::textarea(array('name'=>'content','value'=>$news->content,'rows'=>'10','cols'=>'100')); echo "<br />";

echo form::submit('submit', 'Modifier');

echo form::close();
//echo "<br/>".$this->message;

?>
</div>