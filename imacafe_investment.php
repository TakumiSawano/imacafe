<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/function.php';

// セッション開始
session_start();
//ログインしてなければログインページへ
if(!isset($_SESSION['user'])) {
  header("Location: imacafe_login.php");
}
//データベース接続関数の実行
$dbh = get_db_connect();
//データベース読み込み関数を実行して$dataの戻り値を取得
$data = get_table_data($dbh);
//ユーザー名を常に表示
$user_name = select_user_name($dbh);

//もし興味で探すボタンが押されたら
if (isset($_POST['area_find'])) {
  $area_data = get_area_data($dbh);
}

// 自己投資画面ファイル読み込み
include_once './view/imacafe_investment.php';
