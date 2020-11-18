<?php
$data=$db->where('link',$link)->objectBuilder()->getOne('News',[
	'id','title','image','demo','link','UNIX_TIMESTAMP(createdAt) as createdAt','description'
]);
if(empty($data)) header('location:/404');
$news=$db->objectBuilder()->where('id',[$data->id],'NOT IN')->get('News',10,[
	'title','image','demo','link','UNIX_TIMESTAMP(createdAt) as createdAt'
]);
$customText='اخبار مجموعه ریوکو';
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/home/news/information.php';
require_once 'app/controller/motherPage/footer.php';