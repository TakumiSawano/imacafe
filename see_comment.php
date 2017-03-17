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

//もしコメントボタンが押されれば
if (isset($_POST['post_comment'])) {
  //コメントの入力チェック
  $comment = comment_check();
  if (count($err_msg) === 0) {
  //データベース書き込み
  insert_post_comment($dbh,$comment);
  }
}
//データベース読み込み
$news_contents = select_news_contents($dbh);

//データベース読み込み
$post_comment = select_post_comment($dbh);

// 登録画面ファイル読み込み
include_once './view/see_comment.php';
