<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class HomeNumber extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='شماره ثابت وارد شده باید با پیش شماره شهر همراه باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return (bool)preg_match('/^(0[1-9]{2})[2-9][0-9]{7}+$/',$value);
	}
}