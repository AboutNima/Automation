<?php
$data=$db->objectBuilder()->get('News',null,[
	'id', 'title', 'link', 'description', 'demo', 'keywords',
	'UNIX_TIMESTAMP(archiveDate) as archiveDate','UNIX_TIMESTAMP(createdAt) as createdAt'
]);
$script='/public/account/admin/news';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/news.php';
require_once 'app/controller/motherPage/adminFooter.php';