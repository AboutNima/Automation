<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class NationalCode extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='کد ملی وارد شده معتبر نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='')
		{
			$length=strlen($value);
			if($length!=10) return false;
			$check=(int)$value[9];
			$sum=0;
			for($i=0;$i<=8;$i++) $sum+=(int)$value[$i]*(10-$i);
			$sum%=11;
			if($sum<2) return $sum===$check ? true : false;
			else return $sum===11-$check ? true : false;
		}
	}
}
