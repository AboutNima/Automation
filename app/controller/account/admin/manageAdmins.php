<?php
if($_SESSION['Admin']['id']!=1) die(header('location:/404'));
$data=$db->where('id',['NOT IN'=>['1']])->
orderBy('id','DESC')->objectBuilder()->get('Admin',null,[
	'id',"CONCAT(name,' ',surname) as name",'username','phoneNumber','onlineFrom'
]);
$script='/public/account/admin/manageAdmins';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/manageAdmins.php';
require_once 'app/controller/motherPage/adminFooter.php';