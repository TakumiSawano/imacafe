<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/function.php';

// セッション開始
session_start();

//データベース接続
$dbh = get_db_connect();
//ユーザー名を常に表示
$user_name = select_user_name($dbh);



// 登録画面ファイル読み込み
include_once './view/policy.php';
