<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('MSE',null,[
	'id','QRCode','title','company','propertyNumber','accessories','count','status','description'
]);
$script='/public/account/admin/mechanizedScanning/equipments/list';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/equipments/list.php';
require_once 'app/controller/motherPage/footer.php';