<?php
$data=$db->orderBy('id','DESC')->where('subId IS NULL')->
objectBuilder()->get('MST',null,[
	'id','QRCode','propertyNumber','description','type','size','company','count'
]);
$script='/public/account/admin/mechanizedScanning/tools/list';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/tools/list.php';
require_once 'app/controller/motherPage/footer.php';