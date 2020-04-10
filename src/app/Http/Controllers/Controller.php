<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $response_body;
    protected $status_codes;

    public function __construct() 
    {
        $this->response_body 	= config('constants.RESPONSE_CODE_BODY');
		$this->status_codes		= config('constants.STATUS_CODES');
    }
    //
	public function requestApi($method = 'POST', $end_point, $params = [])
	{
		$client = new Client();
		$api_url = env('API_URL');
		$requestContent = [
		  'headers' => [
		      'Accept' => 'application/json',
		      'Content-Type' => 'application/json',
		      'Api-Token' => Session::get('api_token', ''),
		  ],
		  'json' => $params,
		];
		try {
		    $response = $client->request($method, $api_url.$end_point, $requestContent);
		    return json_decode($response->getBody());
		} catch (ClientException $e) {
		  $response = $e->getResponse();
		  $responseBodyAsString = $response->getBody()->getContents();
		  return json_decode($responseBodyAsString);
		  // dd($e);
		}
	}
}
