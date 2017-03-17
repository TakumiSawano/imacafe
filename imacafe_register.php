<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/function.php';

//セッション開始
session_start();
//ログイン済みの場合はリダイレクト
if( isset($_SESSION['user']) != "") {
	// ログイン済みの場合はリダイレクト
	header("Location: imacafe_top.php");
}


// POST送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //登録ボタンが押された場合
  if (isset($_POST['signup'])){
    //ニックネームのチェック
    $user_name = user_name_check();
    //メールアドレスのチェック
    $email = mail_check();
    //パスワードのチェック
    $password = password_check();
    //パスワードをハッシュ化
    $password = password_hash($password, PASSWORD_BCRYPT);
    //エラーがなければ
    if (empty($err_msg)) {
      //データベースへ接続
      $dbh = get_db_connect();
      //テーブルregister_userへ書き込み
      insert_register_user($dbh,$user_name,$email,$password);
      //登録完了（トップページへ）
      header("Location: imacafe_top.php");
    }
  }
}

// 登録画面ファイル読み込み
include_once './view/imacafe_register.php';
