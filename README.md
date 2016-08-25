#說明

## URL : https://lab-bob-chen.c9users.io/stage2/week4/NewAPI/index1.php/API名稱?參數=多少
## 示範: https://lab-bob-chen.c9users.io/stage2/week4/NewAPI/index1.php/addUser?username=Bob&key=20160825

##建立帳號API = addUser
#參數
1.帳號(string) username
2.驗證碼(string) key
	key = 台灣當地日期(八位數) ex. 20160825

##取得餘額API = getBalance
#參數
1.帳號(string) username
2.驗證碼(string) key
	key = 台灣當地日期(八位數) ex. 20160825

##轉帳API = transfer
參數#
1.帳號(string) username
2.轉帳型態(string) type (IN,OUT)
3.金額(int) amount
4.序號(int) transid
5.驗證碼(string) key
	key = 台灣當地日期(八位數) ex. 20160825

##轉帳確認API = checkTransfer
#參數
1.序號(int) transid
2.驗證碼(string) key
	key = 台灣當地日期(八位數) ex. 20160825


##題目6.api與文件製作

試著設計以下api與文件

1.建立帳號

2.取得餘額

3.轉帳

4.轉帳確認


