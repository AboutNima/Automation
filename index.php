<?php
// Set define and const
const ToolsType=[
	'آچار','پیچ گوشتی','قیچی','انبر'
];

// Set Date Default Time Zone
date_default_timezone_set('Asia/Tehran');

// Start ob_start() Function
ob_start();

// Read And Fetch config.ini.php File
$ini=parse_ini_file('config.ini.php',true,INI_SCANNER_TYPED);

// Include Model File
$model=[
	'jDateTime','DataValidation/Validation','function','Upload'
];

if(!is_array($model)) $model=[$model];
$model=array_merge(['MysqliDb'],$model);
foreach($model as $item) require_once 'app/model/'.$item.'.php';

// Get Url
$urlPath=explode('?',$_SERVER['REQUEST_URI'],2);
$urlPath=explode('/',$urlPath[0]);
array_splice($urlPath,0,1);
$urlPath[]=null;

//Convert Url
$urlCrt=array();
foreach($urlPath as $item)
{
	switch($item)
	{
		case 'account': $urlCrt[]='داشبورد';break;
		case 'setting': $urlCrt[]='تنظیمات';break;
		case 'list': $urlCrt[]='لیست';break;
		case 'add': $urlCrt[]='افزودن';break;
		case 'edit': $urlCrt[]='ویرایش';break;
		case 'tools': $urlCrt[]='ابزار';break;
		case 'history': $urlCrt[]='تاریخچه';break;
		case 'information': $urlCrt[]='مشخصات ثبت شده';break;
		case 'mechanizedScanning': $urlCrt[]='سیستم اسکن مکانیزه (QRCode)';break;
		default: $urlCrt[]=$item;break;
	}
}
unset($urlCrt[count($urlCrt)-1]);

// Start Session
session_start();

//Start Create Session Token
if(!isset($_SESSION['Token']) || empty($_SESSION['Token'])) $_SESSION['Token']=strtoupper(bin2hex(random_bytes(32)));

//Start Site Coding
if($urlPath[0]=='logout')
{
	if(isset($_COOKIE['Admin'])) setcookie('Admin',null,-1,'/');
	session_destroy();
	$location=isset($_GET['BackTo']) ? $_GET['BackTo'] : '/';
	die(header('location:'.$location));
}
switch($urlPath[0])
{
	// Ajax
	case 'ajax':
		require_once 'app/model/ajax.php';
		break;

	// Accounts
	case 'account':
		if(isset($_SESSION['Admin']))
		{
			$data=$db->where('id',$_SESSION['Admin']['id'])->
			objectBuilder()->getOne('Admin',[
				'id','name','surname','username','password','avatar','phoneNumber','nationalCode'
			]);
			if(empty($data) || $_SESSION['Admin']['password']!=$data->password || time()-$_SESSION['Admin']['timeOut']>7200) die(header('location:/logout'));
			$_SESSION['Admin']=[
				'timeOut'=>time(),
				'id'=>$data->id,
				'name'=>$data->name,
				'surname'=>$data->surname,
				'password'=>$data->password,
				'username'=>$data->username,
				'phoneNumber'=>$data->phoneNumber,
				'nationalCode'=>$data->nationalCode,
				'avatar'=>$data->avatar,
			];

			switch($urlPath[1])
			{
				case '':
					require_once 'app/controller/account/admin/home.php';
					break;
				case 'setting':
					require_once 'app/controller/account/admin/setting.php';
					break;
				case 'mechanizedScanning':
					switch($urlPath[2])
					{
						case 'tools':
							if(!empty($id=(int)$urlPath[3]))
							{
								switch($urlPath[4])
								{
									case 'information':
										require_once 'app/controller/account/admin/mechanizedScanning/tools/information.php';
										break;
									case 'history':
										require_once 'app/controller/account/admin/mechanizedScanning/tools/history.php';
										break;
									default:
										header('location:/404');
										break;
								}
							}
							else require_once 'app/controller/account/admin/mechanizedScanning/tools/list.php';
							break;
						case 'equipments':

							break;
					}
					break;
			}

		}else{
			require_once 'app/controller/account/admin/login.php';
		}
		break;

	// Page error
	case '404':
		require_once 'app/view/pageError/404.html';
		break;
	default:
		die(header('location:/404'));
		break;
}