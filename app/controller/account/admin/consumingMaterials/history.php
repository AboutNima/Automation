<?php
$data=$db->where('id',$id)->objectBuilder()->getOne('CMaterials',[
	'title'
]);
if(empty($data)) die(header('location:/404'));
$history=$db->join('CMaterials','CMaterials.id=CMId')->join('Students','Students.id=studentId', 'left')->
orderBy('CMHistory.id','DESC')->objectBuilder()->get('CMHistory',null,[
	"CONCAT(name,' ',surname) as name",
	'UNIX_TIMESTAMP(CMHistory.createdAt) as createdAt','UNIX_TIMESTAMP(CMHistory.updatedAt) as updatedAt',
	'changeRate','unit','(CMHistory.description) as description'
]);
$urlCrt[2]=$data->title;
$script='/public/account/admin/consumingMaterials/information';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/consumingMaterials/history.php';
require_once 'app/controller/motherPage/adminFooter.php';