# 點餐與出餐輔助工具 (Order and Kitchen Tool)

## 特色
- 採用網頁界面, 建議搭配 [Goolge Chrome](http://www.google.com/chrome/) 瀏覽器使用
- 點餐時有參考照片, 圖文對照不易點錯餐
- 各餐點都有口味選擇, 付費加料與相簿功能
- 每張訂單皆有流水號
- 點餐後自動併入廚房顯示系統 (KDS), 廚房出餐有序不掉餐
- 新的訂單自動播放提示音樂, 採mp3格式
- 行動裝置透過無線網路即可點餐, 加快點餐速度
- 自助點餐支援多國語言
- 與原有餐飲POS系統不衝突

## 因為這只是輔助用
- 不能記帳
- 不能交班
- 可以列印出餐單

## 網址
- 後台登入: http://櫃檯IP/okt/back/
- 前台登入: http://櫃檯IP/okt/front/
- 行動前台: http://櫃檯IP/okt/ipod/
- 自助點餐: http://櫃檯IP/okt/takeaway/
- 一桌一機: http://櫃檯IP/okt/here/

## 給架設人員
1. 資料庫
    - 採用文字檔, 免架設資料庫
2. 必裝模組
    - mbstring, exif, gd2, zip
3. 上傳百萬畫素照片
    - memory_limit, post_max_size, upload_max_filesize
4. 前台帳號與密碼
    - __front/front_password.php
5. 後台帳號與密碼
    - __back/back_password.php
6. 底層參數
    - config.php
        - PREFIX_DB_NAME: 資料庫檔名自訂前綴名
        - LOCAL_TIME_ZONE: 本地時區
        - LOCAL_LANGUAGE: 預設語系
