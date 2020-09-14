<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Required extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='فیلد ([?]) الزامی است';
	protected static function getError()
	{
		return self::$error;
	}

	protected static function validationRule($value,$param)
	{
//		if(AbstractValidationRule::hasRule('upload'))
//		{
//			if(!isset($value) || $value['error']===4) return false;
//		}else{
			$value=$param!='noTrim' ? $value : trim($value);
			if(is_string($value)) return mb_strlen($value,'UTF-8') > 0;
			return !is_null($value);
//		}
	}
}