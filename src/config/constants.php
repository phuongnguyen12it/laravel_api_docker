<?php 
  return [

  	'STATUS_CODES' => [
  		'SUCCESS' 				=> 200,
  		'VALIDATE'				=> 400,
  		'UNAUTHEN'				=> 401,
  		'UNKNOWN'				=> 500,
  		'NO_DATA'				=> 404,
  		'FUNCTION_NOT_EXCUTE' 	=> 405,
  	],

  	'RESPONSE_CODE_BODY' => [
  		'SUCCESS' => [
  			'success'	=> true,
  			'msg' 		=> 'Success',// value default
  			'data'		=> [],
  			'code'		=> 200,
  		],
  		'VALIDATE' => [
  			'success'	=> false,
  			'msg' 		=> 'Input failed', // value default
  			'data'		=> [],
  			'code'		=> 400,
  		],
  		'UNAUTHEN' => [
  			'success'	=> false,
  			'msg' 		=> 'Unauthen', // value default
  			'data'		=> [],
  			'code'		=> 401,
  		],
  		 'NO_DATA' => [
  			'success'	=> false,
  			'msg' 		=> 'No data available', // value default
  			'data'		=> [],
  			'code'		=> 404,
  		],
  		'UNKNOWN' => [
  			'success'	=> false,
  			'msg'		=> 'Unknown error', // value default
  			'data'		=> [],
  			'code'		=> 500,
  		],
  		'FUNCTION_NOT_EXCUTE' =>[
  			'success'	=> false,
  			'msg'		=> 'Method Not Allowed', // value default
  			'data'		=> [],
  			'code'		=> 405,
  		],
  	],

  ];