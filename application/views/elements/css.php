<?php
$css = 3;
if($css == 0) echo html::stylesheet('css/default1','screen', false);
elseif($css == 1) echo html::stylesheet('css/pure','screen', false); 
elseif($css == 2) echo html::stylesheet('css/tron','screen', false);
elseif($css == 3) echo html::stylesheet('css/1.0','screen', false);

?>