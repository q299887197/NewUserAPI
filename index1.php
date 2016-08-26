<?php
header("content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei'); //設定地點為台北時區

require_once("Api.php");

$api = new Api();

$url = $_SERVER['REQUEST_URI'];
$url = explode ( ".php/", $url );
$apiName = explode ( "?", $url[1] );

$username = $_GET['username'];
$amount = $_GET['amount'];
$transid = $_GET['transid'];
$type = $_GET['type'];
$key = $_GET['key'];

$date= date("Ymd");

/* 新增帳號API */
if ($apiName[0] == "addUser") {
	if (!$username) {
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
	$result = $api->addUser($username);

	if (!$result) {
		echo "註冊失敗!";
		exit;
	}

	echo "註冊成功! 帳號為: ".$username."。";
	exit;
}

/* 取得餘額API */
if ($apiName[0] == "getBalance") {
	if (!$username) {
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

	$result = $api->getBalance($username);

	echo "帳號".$username."目前餘額有".$result."元";
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
