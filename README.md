#說明

##建立帳號API = addUser
#參數
1.帳號(string) username
2.驗證碼(string) key


##取得餘額API = getBalance
#參數
1.帳號(string) username
2.驗證碼(string) key


##轉帳API = transfer
參數#
1.帳號(string) username
2.轉帳型態(string) type (IN,OUT)
3.金額(int) amount
4.序號(int) transid
5.驗證碼(string) key


##轉帳確認API = checkTransfer
#參數
1.帳號(string) username
2.金額(int) amount
3.序號(int) transid
4.驗證碼(string) key



##題目6.api與文件製作

試著設計以下api與文件

1.建立帳號

2.取得餘額

3.轉帳

4.轉帳確認


