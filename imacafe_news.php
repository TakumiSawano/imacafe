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
//データベース接続
$dbh = get_db_connect();
//ユーザー名を常に表示
$user_name = select_user_name($dbh);

//もし投稿ボタンが押されたら
if (isset($_POST['urlpost'])) {
  //URLの入力チェック
  $url = url_check();
  //お題の入力チェック
  $urltheme = urltheme_check();
  if (isset($_POST['urlpost']) && count($err_msg) === 0) {
    //データベース書き込み
    insert_news_contents($dbh, $urltheme, $url);
  }
}
//データベース読み込み
$news_contents = select_news_contents($dbh);

// 登録画面ファイル読み込み
include_once './view/imacafe_news.php';
