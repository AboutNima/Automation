<?php
$teachers=$webService->execute('getTeachers');
$courses=$webService->execute('getCourses');
require_once 'app/controller/motherPage/header.php';
require_once 'app/view/home/home.php';
require_once 'app/controller/motherPage/footer.php';