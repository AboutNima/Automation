<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Same extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='فیلد ([?]) با ([?]) یکسان نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='')
		{
			$param=explode(',',$param);
			if(isset($param[1]) && !((bool)$param[1]))
			{
				if($value===AbstractValidationRule::getValue($param[0])) return false;
			}else{
				if($value!==AbstractValidationRule::getValue($param[0])) return false;
			}
		}
	}
}