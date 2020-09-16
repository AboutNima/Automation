<?php
$data=$db->where('id',$id)->where('subId IS NULL')->
objectBuilder()->getOne('MST',[
	'type','(SELECT COUNT(SubMST.id) FROM MST as SubMST WHERE SubMST.subId=MST.id) as subCount'
]);
if(empty($data)) die(header('location:/404'));
if(!empty($data->subCount)) $db->join('MST','MST.id=subToolId');
else $db->join('MST','MST.id=toolId');
$history=$db->where('toolId',$id)->orderBy('MSTHistory.id','DESC')->
join('Students','Students.id=studentId')->
objectBuilder()->get('MSTHistory',null,[
	"CONCAT(name,' ',surname) as name",
	'UNIX_TIMESTAMP(MSTHistory.createdAt) as createdAt','UNIX_TIMESTAMP(MSTHistory.updatedAt) as updatedAt',
	'MSTHistory.status'
]);
$urlCrt[3]=$data->type=strtr($data->type,ToolsType);
$script='/public/account/admin/mechanizedScanning/tools/information';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/account/admin/mechanizedScanning/tools/history.php';
require_once 'app/controller/motherPage/footer.php';