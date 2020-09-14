<?php
function randomText($length=5,$upperCase=true)
{
	$string='abcdefghijkmnopqrstuvwxyz0123456789';
	if($upperCase) $string.='ABCDEFGHJKLMNOPQRSTUVWXYZ';
	$output='';
	for($i=0;$i<$length;$i++)
	{
		$output.=$string[rand(0,strlen($string)-1)];
	}
	return $output;
}
function cryptPassword($password,$param,$salt='')
{
	return hash('sha256',$password.$param.md5('PasswordGenerator').sha1($password.$salt));
}
function randomCode($length=5)
{
	$output='';
	for($i=0;$i<$length;$i++) $output.=rand(0,9);
	return $output;
}
function humanTiming($time)
{
	$time=strtotime('now')-$time;
	$time=($time<1)?1:$time;
	$tokens=array(
		31536000=>'سال',
		2592000=>'ماه',
		604800=>'هفته',
		86400=>'روز',
		3600=>'ساعت',
		60=>'دقیقه',
		1=>'ثانیه'
	);
	foreach($tokens as $unit=>$text){
		if($time<$unit) continue;
		$numberOfUnits=floor($time/$unit);
		return $numberOfUnits.' '.$text.' پیش';
	}
}
function convertToGregorian($date,$delimiter='/')
{
	global $calendar;
	if(empty($date)) return '';
	require_once 'jDateTime.php';
	$date=explode($delimiter,$date);
	foreach($date as $item)
	{
		$fmt=numfmt_create('fa', NumberFormatter::DECIMAL);
		$cnt[]=numfmt_parse($fmt, $item);
	}
	return $calendar->date('Y/m/d', $calendar->mktime(12,0,0,
		$cnt[1],
		$cnt[2],
		$cnt[0]
	), false, false, 'America/New_York');
}
function faToEn($string){
	return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
}