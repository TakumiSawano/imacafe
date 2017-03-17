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

if(!isset($_SESSION['user'])) {
  header("Location: imacafe_login.php");
}

// POST送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //商品登録処理
  if(isset($_POST['submit'])) {
    // 画像の保存
    // HTTP POST でファイルがアップロードされたかどうかチェック
    if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {
      // 画像の拡張子を取得
      $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
      // 指定の拡張子であるかどうかチェック
      if ($extension === 'png' || $extension === 'jpeg') {
        // 保存する新しいファイル名の生成（ユニークな値を設定する）
        $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
        // 同名ファイルが存在するかどうかチェック
        if (is_file($img_dir . $new_img_filename) !== TRUE) {
          // アップロードされたファイルを指定ディレクトリに移動して保存
          if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
              $err_msg[] = 'ファイルアップロードに失敗しました';
          }
        } else {
          $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
        }
      } else {
        $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。';
      }
    } else {
      $err_msg[] = 'ファイルを選択してください';
    }
    //テキストボックスの内容のチェック
    //変数の設定（空文字）
    $_POST['goods_name'] = preg_replace('/^[ 　]+/u', '', $_POST['goods_name']);
    $_POST['value'] = preg_replace('/^[ 　]+/u', '', $_POST['value']);
    $_POST['number'] = preg_replace('/^[ 　]+/u', '', $_POST['number']);

    //商品名の入力チェック関数の実行
    $goods_name = goods_name_check();

    //$valueの条件分岐関数の実行
    $value = value_check();

    //$numberの条件分岐
    $number = number_check();

    //ステータスの条件分岐
    $status = status_check();

    //エラーなければ完了メッセージを表示
    if (count($err_msg) === 0) {
      echo '商品の登録を完了しました';
    }
    //変更ボタンが押されたら
  } else if (isset($_POST['change']))  {
    //変数の設定
    $_POST['id'] = preg_replace('/^[ 　]+/u', '', $_POST['id']);
    $_POST['number'] = preg_replace('/^[ 　]+/u', '', $_POST['number']);

    //商品idチェック
    $goods_id = id_check();

    //在庫数チェック
    $number = stock_check();

    //エラーなければ完了メッセージを表示
    if (count($err_msg) === 0) {
      echo '在庫数の変更を完了しました';
    }
    //ステータスの変更ボタンが押されたら
  } else if (isset($_POST['statusChange'])) {
    //商品idチェック
    $goods_id = id_check();
    //ステータスの条件分岐
    $status = status_check();
    //エラーなければ完了メッセージを表示
    if (count($err_msg) === 0) {
      echo '公開ステータスの変更を完了しました';
    }
  } else if (isset($_POST['delete'])) {
    //商品idチェック
    $goods_id = id_check();
    //エラーなければ完了メッセージを表示
    if (count($err_msg) === 0) {
      echo '商品データを削除しました。';
    }

  }
}

// アップロードした新しい画像ファイル名の登録、既存の画像ファイル名の取得
//データベース接続
$dbh = get_db_connect();
//ユーザー名を常に表示
$user_name = select_user_name($dbh);
// エラーがなければ、アップロードした新しい画像ファイル名、商品名、値段、日時を保存
if (count($err_msg) === 0 && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  //商品登録ボタンが押された時
  if(isset($_POST['submit'])) {
    //トランザクション処理の関数を実行
    insert_goods_master_stock($dbh, $goods_name, $value, $new_img_filename, $status, $number);
  //変更ボタンが押された時
} else if (isset($_POST['change'])) {
  //公開ステータスをアップデートする関数
  update_table_stock($dbh, $number, $goods_id);
  // ステータスの変更ボタンが押された時
} else if (isset($_POST['statusChange'])) {
  update_goods_master($dbh, $status, $goods_id);
} else if (isset($_POST['delete'])) {
  // 管理ツールから商品を削除
  delete_master($dbh, $goods_id);
}
}

//drink_masterとdrink_stockのテーブルを結合して読み込み
$data = select_master_stock($dbh);

// ログイン画面ファイル読み込み
include_once './view/investment_tool.php';
