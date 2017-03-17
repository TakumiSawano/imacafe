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

//もしカートに入れるボタンが押されたら
if(isset($_POST['cart'])) {
  //goods_idチェック
  $goods_id = id_check();
  //user_cartテーブルの中からuse_idがログイン者と、なおかつgoods_idが選択された商品と一致するのもを取り出す
  $user_cart = select_user_cart($dbh, $goods_id);
  //上記で取り出した列が存在する場合、ログイン者が既にカートに入れていると言うことなのでエラーを表示
  if (count($user_cart) > 0) {
    $error = 'その商品は既に選択されています。';
  } else {
    insert_goods_cart($dbh, $goods_id);
  }
}
//もし削除ボタンが押されたら
else if (isset($_POST['delete'])) {
  $goods_id = id_check();
  delete_cart($dbh, $goods_id);
}

if(count($err_msg) === 0){
//読み込んで、変数に格納
$goods_data = select_goods_cart($dbh);
}

// ログイン画面ファイル読み込み
include_once './view/investment_cart.php';
