<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Date extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='تاریخ وارد شده در فیلد ([?]) معتبر نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='')
		{
			$value=explode('/',$value);
			return (bool) checkdate($value[1],$value[2],$value[0]);
		}
	}
}