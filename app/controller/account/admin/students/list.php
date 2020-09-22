<?php
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('Students',null,[
	'id',"CONCAT(name,' ',surname) as name",'nationalCode','phoneNumber','UNIX_TIMESTAMP(birthDay) as birthDay',
]);
$script='/public/account/admin/students/list';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/students/list.php';
require_once 'app/controller/motherPage/adminFooter.php';