<?php

namespace App\Utils;

/**
 * 
 */
class HttpRequest
{
	
	private $userAgent;

	function __construct()
	{
		$this->userAgent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36'.
        ' (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
	}

	public function post($url, $params = array(), $headers = array())
  {
    $curl = curl_init($url);

    $is_json = in_array('Content-Type: application/json', $headers);
    $params = $is_json ? json_encode($params) : http_build_query($params);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 15);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($curl);
    $response_info = curl_getinfo($curl);

    if (curl_errno($curl)) {
        throw new \Exception(curl_error($curl));
    }

    curl_close($curl);

    return (object) array(
      'response_raw' => $response,
      'response' => json_decode($response),
      'response_info' => (object) $response_info,
    );
  }

  public function get($url, $headers = array())
  {
  	// dd($headers);
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    // is_null($params) || curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    
    $response = curl_exec($curl);
    $response_info = curl_getinfo($curl);

    if (curl_errno($curl)) {
        throw new \Exception(curl_error($curl));
    }

    curl_close($curl);

    return (object) array(
      'response_raw' => $response,
      'response' => json_decode($response),
      'response_info' => (object) $response_info,
    );
  }
}