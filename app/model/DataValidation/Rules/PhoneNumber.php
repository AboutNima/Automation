<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class PhoneNumber extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='شماره همراه باید با 09 آغاز شود و 11 رقم باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return (bool)preg_match('/^(09){1}[0-9]{9}+$/',$value);
	}
}