<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('Students',null,[
	'id','QRCode','name','surname','createdAt'
]);
$script=[
	'/public/construct/QRCodeReader/qrcode-reader.min',
	'/public/account/admin/students/list'
];
$link='/public/construct/QRCodeReader/qrcode-reader.min';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/students/history.php';
require_once 'app/controller/motherPage/footer.php';