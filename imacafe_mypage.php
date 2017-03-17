<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/function.php';

// セッション開始
session_start();
//もしログインしていなければログインページへ
if(!isset($_SESSION['user'])) {
  header("Location: imacafe_login.php");
}

//データベース接続
$dbh = get_db_connect();
//自分のoutputをデータベースから読み込んで変数に格納
$my_contents = my_contents($dbh);
//自分のCurationをデータベースから読み込んで変数に格納
$my_curation = my_curation($dbh);
//ユーザー名を常に表示
$user_name = select_user_name($dbh);

//自分のキューレーションに書き込まれたコメントを変数に格納
$my_curation_comment = my_curation_comment($dbh);
// ログイン画面ファイル読み込み
include_once './view/imacafe_mypage.php';
