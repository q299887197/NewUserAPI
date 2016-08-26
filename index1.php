<?php
header("content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei'); //設定地點為台北時區

require_once("Api.php");

$api = new Api();

/* 拆除本身自己網址抓取 apiName */
$url = $_SERVER['REQUEST_URI'];
$url = explode ( ".php/", $url );
$apiName = explode ( "?", $url[1] );

$dataArray = array();
$username = $_GET['username'];
$amount = $_GET['amount'];
$transid = $_GET['transid'];
$type = $_GET['type'];
$key = $_GET['key'];

$date= date("Ymd");

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
		echo "參數錯誤";
		exit;
	}
	if (!$type) {
		echo "參數錯誤";
		exit;
	}
	if (!$amount) {
		echo "參數錯誤";
		exit;
	}
	if (!$transid) {
		echo "參數錯誤";
		exit;
	}
	if (!$key) {
		echo "參數錯誤";
		exit;
	}
	if ($type != "IN" ) {
		if ($type != "OUT") {
			echo "type值輸入有誤";
			exit;
		}
	}
	if ($type != "OUT" ) {
		if ($type != "IN") {
			echo "type值輸入有誤";
			exit;
		}
	}
	if ($key != $date) {
		echo "key值輸入錯誤!";
		exit;
	}
	$result = $api->transfer($username, $type, $amount, $transid);

	$balance = $result['balance'];
	$resultTure = $result['result'];
	$msg = $result['msg'];

	if (!$result) {
		echo "轉帳失敗";
	}

	if ($resultTure) {
		echo "轉帳成功".$username."目前餘額有".$balance."元";
	}

	if ($msg) {
		echo $msg;
	}

}

/* 確認轉帳API */
if ($apiName[0] == "checkTransfer") {
	if (!$transid) {
		echo "參數錯誤";
		exit;
	}
	if (!$key) {
		echo "參數錯誤";
		exit;
	}
	if ($key != $date) {
		echo "key值輸入錯誤!";
		exit;
	}
	$result = $api->checkTransfer($username, $transid);

	foreach($result as $row);

	echo "此筆交易, 動作: ".$row['type'].", 交易金額: ".$row['amount'];
	// echo "此筆交易: ".json_encode($result);
}
