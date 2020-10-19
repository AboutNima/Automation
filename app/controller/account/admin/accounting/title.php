<?php
$data=$db->objectBuilder()->get('ACCTitles',null,[
	'id','title','UNIX_TIMESTAMP(createdAt) as createdAt','UNIX_TIMESTAMP(updatedAt) as updatedAt'
]);
$script='/public/account/admin/accounting/title';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/accounting/title.php';
require_once 'app/controller/motherPage/adminFooter.php';