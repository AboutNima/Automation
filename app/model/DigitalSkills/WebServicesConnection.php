<?php
class WebServicesConnection
{
	/**
	 * @var $ch | CUrl function
	 */
	private $ch;

	/**
	 * @var string $url
	 */
	private $url='https://dskills.ir/WebServices';

	/**
	 * @var $result
	 */
	private $result;

	/**
	 * @var array $postData
	 */
	private $postData=[];

	/**
	 * WebServicesConnection constructor.
	 * @param $ApiKey
	 * @param false $HTTPS
	 * @throws Exception
	 */
	public function __construct($ApiKey='',$HTTPS=false)
	{
		// Check curl exists
		if(!function_exists('curl_init'))
		{
			throw new Exception('CUrl Function must be installed to use this class');
		}


		// Add ApiKey to url
		$this->url.='?ApiKey='.$ApiKey;
		$this->ch=curl_init();

		// CUrl Setting
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_HEADER, false);
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT , 5);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $HTTPS);    # required for https urls
		curl_setopt($this->ch, CURLOPT_MAXREDIRS, 15);
	}

	/**
	 * Set post data
	 * @param array $post
	 */
	public function setPostData($postData=[])
	{
		$result=[];
		foreach($postData as $key=>$item) $result['Param['.$key.']']=$item;
		$this->postData=$result;
		return $this;
	}

	/**
	 * Set action and Execute
	 * @param $Method
	 */
	public function execute($Method,$returnObject=false)
	{
		// Set Method and Post Data
		$this->postData['Method']=$Method;
		curl_setopt($this->ch,CURLOPT_POSTFIELDS,$this->postData);

		// Get CUrl result
		$result=curl_exec($this->ch);

		// Get status
		$errNo=curl_errno($this->ch);
		$httpCode=curl_getinfo($this->ch);

		// Check if no connection create
		if($errNo!==0) throw new Exception(curl_error($this->ch).'. Error code: '.$errNo);
		if($httpCode['http_code']!==200) throw new Exception('HTTP Error code: '.$httpCode);

		// Close CUrl
//		curl_close($this->ch);

		// Return data
		$this->setResult($result);

		return json_decode($this->getResult(),!$returnObject);
	}

	/**
	 * Return result data
	 * @return mixed
	 * @param mixed $result
	 */
	private function getResult()
	{
		return $this->result;
	}
	private function setResult($result)
	{
		$this->result=$result;
	}
}
$webService=new WebServicesConnection(ApiKey);