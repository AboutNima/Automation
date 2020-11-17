<?php
$teachers=$webService->execute('getTeachers');
$courses=$webService->execute('getCourses');
require_once 'app/view/motherPage/header.php';