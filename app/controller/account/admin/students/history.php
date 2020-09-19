<?php
$data=$db->where('id',$id)->objectBuilder()->getOne('Students',[
	"CONCAT(name,' ',surname) as name",'id'
]);
if(empty($data)) die(header('location:/404'));
$history=$db->where('studentId',$data->id)->join('MSE','toolId=MSE.id')->orderBy('MSEHistory.id','DESC')->
objectBuilder()->get('MSEHistory',null,[
	'UNIX_TIMESTAMP(MSEHistory.createdAt) as createdAt','UNIX_TIMESTAMP(MSEHistory.updatedAt) as updatedAt',
	'MSEHistory.status','MSE.title'
]);
$history1=$db->where('studentId',$data->id)->join('MST','toolId=MST.id')->orderBy('MSEHistory.id','DESC')->
objectBuilder()->get('MSEHistory',null,[
	'UNIX_TIMESTAMP(MSEHistory.createdAt) as createdAt','UNIX_TIMESTAMP(MSEHistory.updatedAt) as updatedAt',
	'MSEHistory.status','MST.type'
]);
$urlCrt[2]=$data->name;
$script='/public/account/admin/students/information';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/students/history.php';
require_once 'app/controller/motherPage/footer.php';