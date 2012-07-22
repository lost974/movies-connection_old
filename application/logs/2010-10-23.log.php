<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-10-23 14:05:16 +04:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column 'user_id' in 'where clause' - SELECT `mc_movies`.*
FROM (`mc_movies`)
WHERE `user_id` = 1
AND `movie_id` = '5'
ORDER BY `mc_movies`.`id` ASC
LIMIT 0, 1 in file /Users/Lost974/Sites/MoviesConnection/system/libraries/drivers/Database/Mysql.php on line 371
2010-10-23 14:07:59 +04:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Table 'lost974.mc_marks' doesn't exist - SHOW COLUMNS FROM `mc_marks` in file /Users/Lost974/Sites/MoviesConnection/system/libraries/drivers/Database/Mysql.php on line 371
