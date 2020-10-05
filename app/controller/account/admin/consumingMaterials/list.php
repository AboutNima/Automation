<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('CMaterials',null,[
	'id','title','propertyNumber','company','unit','description','UNIX_TIMESTAMP(createdAt) as createdAt',
	'count'
]);
$students=$db->objectBuilder()->get('Students',null,[
	'id',"CONCAT(name,' ',surname) as name"
]);
$_SESSION['DATA']['CMaterials']['ChangeRate']['ID']=array_column($students,'id');
$script='/public/account/admin/consumingMaterials/list';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/consumingMaterials/list.php';
require_once 'app/controller/motherPage/adminFooter.php';