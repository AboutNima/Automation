<?php
$data=$db->where('id',$id)->objectBuilder()->getOne('MSE',[
	'title'
]);
if(empty($data)) die(header('location:/404'));
$history=$db->where('toolId',$id)->orderBy('MSEHistory.id','DESC')->
join('MSE','MSE.id=toolId')->join('Students','Students.id=studentId')->
objectBuilder()->get('MSEHistory',null,[
	"CONCAT(name,' ',surname) as name",
	'UNIX_TIMESTAMP(MSEHistory.createdAt) as createdAt','UNIX_TIMESTAMP(MSEHistory.updatedAt) as updatedAt',
	'MSEHistory.status'
]);
$urlCrt[3]=$data->title;
$tableExport=true;
$script='/public/account/admin/mechanizedScanning/tools/information';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/mechanizedScanning/equipments/history.php';
require_once 'app/controller/motherPage/adminFooter.php';