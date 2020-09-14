<?php
$data=$db->where('id',$id)->where('subId IS NULL')->
objectBuilder()->getOne('MST',[
	'type'
]);
if(empty($data)) die(header('location:/404'));
$urlCrt[3]=$data->type=strtr($data->type,ToolsType);
$script='/public/account/admin/mechanizedScanning/tools/information';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/tools/history.php';
require_once 'app/controller/motherPage/footer.php';