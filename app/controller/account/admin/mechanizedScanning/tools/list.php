<?php
$data=$db->orderBy('id','DESC')->where('subId IS NULL')->
objectBuilder()->get('MST',null,[
	'id','QRCode','propertyNumber','description','type','size','company','count'
]);
$script=[
	'/public/construct/QRCodeReader/qrcode-reader.min',
	'/public/account/admin/mechanizedScanning/tools/list'
];
$link='/public/construct/QRCodeReader/qrcode-reader.min';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/tools/list.php';
require_once 'app/controller/motherPage/footer.php';