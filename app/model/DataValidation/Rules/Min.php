<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Min extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='مقدار وارد شده در فیلد ([?]) باید مساوی [?] یا بیشتر باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return (float)$value>=(float)$param;
	}
}
