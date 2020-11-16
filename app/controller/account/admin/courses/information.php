<?php
$course=$webService->setPostData(['courseId'=>$id])->execute('getCourseInformation')['Result'];
if(empty($course)) die(header('location:/404'));
$urlCrt[2]=$course['title'];
$organizer=$webService->execute('getStatus')['Result'];
$registeredUsers=$webService->setPostData(['courseId'=>$id])->execute('getCourseRegisteredUsers')['Result'];
$script='/public/account/admin/students/list';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/courses/information.php';
require_once 'app/controller/motherPage/adminFooter.php';