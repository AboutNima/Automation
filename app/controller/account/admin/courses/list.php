<?php
$data=$webService->execute('getCourses',false);
$script='/public/account/admin/students/list';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/courses/list.php';
require_once 'app/controller/motherPage/adminFooter.php';