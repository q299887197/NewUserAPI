<?php
require_once("PdoConfig.php");


	/*	建立帳號API = addUser
	/	參數
	/		帳號(string) username
	/		密碼(string) password
	/		驗證碼(string) key
	*/

	/*	取得餘額API = getBalance
	/	參數
	/		帳號(string) username
	/		密碼(string) password
	/		驗證碼(string) key
	*/

	/*	轉帳API = transfer
	/	參數
	/		帳號(string) username
	/		密碼(string) password
	/		轉帳型態(string) type (IN,OUT)
	/		金額(int) amount
	/		序號(int) transid
	/		驗證碼(string) key
	*/

	/*	轉帳確認API = checkTransfer
	/	參數
	/		帳號(string) username
	/		密碼(string) password
	/		金額(int) amount
	/		序號(int) transid
	/		驗證碼(string) key
	*/

class Api
{
	public $dbh;

	public function __construct()
    {
        $db_con = new PdoConfig();
        $db = $db_con->db;
        $this->dbh = $db;
    }

	/* 新增帳號 */
	public function addUser($username)
	{
		$db = $this->dbh;
		$insert = $db->prepare("INSERT INTO `userData` (`username`) VALUES (:username)");
	    $insert->bindParam(':username', $username);

	    return $insert->execute();
	}

	/* 查詢餘額 */
	public function getBalance($username)
	{
		$db = $this->dbh;
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
		try{
            $dbh->beginTransaction();

			$balance = $this->getBalance($username);

			 /* 存款 */
		    if ($type == "IN") {
		        $update = $dbh->prepare("UPDATE `userData` SET `balance` = `balance` + :amount
		            WHERE `username`= :username");
		    }

		    /* 取款 */
		    if ($type == "OUT") {
		        if ($balance < $amount) {
		            throw new Exception("餘額不足夠");
		        }

		        $update = $dbh->prepare("UPDATE `userData` SET `balance` = `balance` - :amount
		            WHERE `username`= :username");
		    }

		    $update->bindParam(':amount', $amount, PDO::PARAM_INT);
		    $update->bindParam(':username', $username);
		    $updateResult = $update->execute();

			if (!$updateResult) {
				throw new Exception("轉帳失敗");
			}

			$balance = $this->getBalance($username);
			$data['balance'] = $balance;

			$transidFalse = $this->insertRecord($username, $type, $amount, $transid);

			if ($transidFalse) {
				throw new Exception("序號重複,交易失敗");
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

        $select = $dbh->prepare("SELECT * FROM `userRecord` WHERE `transid` = :transid");
        $select->bindParam(':transid', $transid);
        $select->execute();

        $result = $select->fetch();
        $resultTransid = $result['transid'];

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
	public function checkTransfer($transid)
	{
		$db = $this->dbh;
        $select = $db->prepare("SELECT * FROM `userRecord` WHERE `transid` = :transid");
        $select->bindParam(':transid', $transid);
        $select->execute();

        return $select->fetchAll();
	}





}



