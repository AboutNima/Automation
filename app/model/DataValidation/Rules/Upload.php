<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Upload extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='پیوست/پیوست های انتخاب شده باید یکی از فرمت های ([?]) و حد اکثر حجم [?] کیلوبایت باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='' && $value['error']!==4)
		{
			$param=explode(',',$param);
			if(!isset($value[0]) || !is_array($value[0])) $value=[$value];
			foreach($value as $item)
			{
				$ext=explode('.',$item['name']);
				$ext=strtolower(end($ext));
				if(!in_array($ext,array_map('strtolower',explode('.',$param[0]))))
				{
					return false;
					break;
				}
				if(round($item['size']/1024)>$param[1])
				{
					return false;
					break;
				}
			}
		}
	}
}