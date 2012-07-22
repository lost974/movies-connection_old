<?php

// forum
$config['forum'] = 'topic/index';
$config['forum/([a-z]+)'] = "topic/index/$1";
$config['forum/([a-z]+)/page/([0-9]+)'] = "topic/index/$1/page/$2";
$config['forum/([a-z]+)/([0-9]+)'] = "topic/view/$2";
$config['forum/([a-z]+)/([0-9]+)/page/([0-9]+)'] = "topic/view/$2/page/$3";
$config['forum/comment/edit/([0-9]+)'] = "comment/edit/$1";
$config['forum/([a-z]+)/edit'] = "topic/edit/0/$1";
$config['forum/([a-z]+)/edit/([0-9]+)'] = "topic/edit/$2/$1";
$config['forum/([a-z]+)/delete/([0-9]+)'] = "topic/delete/$2";

// letter
$config['letter'] = 'topic/index/private';
$config['letter/([0-9]+)'] = "topic/view/$1";
$config['letter/([0-9]+)/page/([0-9]+)'] = "topic/view/$1/page/$2";
$config['letter/edit'] = 'topic/edit/0/private';
//$config['letter/edit/([0-9]+)'] = "topic/edit/$1/private";
$config['letter/delete/([0-9]+)'] = 'topic/delete/$1';
