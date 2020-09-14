<?php
use C_J\DataValidation\AbstractValidationRule;
require_once 'AbstractValidationRule.php';

class Validation{

	/**
	 * @var array
	 */
	private $errors=[];

	/**
	 * @var string
	 */
	private $namespace='C_J\DataValidation\Rules\\';

	/**
	 * @var bool
	 * @var string
	 */
	private $injectedData=true;
	private $injectedMessage='اطلاعات دریافتی قابل قبول نمی باشد';

	/**
	 * Validation constructor.
	 * @param $data
	 * @param $validation
	 * @param bool $checkInjectedData
	 * @throws Exception
	 */
	public function __construct($data,$validation,$checkInjectedData=true)
	{
		foreach(glob(__DIR__.'/Rules/*.php') as $file)
		{
			require_once $file;
			$file=basename($file,'.php');
			if(!class_exists($this->namespace.$file))
			{
				throw new Exception("The class name must be the same as the file name in: {$this->namespace} {$file}");
			}
			if(!is_subclass_of($this->namespace.$file,AbstractValidationRule::class))
			{
				throw new Exception("Class '{$file}' must be extends of AbstractValidationRule class");
			}
		}
		AbstractValidationRule::clear();
		$this->setDataAndRule($data,$validation,$checkInjectedData);
	}

	/**
	 * Set data and rule to start validation
	 * @param array $data
	 * @param array $validation
	 * @throws Exception
	 */
	public function setDataAndRule(array $data,array $validation,$checkInjectedData)
	{
		if($checkInjectedData===true || !empty($checkInjectedData))
		{
			if($checkInjectedData!==true && !is_array($checkInjectedData)) $checkInjectedData=[$checkInjectedData=>0];
			elseif($checkInjectedData!==true) $checkInjectedData=array_flip($checkInjectedData);
			if(!empty(array_diff_key($data,is_array($checkInjectedData) ? $validation+$checkInjectedData : $validation)))
			{
				$this->injectedData=false;
				$this->appendErrors($this->injectedMessage);
			}
		}
		foreach($validation as $name=>$mix)
		{
			if(!is_array($mix)) $mix=[$mix];
			foreach($mix as &$item)
			{
				$error=null;
				if(preg_match('/'.preg_quote('[','/').'(.*?)'.preg_quote(']','/').'/',$item,$error))
				{
					$item=preg_replace('/'.preg_quote('[','/').'(.*?)'.preg_quote(']','/').'/','',$item,1);
					$error[0]='[]';
				}elseif(preg_match('/'.preg_quote('{','/').'(.*?)'.preg_quote('}','/').'/',$item,$error))
				{
					$item=preg_replace('/'.preg_quote('{','/').'(.*?)'.preg_quote('}','/').'/','',$item,1);
					$error[0]='{}';
				}
				$item=[
					'rule'=>$item,
					'error'=>$error
				];
			}
			unset($item);

			if(!isset($data[$name])) throw new Exception("Name '{$name}' was not found in submitted data");
			AbstractValidationRule::convert([
				$name=>[
					'value'=>$data[$name],
					'rules'=>$mix
				]
			],$data);
		}
	}

	/**
	 * Get validation status
	 * @return array
	 */
	public function getStatus()
	{
		return in_array(false,AbstractValidationRule::getValidationsStatus()+['checkInjectedData'=>$this->injectedData]) ? true : false;
	}

	/**
	 * @param string $message
	 */
	public function appendErrors($message)
	{
		array_push($this->errors,$message);
	}

	/**
	 * Get validation errors
	 * @return array
	 */
	public function getErrors()
	{
		return array_merge($this->errors,AbstractValidationRule::getValidationErrors());
	}

}