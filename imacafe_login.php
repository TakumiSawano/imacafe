<?php

// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/function.php';

// セッション開始
session_start();
//ログイン済みの場合はリダイレクト
if( isset($_SESSION['user']) != "") {
	// ログイン済みの場合はリダイレクト
	header("Location: imacafe_top.php");
}

// POST送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //ログインボタンが押されたら
  if(isset($_POST['login'])) {
    //入力チェック関数実行
    $email = mail_check();
    $password = password_check();
    //データベース接続
    $dbh = get_db_connect();
    //データベースのメールとパスワードを読み込み、配列として取り出す
    $user_data = select_register_user($dbh, $email);
    /////取り出した$user_dataの配列データを$valuesに格納し、そこから必要なデータのみ抽出
    foreach ($user_data as $values) {
      $db_hashed_pwd = $values['password_number'];
      $user_id = $values['user_id'];
    }
    //ハッシュ化されたパスパスワードが一致するかどうか確認
    if (password_verify($password, $db_hashed_pwd)) {
  		$_SESSION['user'] = $user_id;
  		header("Location: imacafe_top.php");
  		exit;
	} else {
    $error = 'メールアドレス、もしくはパスワードを間違えています';
   }
  }
}

// ログイン画面ファイル読み込み
include_once './view/imacafe_login.php';
