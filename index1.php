<?php
header("content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei'); //設定地點為台北時區

require_once("Api.php");

$api = new Api();

$dataArray = array();

/* 拆除本身自己網址抓取 apiName */
$url = $_SERVER['REQUEST_URI'];
$url = explode ( ".php/", $url );
$apiName = explode ( "?", $url[1] );

$username = $_GET['username'];
$amount = $_GET['amount'];
$transid = $_GET['transid'];
$type = $_GET['type'];
$key = $_GET['key'];

$date= date("Ymd");
if ($apiName[0]) {
	if (!preg_match("/^([a-zA-Z0-9]+)$/",$apiName[0])) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "API Error", "Message" => "API Input Error"));
		echo json_encode($dataArray);
		exit;
	}
}

/* 新增帳號API */
if ($apiName[0] == "addUser") {
	if (!$username) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No UserName"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$key) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Key"));
		echo json_encode($dataArray);
		exit;
	}
	if ($key != $date) {
		// key值輸入錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "Key Input Error"));
		echo json_encode($dataArray);
		exit;
	}

	$result = $api->addUser($username);

	if (!$result) {
		// 註冊失敗
		$dataArray = array("result" => false, "data" => array("Code" => $username, "Message" => "CreateUser Fail"));
		echo json_encode($dataArray);
		exit;
	}

	// 註冊成功
	$dataArray = array("result" => true, "data" => array("Code" => $username, "Message" => "NewUser Success"));
	echo json_encode($dataArray);
	exit;
}

/* 取得餘額API */
if ($apiName[0] == "getBalance") {
	if (!$username) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No UserName"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$key) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Key"));
		echo json_encode($dataArray);
		exit;
	}
	if ($key != $date) {
		// key值輸入錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "Key Input Error"));
		echo json_encode($dataArray);
		exit;
	}

	$result = $api->getBalance($username);

	// 餘額
	$dataArray = array("result" => true, "data" => array("Code" => $username, "Message" => "Balance:".$result));
	echo json_encode($dataArray);
	exit;
}

/* 轉帳API */
if ($apiName[0] == "transfer") {
	if (!$username) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No UserName"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$type) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Type"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$amount) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Amount"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$transid) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Transid"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$key) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Key"));
		echo json_encode($dataArray);
		exit;
	}
	if ($type != "IN" ) {
		if ($type != "OUT") {
			// type值輸入有誤
			$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "Type Input Error"));
			echo json_encode($dataArray);
			exit;
		}
	}
	if ($type != "OUT" ) {
		if ($type != "IN") {
			// type值輸入有誤
			$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "Type Input Error"));
			echo json_encode($dataArray);
			exit;
		}
	}
	if ($key != $date) {
		// key值輸入錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "Key Input Error"));
		echo json_encode($dataArray);
		exit;
	}
	$result = $api->transfer($username, $type, $amount, $transid);

	$balance = $result['balance'];
	$resultTure = $result['result'];
	$msg = $result['msg'];

	if (!$result) {
		// 轉帳失敗
		$dataArray = array("result" => false, "data" => array("Code" => $username, "Message" => "Transfer Fail"));
		echo json_encode($dataArray);
		exit;
	}
	if ($msg) {
		// 轉帳失敗
		$dataArray = array("result" => false, "data" => array("Code" => $username, "Message" => $msg));
		echo json_encode($dataArray);
		exit;
	}
	if ($resultTure) {
		// 轉帳成功
		$dataArray = array("result" => true, "data" => array("Code" => $username, "Balance" => $balance, "Message" => "Transfer Success"));
		echo json_encode($dataArray);
		exit;
	}

}

/* 確認轉帳API */
if ($apiName[0] == "checkTransfer") {
	if (!$transid) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Transid"));
		echo json_encode($dataArray);
		exit;
	}
	if (!$key) {
		// 參數錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "No Key"));
		echo json_encode($dataArray);
		exit;
	}
	if ($key != $date) {
		// key值輸入錯誤
		$dataArray = array("result" => false, "data" => array("Code" => "Parameter Error", "Message" => "Key Input Error"));
		echo json_encode($dataArray);
		exit;
	}

	$result = $api->checkTransfer($username, $transid);

	if (!$result) {
		// 紀錄
		$dataArray = array("result" => true, "data" => array("Code" => "Transid Error", "Message" => "Transid Number Is Null"));
		echo json_encode($dataArray);
		exit;
	}

	foreach($result as $row);

	// 紀錄
	$dataArray = array("result" => true, "data" => array("Code" => $row['type'], "Message" => $row['amount']));
	echo json_encode($dataArray);
	exit;
}
