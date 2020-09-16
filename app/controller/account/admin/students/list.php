<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('Students',null,[
	'id','QRCode',"CONCAT(name,' ',surname) as name",'nationalCode','phoneNumber','UNIX_TIMESTAMP(Students.birthyDay) as birthDay',
	'UNIX_TIMESTAMP(Students.createdAt) as createdAt'
]);
$script=[
	'/public/construct/QRCodeReader/qrcode-reader.min',
	'/public/account/admin/students/list'
];
$link='/public/construct/QRCodeReader/qrcode-reader.min';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/students/list.php';
require_once 'app/controller/motherPage/footer.php';