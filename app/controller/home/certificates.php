<?php
$certificates=$db->objectBuilder()->get('Certificates',null,[
	'title','photo','description'
]);
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/home/certificates.php';
require_once 'app/controller/motherPage/footer.php';