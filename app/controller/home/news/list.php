<?php
$news=$db->objectBuilder()->get('News',null,[
	'title','image','demo','link','UNIX_TIMESTAMP(createdAt) as createdAt'
]);
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/home/news/list.php';
require_once 'app/controller/motherPage/footer.php';