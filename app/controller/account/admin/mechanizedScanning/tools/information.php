<?php
$data=$db->where('id',$id)->where('subId IS NULL')->
objectBuilder()->getOne('MST',[
	'propertyNumber','company','count','description','type'
]);
if(empty($data)) die(header('location:/404'));
$sub=$db->where('subId',$id)->objectBuilder()->get('MST',null,[
	'id','propertyNumber','company','count','description','size'
]);
$_SESSION['DATA']['MechanizedScanning']['Tools']=[
	'ID'=>$id,
	'TYPE'=>$data->type
];
$urlCrt[3]=$data->type=strtr($data->type,ToolsType);
$script='/public/account/admin/mechanizedScanning/tools/information';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/tools/information.php';
require_once 'app/controller/motherPage/footer.php';