<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class ShebaNumber extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='شماره شبا وارد شده صحیح نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='')
		{
			if(strlen($value)!=26 || strtoupper(substr($value,0,2))!='IR') return false;
			$value=substr($value,4).'1827'.substr($value,2,2);
			return bcmod($value,97)=='1' ? true : false;
		}
	}
}
