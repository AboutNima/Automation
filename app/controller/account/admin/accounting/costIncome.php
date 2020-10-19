<?php
$title=$db->objectBuilder()->get('ACCTitles',null,[
	'id','title'
]);
$data=$db->join('ACCTitles','ACCTitles.id=titleId')->
objectBuilder()->get('ACCCostIncome',null,[
	'ACCCostIncome.id','subject','title','price','income','description',
	'UNIX_TIMESTAMP(ACCCostIncome.createdAt) as createdAt',
	'UNIX_TIMESTAMP(ACCCostIncome.updatedAt) as updatedAt'
]);
$script='/public/account/admin/accounting/costIncome';
require_once 'app/controller/motherPage/adminHeader.php';
require_once 'app/view/account/admin/accounting/costIncome.php';
require_once 'app/controller/motherPage/adminFooter.php';