<?php
$data=$db->orderBy('id','DESC')->where('subId IS NULL')->
objectBuilder()->get('MST',null,[
	'id','QRCode','propertyNumber','description','type','size','company','count',
	'(SELECT COUNT(SubMST.id) FROM MST as SubMST WHERE SubMST.subId=MST.id) as subCount',
	"(SELECT COUNT(id) FROM MSTHistory WHERE toolId=MST.id AND MSTHistory.status='0') as inUse",
]);
$students=$db->orderBy('surname','DESC')->orderBy('name','DESC')->
objectBuilder()->get('Students',null,[
	'id',"CONCAT(name,' ',surname) as name"
]);
$script=[
	'/public/construct/QRCodeReader/qrcode-reader.min',
	'/public/account/admin/mechanizedScanning/tools/list'
];
$link='/public/construct/QRCodeReader/qrcode-reader.min';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/tools/list.php';
require_once 'app/controller/motherPage/footer.php';