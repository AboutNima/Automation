<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class EnglishCharacters extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='مقادیر وارد شده در فیلد ([?]) باید به زبان انگلیسی باشند';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return !(bool)preg_match('/[^A-Za-z 0-9]/',$value);
	}
}
