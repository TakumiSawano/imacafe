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
//データベースに接続
$dbh = get_db_connect();
//ユーザー名を常に表示
$user_name = select_user_name($dbh);

// POST送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //Outputボタンが押されたら
  if (isset($_POST['output'])) {
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
    }
    //テーマの入力チェック
    $theme = theme_check();
    //投稿の入力チェック
    $textbox = textbox_check();

  }
  if (isset($_POST['output']) && count($err_msg) === 0) {
    //テーブルpost_contentsに書きこみ
    insert_post_contents($dbh, $theme, $textbox, $new_img_filename);
  }
}

//データベースの中身を変数に格納
$contents = select_contents($dbh);

// インプット画面ファイル読み込み
include_once './view/imacafe_input.php';
