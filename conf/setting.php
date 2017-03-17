<?php
// データベースの接続情報
define('DB_USER',   'root');  // MySQLのユーザ名
define('DB_PASSWD', 'root');    // MySQLのパスワード
define('DNS', 'mysql:dbname=imacafe;host=localhost');  // データベースのDNS情報

define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET',   'UTF8');   // DB文字エンコーディング

date_default_timezone_set('Asia/Tokyo');
$err_msg = [];
$img_dir    = './img/';
