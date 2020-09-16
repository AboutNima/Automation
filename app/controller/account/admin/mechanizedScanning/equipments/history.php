<?php
$data=$db->where('id',$id)->
objectBuilder()->getOne('Eq',[
	'type'
]);
if(empty($data)) die(header('location:/404'));
$script='/public/account/admin/mechanizedScanning/equipments/information';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/equipments/history.php';
require_once 'app/controller/motherPage/footer.php';