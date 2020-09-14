<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Compare extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='')
		{
			$param=explode(',',$param);
			if((bool)preg_match("/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/",$value))
			{
				$value=strtotime($value);
				$param[0]=strtotime($param[0]);
			}
			if((bool)$param[1]===true) return $value<=$param[0];
			else return $value<$param[0];
		}
	}
}
