<?php

namespace C_J\DataValidation;
abstract class AbstractValidationRule{

	/**
	 * Don`t TOUCH this FUCKING functions !!!!!!
	 * Abstract validationRule function
	 * @param mixed $value
	 * @param mixed $param
	 */
	abstract protected static function validationRule($value,$param);
	abstract protected static function getError();


	/**
	 * @var string
	 */
	private static $namespace='C_J\DataValidation\Rules\\';

	/**
	 * @var array
	 */
	private static $value=[];

	/**
	 * @var array
	 */
	private static $rules=[];

	/**
	 * @var array
	 */
	private static $validationsStatus=[];

	/**
	 * @var mixed
	 */
	private static $inputError;

	/**
	 * @var array
	 */
	private static $error=[];



	/**
	 * Set and get values
	 * @param $input
	 * @param string $index
	 */
	private static function setValue($input)
	{
		self::$value=$input;
	}
	protected static function getValue(string $index)
	{
		return self::$value[$index];
	}

	/**
	 * Check if input has Rule
	 * @param string $target
	 */
	protected static function hasRule(string $target)
	{
		return (bool)in_array(ucfirst($target),array_map('ucfirst',self::getRules()));
	}

	/**
	 * Set and get Rules
	 * @param array $rules
	 */
	private static function setRules(array $rules)
	{
		foreach($rules as &$rule) $rule=explode(':',$rule)[0];
		self::$rules=$rules;
	}
	protected static function getRules()
	{
		return self::$rules;
	}

	/**
	 * Convert data and call processRule function to validate input
	 * @param array $input
	 */
	public static function convert(array $input,$values)
	{
		$index=key($input);
		$rules=$input[$index]['rules'];

		self::setRules(array_column($rules,'rule'));
		self::setValue($values);

		foreach($rules as $item)
		{
			$item['rule']=explode(':',$item['rule']);
			$item['rule'][1]=isset($item['rule'][1]) ? $item['rule'][1] : null;
			self::setInputError($item['error']);
			$output=self::processRule($index,$item['rule'][0],$item['rule'][1]);
			if(!empty($item['rule'][1])) $item['rule'][1]=':'.$item['rule'][1];
			if($output===false) self::$validationsStatus[$index.'|'.ucfirst($item['rule'][0]).':'.$item['rule'][1]]=$output;
		}
	}

	/**
	 * Set and get input error
	 * @param $error
	 */
	private static function setInputError($error)
	{
		self::$inputError=!empty($error) ? [$error[0],explode(',',$error[1])] : false;
	}
	private static function getInputError()
	{
		return self::$inputError;
	}

	/**
	 * Process rule
	 * @param string $index
	 * @param string $rule
	 * @param $param
	 * @return bool
	 * @throws \Exception
	 */
	private static function processRule(string $index, string $rule,$param)
	{
		$class=self::$namespace.ucfirst($rule);
		$output=$class::validationRule(self::getValue($index),$param);

		$output=$output===null ? true : $output;
		if(!in_array($output,[
			false,0,
			true,1
		],true)) throw new \Exception("Return value from '{$class}' must be true or false");

		if(!$output)
		{
			if(self::getInputError()===false) self::setInputError(['[]',$param]);
			$inputError=self::getInputError();
			switch($inputError[0])
			{
				case '[]':
					$error=$class::getError();
					foreach(self::getInputError()[1] as $index)
					{
						$error=preg_replace('/'.preg_quote('[?]','/').'/',$index,$error,1);
					}
					break;
				case '{}':
					$error=self::getInputError()[1][0];
					break;
			}
			self::$error[]=$error;
		}
		return $output;
	}

	/**
	 * Return validation status as array
	 */
	public static function getValidationsStatus()
	{
		return self::$validationsStatus;
	}

	/**
	 * Return errors as array
	 */
	public static function getValidationErrors()
	{
		return self::$error;
	}

	/**
	 * Clear class
	 */
	public static function clear()
	{
		self::$error=[];
		self::$validationsStatus=[];
	}

}