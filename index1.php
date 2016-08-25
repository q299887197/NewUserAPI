<?php
header("content-type: text/html; charset=utf-8");

require_once("Api.php");

$api = new Api();

$url = $_SERVER['REQUEST_URI'];
$url = explode ( ".php/", $url );
$apiName = explode ( "?", $url[1] );
echo $apiName[0] . "<br>";


$username = $_GET['username'];
$amount = $_GET['amount'];
$transid = $_GET['transid'];
$type = $_GET['type'];

	/*	建立帳號API = addUser
	/	參數
	/		帳號(string) username
	/		驗證碼(string) key
	*/

	/*	取得餘額API = getBalance
	/	參數
	/		帳號(string) username
	/		驗證碼(string) key
	*/

	/*	轉帳API = transfer
	/	參數
	/		帳號(string) username
	/		轉帳型態(string) type (IN,OUT)
	/		金額(int) amount
	/		序號(int) transid
	/		驗證碼(string) key
	*/

	/*	轉帳確認API = checkTransfer
	/	參數
	/		帳號(string) username
	/		金額(int) amount
	/		序號(int) transid
	/		驗證碼(string) key
	*/


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

	echo "帳號".$username."目前餘額有".$result."元";
}