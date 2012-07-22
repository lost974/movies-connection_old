<div id="block">
<div id="name_block">Ajouter une news :</div>

<?php 

echo form::open('page/addnews');

echo "Titre de la news: ";
echo form::input('title','');

echo "<br />Version du site : ";
echo form::input('version','');

echo "<br />News : <br />";
echo form::textarea(array('name'=>'content','rows'=>'10','cols'=>'100'));

echo "<br />";
echo form::submit('submit', 'Ajouter');

echo form::close();
//echo "<br/>".$this->message;

?>
</div>