<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class UsernameCharacter extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='مقادیر وارد شده در فیلد ([?]) باید حروف مجاز باشد (a-z, A-Z, 0-9, _, {dote.})';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='') return (bool) preg_match(
			"/^[a-zA-Z][a-zA-Z0-9._]+$/",
			$value
		);
	}
}
