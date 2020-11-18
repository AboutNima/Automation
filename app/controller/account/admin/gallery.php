<?php
$data=$db->objectBuilder()->get('Gallery',null,[
	'id', 'title', 'image', 'UNIX_TIMESTAMP(createdAt) as createdAt'
]);
$script='/public/account/admin/gallery';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/gallery.php';
require_once 'app/controller/motherPage/adminFooter.php';