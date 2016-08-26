<?php
require_once("PdoConfig.php");

class Api
{
	public $dbh;

	public function __construct()
    {
        $db_con = new PdoConfig();
        $db = $db_con->db;
        $this->dbh = $db;
    }

    /* 查詢帳號 */
	public function selectUser($username)
	{
		$db = $this->dbh;
		$select = $db->prepare("SELECT `username` FROM `userData` WHERE `username` = :username");
		$select->bindParam(':username', $username);
		$select->execute();
		$result = $select->fetch();
        $resultUserName = $result['username'];

        return $resultUserName;
	}

	/* 新增帳號 */
	public function addUser($username)
	{
		$db = $this->dbh;

		$resultUserName = selectUser($username);

        if ($resultUserName == $username) {
        	return false;
        }

		$insert = $db->prepare("INSERT INTO `userData` (`username`) VALUES (:username)");
	    $insert->bindParam(':username', $username);

	    return $insert->execute();
	}

	/* 查詢餘額 */
	public function getBalance($username)
	{
		$db = $this->dbh;

		$resultUserName = selectUser($username);

		if ($resultUserName != $username) {
        	return false;
        }

        $select = $db->prepare("SELECT * FROM `userData` WHERE `username` = :username");
        $select->bindParam(':username', $username);
        $select->execute();
        $data = $select->fetch();
        $balance = $data['balance'];

        return $balance;
	}

	/* 轉帳API */
	public function transfer($username, $type, $amount, $transid)
	{
		$dbh = $this->dbh;

		$resultUserName = selectUser($username);

		if ($resultUserName != $username) {
        	return "Repeat";
        }

		try{
            $dbh->beginTransaction();

			//當前餘額
			$balance = $this->getBalance($username);

			 /* 存款 */
		    if ($type == "IN") {
		        $update = $dbh->prepare("UPDATE `userData` SET `balance` = `balance` + :amount
		            WHERE `username`= :username");
		    }

		    /* 取款 */
		    if ($type == "OUT") {
		        if ($balance < $amount) {
		            throw new Exception("Insufficient balance"); //餘額不足
		        }

		        $update = $dbh->prepare("UPDATE `userData` SET `balance` = `balance` - :amount
		            WHERE `username`= :username");
		    }

		    $update->bindParam(':amount', $amount, PDO::PARAM_INT);
		    $update->bindParam(':username', $username);
		    $updateResult = $update->execute();

			if (!$updateResult) {
				throw new Exception("Transfer Fail"); //轉帳失敗
			}

			//查詢最新餘額
			$balance = $this->getBalance($username);
			$data['balance'] = $balance;

			//新增明細
			$transidFalse = $this->insertRecord($username, $type, $amount, $transid);

			if ($transidFalse) {
				throw new Exception("Repeat Transfer, Transfer Fail"); //重複序號, 交易失敗
			}

			$data['result'] = true;

			$dbh->commit();


		} catch (Exception $err) {
		    $dbh->rollBack();
		    $data['msg'] = $err->getMessage();
		}

		$dbh = null;

		return $data;
	}

	/* 新增明細 */
    public function insertRecord($username, $type, $amount, $transid)
    {
        $dbh = $this->dbh ;

        $select = $dbh->prepare("SELECT `transid` FROM `userRecord` WHERE `transid` = :transid");
        $select->bindParam(':transid', $transid);
        $select->execute();

        $result = $select->fetch();
        $resultTransid = $result['transid'];

		//查詢編號是否重複
		if ($transid == $resultTransid) {
			return true;
		}

        $insert = $dbh->prepare("INSERT INTO `userRecord` (`username`, `type`, `amount`, `transid`)".
            "VALUES (:username, :type, :amount, :transid)");
        $insert->bindParam(':username', $username);
        $insert->bindParam(':type', $type);
        $insert->bindParam(':amount', $amount);
        $insert->bindParam(':transid', $transid);
		$insert->execute();
    }

	/* 查詢轉帳 */
	public function checkTransfer($username, $transid)
	{
		$db = $this->dbh;

        $select = $db->prepare("SELECT * FROM `userRecord` WHERE `transid` = :transid");
        $select->bindParam(':transid', $transid);
        $select->execute();

        return $select->fetchAll();
	}
}
