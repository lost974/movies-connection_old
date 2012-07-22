<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-01-02 14:54:17 +04:00 --- error: Uncaught PHP Error: Object of class ORM_Iterator could not be converted to string in file /Users/Lost974/Sites/MoviesConnection/application/views/users/profil.php on line 24
2011-01-02 14:57:27 +04:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column '$id' in 'where clause' - SELECT `mc_marks`.*
FROM (`mc_marks`)
WHERE `$id` = '2'
AND `user_id` = 0
ORDER BY `id` DESC
LIMIT 0, 5 in file /Users/Lost974/Sites/MoviesConnection/system/libraries/drivers/Database/Mysql.php on line 371
2011-01-02 14:58:43 +04:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column '$id' in 'where clause' - SELECT `mc_marks`.*
FROM (`mc_marks`)
WHERE `$id` = '2'
AND user_id
ORDER BY `id` DESC
LIMIT 0, 5 in file /Users/Lost974/Sites/MoviesConnection/system/libraries/drivers/Database/Mysql.php on line 371
2011-01-02 14:59:08 +04:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column '$id' in 'where clause' - SELECT `mc_marks`.*
FROM (`mc_marks`)
WHERE `$id` = '2'
AND `user_id` = 0
ORDER BY `id` DESC
LIMIT 0, 5 in file /Users/Lost974/Sites/MoviesConnection/system/libraries/drivers/Database/Mysql.php on line 371
