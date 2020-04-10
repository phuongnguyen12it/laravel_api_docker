<?php 

if (!function_exists('handleDataUserModel')) {
	function handleDataUserModel($params){
		$data_result = [
		'name' => !empty($params['name']) ? $params['name'] : '',
		'password' => !empty($params['password']) ? Hash::make($params['password']) : '',
		'phone_number' => !empty($params['phone_number']) ? $params['phone_number'] : '',
		'note' => !empty($params['note']) ? $params['note'] : '',
		];
		if (!empty($params['email'])) {
		    $data_result['email'] = $params['email'];
		}
		return $data_result;
	}
}