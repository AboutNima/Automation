<?php
$data=$db->where('id',$id)->objectBuilder()->getOne('Students',null,[
	'id','name','surname','name_en as enN','surname_en as enS','nationalCode','birthCNumber','phoneNumber',
	'homeNumber','birthDay','education','address','job','createdAt'
]);
if(empty($data)) die(header('location:/404'));
$urlCrt[2]=$data->name.' '.$data->surname;
$script='/public/account/admin/students/information';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/students/information.php';
require_once 'app/controller/motherPage/adminFooter.php';