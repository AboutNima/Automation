<?php
namespace C_J\DataValidation\Rules;
use C_J\DataValidation\AbstractValidationRule;
class CardNumber extends AbstractValidationRule{

	/**
	 * Custom error
	 * @var string
	 */
	private static $error='شماره کارت وارد شده معتبر نمی باشد';
	protected static function getError()
	{
		return self::$error;
	}

	public static function validationRule($value,$param)
	{
		$value=str_replace('-','',$value);
		if($value!='')
		{
			if(strlen($value)!==16) return false;
			if(!in_array((int)$value[0],[2,4,5,6,9])) return false;
			$check=0;
			for($i=1;$i<=16;$i++)
			{
				$num=(int)$value[$i-1];
				$num=$i%2===0 ? $num : $num*2;
				$check+=$num>9 ?  $num-9 : $num;
			}
			if($check%10===0) return true;
		}
	}
}
