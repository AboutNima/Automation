<?php
$script='/public/account/admin/certificates';
$data=$db->orderBy('id','DESC')->
objectBuilder()->get('Certificates',null,[
	'id','title','UNIX_TIMESTAMP(createdAt) as createdAt'
]);
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/certificates.php';
require_once 'app/controller/motherPage/adminFooter.php';