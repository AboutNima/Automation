<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class Length extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='فیلد ([?]) باید [?] [?] حرف باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		if($value!='')
		{
			$param=explode(',',$param);
			switch($param[0])
			{
				case 'max':
					if(strlen($value)>(int)$param[1]) return false;
					break;
				case 'min':
					if(strlen($value)<(int)$param[1]) return false;
					break;
			}
		}
	}
}
