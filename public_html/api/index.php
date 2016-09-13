<?php

error_reporting(E_ALL);

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$parse_url = parse_url($_SERVER["REQUEST_URI"]);
	$path = preg_split('/\/+/', $parse_url['path'], -1, PREG_SPLIT_NO_EMPTY);

	$controller = isset($path[1]) ? $path[1] : '';
	
	include '../fns.inc.php';

	if (!session_id()) {
		session_start();
	}

	if ($controller == 'update')
	{
		$status = false;
		$responce = array();
		
		$responce['domain'] = isset($_GET['url']) ? trim($_GET['url']) : '';

		$result = _curl($responce['domain']);

		if (!empty($result)) {
			$status = true;

			$responce['http_code'] = $result['http_code'];
		}

		// $sites = json_decode(file_get_contents($json), true);
		// $codes = json_decode(file_get_contents($errors), true);
	
		// exit(__($sites));

		// echo '<pre>';
		// print_r($responce);
		
		// exit;

		$responce['status'] = $status;

		exit(json_encode($responce, 64 | 256));
	}

	return true ;
}

// 
// $code_name = '';
// $code_class = $result['http_code'] == '200' ? 'success': 'fail';

// if ($result['primary_ip'] == $site['ip']) {
//     $ip_class = 'success';
//     $code_status = 'ok';
// }
// else {
//     $ip_class = 'fail';
//     $code_status = 'error';
// }

// if (isset($codes[$result['http_code']])) {
//     $code_name = $codes[$result['http_code']];
// }

// echo '<span class="' . $code_class . '">' . $result['http_code'] . '</span>', ' ', $code_name;
// echo '<br>';
// echo $result['primary_ip'], ' <span class="' . $ip_class . '">' . $code_status . '</span>';;
// echo '<br>';
// echo '<a href="http://'. $site['url'] .'" target="_blank">', $site['url'], '</a>', '<br>', '<br>';
// echo '------------';
// echo '<br>', '<br>';

