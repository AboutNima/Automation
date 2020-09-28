<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('MSE',null,[
	'id','QRCode','title','company','propertyNumber','accessories','count','status','description',
	"(SELECT COUNT(id) FROM MSEHistory WHERE toolId=MSE.id AND MSEHistory.status='0') as inUse"
]);
$students=$db->orderBy('surname','DESC')->orderBy('name','DESC')->
objectBuilder()->get('Students',null,[
	'id',"CONCAT(name,' ',surname) as name"
]);
$script=[
	'/public/construct/QRCodeReader/qrcode-reader.min',
	'/public/account/admin/mechanizedScanning/equipments/list'
];
$link='/public/construct/QRCodeReader/qrcode-reader.min';
$tableExport=true;
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/mechanizedScanning/equipments/list.php';
require_once 'app/controller/motherPage/adminFooter.php';