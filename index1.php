<?php
header("content-type: text/html; charset=utf-8");

require_once("Api.php");

$api = new Api();

$url = $_SERVER['REQUEST_URI'];
$url = explode ( ".php/", $url );
$apiName = explode ( "?", $url[1] );

$username = $_GET['username'];
$amount = $_GET['amount'];
$transid = $_GET['transid'];
$type = $_GET['type'];


/* 新增帳號API */
if ($apiName[0] == "addUser") {
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
	$result = $api->getBalance($username);

	echo "帳號".$username."目前餘額有".$result."元";
}

/* 轉帳API */
if ($apiName[0] == "transfer") {
	$result = $api->transfer($username, $type, $amount, $transid);
	// var_dump($result);
	// echo "<br>";
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
	$result = $api->checkTransfer($transid);

	foreach($result as $row);

	echo "此筆交易, 動作: ".$row['type'].", 交易金額: ".$row['amount'];
	// echo "此筆交易: ".json_encode($result);
}
