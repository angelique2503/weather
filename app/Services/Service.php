<?php

namespace App\Services;

use Cache;
use GuzzleHttp\Client;

class Service
{
	protected $secretKey;
	protected $baseUri;

	public function get(string $endPoint, array $data = [])
	{
		return $this->send('GET', $endPoint.'?'.http_build_query($data));
	}

	public function send(string $method, string $endPoint, array $data = [])
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $this->baseUri.'/'.$endPoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
		]);

		$response = curl_exec($curl);
		curl_close($curl);

		return json_decode($response);
	}
}