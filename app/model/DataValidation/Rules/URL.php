<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class URL extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='لینک وارد شده در فیلد ([?]) معتبر نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	protected static function validationRule($value,$param)
	{
		if($value!='') return (bool)filter_var($value, FILTER_VALIDATE_URL);
	}
}