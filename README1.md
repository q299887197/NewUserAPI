# rd3

##題目1 踩地雷地圖產生程式
試著製作一個10X10的地圖產生程式，並**`隨機`**產生40個地雷。

地雷的周圍會有數字，數字代表數字周圍八格有幾顆地雷。

###輸出格式
請以字串格式輸出，M代表地雷，0代表空格，1~8代表地雷數量，N代表換行。

###範例
地圖示意圖

| 1 | 1 | 1 |   |   |   |   |
|---|---|---|---|---|---|---|
| 1 | M | 2 | 1 | 1 |   |   |
| 1 | 1 | 2 | M | 1 |   |   |
|   |   | 1 | 2 | 3 | 2 | 1 |
| 1 | 1 |   | 1 | M | M | 1 |
| M | 1 |   | 1 | 2 | 2 | 1 |

輸出範例

`1110000N1M21100N112M100N0012321N1101MM1NM101221`

###作答網址

https://docs.google.com/forms/d/e/1FAIpQLSc-kIjda8MWgGEmH6XLVKXUOdksMNx4JPrrTuCyASlnfwPcNg/viewform

###已通過名單

https://docs.google.com/document/d/1jQ2cwjREPU_INb0Dz1m2l37gep-Curq8C7dXLTAuyIo/edit

###進階題

試著製作一個60X50的地圖產生程式，並**`隨機`**產生1200個地雷，並且每次產生可以在一秒內產生完。

###作答網址

https://docs.google.com/forms/d/1-MNJ9Y7WmW5oW0_NFXTXbgsJx52n9maYfqdAWc_j2Q8/edit

###已通過名單

https://docs.google.com/document/d/1jQ2cwjREPU_INb0Dz1m2l37gep-Curq8C7dXLTAuyIo/edit

##題目2 踩地雷地圖反驗證程式
沿用第一題定義的參數和格式，解析帶入的字串，是否符合踩地雷的規則，若不符則要詳細說明原因。

###範例
輸入範例

`https://xxx.xxx.xxx/xxx.php?map=1110000N1M21100N112M100N0012321N1101MM1NM101221`

輸出格式

符合。

不符合，因為XXOO。

###作答網址

https://docs.google.com/forms/d/1Hi4nHTfkwz77U05L7UOWiVvzwX8B_jXcQKW0N-8Fd_0/edit



##題目3.轉帳流程圖
繪製轉帳流程圖，試想你可能在轉帳過程中會面臨的各種狀況；繳交兩張流程圖。

###情境
A平台(你)，使用B平台(其他人)出入款API，讓會員可以將他在B平台的錢轉入A平台的電子荷包，當然也可以從A平台轉入到B平台。

註.角色定位以A平台為角度去思考

註2.你是A平台的工程師

ex.

1.A平台的會員phili想要把100元轉到B平台

2.A平台的會員phili想要把在B平台的100元轉回來

###狀況
網路延遲，timeout

###繳交
繳交網址 - http://192.168.152.134/upload.php

檔名格式 - 暱稱.jpg (jpeg,jpg) (ex. phili.jpg)


##題目4.製作遊戲平台


##項目1
1.建立帳號

2.執行登入

3.存入額度

4.進入遊戲(機率遊戲任何一款)

##完成
https://docs.google.com/spreadsheets/d/1GPgdwF-bsSZEc-XFP4gNVJZqWrOzYppXE1gIrkBImSg/edit?usp=sharing


##題目5.轉帳額度檢查
沿用題目3思維，試著使用下列API，找出額度不符合的狀況

###繳交
https://goo.gl/forms/rQfUhBy9H1SdhTdx2

####內容格式
帳號 - XXX

動做 - 從哪轉到哪

轉帳序號 - XXX

金額 - XXX

發生狀況 - XXX

結果 - XXX

註.A平台與B平台的轉帳API，兩個回應都"確定"是真的成功的情況，可以不用列出

###呼叫API規則
1.一入一出，或一出一入

(A扣款B入款、A入款B扣款、B扣款A入款、B入款A扣款)

2.curl使用上請設置 timeout 10秒

3.一個流程所使用的轉帳序號需一樣

4.禁止任何for迴圈行為，違者.....

###要點
1.適時的做log紀錄，或出入款記錄


##api
url - http://bm-dev.vir888.net/app/presenter.php/api名稱?參數=值

ex. 
request - http://bm-dev.vir888.net/app/presenter.php/getBalance?username=phili

reponse - {"result":true,"data":{"Balance":"97630.0000"}}

##共用
1.新增帳號

api名稱 - addUser

參數1 - username(帳號)

2.重置帳號資料

api名稱 - resetData

參數1 - username(帳號)

###A平台
1.取得餘額

api名稱 - getBalance

參數1 - (string)username(帳號)

2.轉帳

api名稱 - updateBalance

參數1 - (string)username(帳號)

參數2 - (int)transid(轉帳序號)

參數3 - (string)type(轉帳型態) (IN,OUT)

參數4 - (int)amount(轉帳金額)

###B平台
1.取得餘額

api名稱 - getUserBalance

參數1 - (string)username(帳號)

2.轉帳

api名稱 - transfer

參數1 - (string)username(帳號)

參數2 - (int)transid(轉帳序號)

參數3 - (string)type(轉帳型態) (IN,OUT)

參數4 - (int)amount(轉帳金額)

3.檢查轉帳狀態

api名稱 - checkTransfer

參數1 - (string)username(帳號)

參數2 - (int)transid(轉帳序號)


##題目6.api與文件製作

試著設計以下api與文件

1.建立帳號

2.取得餘額

3.轉帳

4.轉帳確認
