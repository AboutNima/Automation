<?php
$adminChat=$db->where('id',[$_SESSION['Admin']['id']],'NOT IN')->
orderBy('id','DESC')->objectBuilder()->get('Admin',null,[
	'id',"CONCAT(name,' ',surname) name",'avatar','online',
	"(SELECT COUNT(id) FROM ChatRoom WHERE receiverId={$_SESSION['Admin']['id']} AND senderId=Admin.id AND seen='0') as unread"
]);
require_once 'app/view/motherPage/adminHeader.php';