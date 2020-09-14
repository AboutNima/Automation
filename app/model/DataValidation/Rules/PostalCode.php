<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class PostalCode extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='کد پستی وارد شده معتر نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return (bool)preg_match("/^(\d{5}-?\d{5})$/", $value);
	}
}