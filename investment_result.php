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
//二つのテーブルを結合し、読み込む関数
$buyData = get_table_buyData($dbh);
//ユーザー名を常に表示
$user_name = select_user_name($dbh);

//購入ボタンが押されたら
if (isset($_POST['buy'])) {
  //上で抽出したデータを$valuesに格納し、配列として取り出す
  foreach ($buyData as $values) {
    //在庫数が0より大きい&&statusが1（公開）ならば
    if ($values['stock'] >0 && $values['status'] == 1) {
      // 変数に代入
      $doneBuy = '購入完了しました';
      $goods_name = $values['goods_name'];
      $img = $img_dir . $values['img'];
      // 在庫数を1減らす
      $remainStock = $values['stock'] - 1;
      //drink_stockの在庫数を上書きする関数実行
      update_table_stock($dbh, $remainStock, $values);
      //カートをクリア
      clear_cart($dbh);
    } else {
      $err_msg[] = '申し訳ございません。売り切れか、現在取り扱いのない商品です。';
    }
  }
}

// ログイン画面ファイル読み込み
include_once './view/investment_result.php';
