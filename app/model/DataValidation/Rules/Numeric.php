<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Numeric extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='مقدار وارد شده در فیلد ([?]) باید عدد باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return is_string($value) && is_numeric($value);
	}
}