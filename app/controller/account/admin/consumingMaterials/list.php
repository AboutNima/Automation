<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('CMaterials',null,[
	'id','title','company','unit','count','description','UNIX_TIMESTAMP(createdAt) as createdAt'
]);
$script='/public/account/admin/consumingMaterials/list';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/consumingMaterials/list.php';
require_once 'app/controller/motherPage/adminFooter.php';