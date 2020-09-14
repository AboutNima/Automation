<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class PersianCharacter extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='مقادیر وارد شده در فیلد ([?]) باید به زبان فارسی باشند';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return (bool) preg_match(
			"/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u",
			$value
		);
	}
}
