<?php
//特殊文字の変換
//特殊文字の変換関数
function h($str){
 return  htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
//データベースに接続する関数
function get_db_connect() {

  try {
    // データベースに接続
    $dbh = new PDO(DNS, DB_USER, DB_PASSWD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();
  }

  return $dbh;
}

//全てのページに表示するユーザー名
function select_user_name($dbh) {
  global $err_msg;
  $user_name = [];
  try {
    $sql = 'SELECT *
            FROM register_user
            WHERE user_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $user_name[] = $row;
    }
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $user_name;
}






//register.php
//ニックネームのチェック
function user_name_check() {
  global $err_msg;
  //ニックネームのチェック
  $_POST['user_name'] = preg_replace('/^[ 　]+/u', '', $_POST['user_name']);
  if (isset($_POST['user_name']) === FALSE || $_POST['user_name'] === '') {
    $err_msg[] = "ニックネームを入力してください\n";
  } else {
    $user_name = $_POST['user_name'];
  }

  return $user_name;
}
//メールアドレスチェックの正規表現
function mail_check() {
  global $err_msg;
  if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
          $email = $_POST['email'];
      } else {
          $err_msg[] = "メールアドレスを正しく入力してください\n";
      }
    return $email;
}
//パスワードチェック
function password_check() {
  global $err_msg;
  if (preg_match("/\A[a-z\d]{4,8}+\z/i", $_POST['password'])) {
          $password = $_POST['password'];
      } else {
          $err_msg[] = 'パスワードは4文字以上8文字以内の英数字で入力してください';
      }
      return $password;
}
//テーブルregister_userへ登録
function insert_register_user($dbh,$user_name,$email,$password) {
  try {
    $sql = 'INSERT INTO register_user(user_name, mail_address, password_number, create_datetime)
            VALUES (?, ?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $user_name,    PDO::PARAM_STR);
    $stmt->bindValue(2, $email,    PDO::PARAM_STR);
    $stmt->bindValue(3, $password,    PDO::PARAM_STR);
    $stmt->bindValue(4, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}



//login.php
//データベースのメールとパスワードを読み込み、配列として取り出す
function select_register_user($dbh, $email) {
  global $err_msg;
  $user_data = [];
  try {
    $sql = 'SELECT *
            FROM register_user
            WHERE mail_address = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $email,    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $user_data[] = $row;
    }
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $user_data;
}




//imacafe_input.php
//テーブルpost_contentsに書きこみ
function insert_post_contents($dbh, $theme, $textbox, $new_img_filename) {
  global $err_msg;
  try {
    date_default_timezone_set('Asia/Tokyo');
    $sql = 'INSERT INTO post_contents(user_id, theme,textbox, img, create_datetime)
            VALUES (?, ?, ?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $theme,    PDO::PARAM_STR);
    $stmt->bindValue(3, $textbox,    PDO::PARAM_STR);
    $stmt->bindValue(4, $new_img_filename,    PDO::PARAM_STR);
    $stmt->bindValue(5, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}
//テーマの入力チェック
function theme_check() {
  global $err_msg;
  //ニックネームのチェック
  $_POST['theme'] = preg_replace('/^[ 　]+/u', '', $_POST['theme']);
  if (isset($_POST['theme']) === FALSE || $_POST['theme'] === '') {
    $err_msg[] = "本のタイトルを入力してください\n";
  } else {
    $theme = $_POST['theme'];
  }

  return $theme;
}
//投稿の入力チェック
function textbox_check() {
  global $err_msg;
  //ニックネームのチェック
  $_POST['textbox'] = preg_replace('/^[ 　]+/u', '', $_POST['textbox']);
  if (isset($_POST['textbox']) === FALSE || $_POST['textbox'] === '') {
    $err_msg[] = "アウトプットを入力してください";
  } else {
    $textbox = $_POST['textbox'];
  }

  return $textbox;
}
//テーブルpost_contentsとテーブルregister_userを結合して読み込み、表示
function select_contents($dbh) {
  $contents = [];
  global $err_msg;
  try {
    //内部結合して、ログインした人と投稿した同じ人の名前を表示
    $sql = 'SELECT *  FROM register_user
            INNER JOIN post_contents
            ON post_contents.user_id = register_user.user_id
            ORDER BY post_contents.create_datetime DESC';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $contents[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $contents;
}






//imacafe_investment.php
//二つのテーブルを結合し、読み込む関数
function get_table_data($dbh) {
  $data = [];
  $err_msg    = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM goods_master
            INNER JOIN goods_stock
            ON goods_master.goods_id = goods_stock.goods_id
            WHERE status=1';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();

    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $data[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $data;
}

//分野別
function get_area_data($dbh) {
  $area_data = [];
  $err_msg    = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM goods_master
            INNER JOIN goods_stock
            ON goods_master.goods_id = goods_stock.goods_id
            WHERE status=1 AND area=?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_POST['area'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();

    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $area_data[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $area_data;
}




//investment_result.php
//二つのテーブルを結合し、読み込む関数
function get_table_buyData($dbh) {
  $buyData = [];
  $err_msg    = [];
  global $err_msg;
  try {
    //内部結合して、POSTされたdrink_idと同じものを抽出
    $sql = 'SELECT *  FROM goods_cart
            LEFT JOIN goods_master
            ON goods_cart.goods_id = goods_master.goods_id
            LEFT JOIN goods_stock
            ON goods_master.goods_id = goods_stock.goods_id
            WHERE user_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $rows;
}

//drink_historyに書き込む関数
function insert_table_history($dbh, $values) {
  try {
    date_default_timezone_set('Asia/Tokyo');
    // SQL文を作成
    //drink_historyに書き込み
    $sql = 'INSERT INTO drink_history(drink_id, create_datetime)
            VALUES (?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $values['drink_id'],    PDO::PARAM_STR);
    $stmt->bindValue(2, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}

//drink_stockの在庫数を上書きする関数
function update_table_stock($dbh, $remainStock, $values) {
  $err_msg    = [];
  global $err_msg;
  try{
    date_default_timezone_set('Asia/Tokyo');
    //drink_stockの在庫数を上書き
    $sql = 'UPDATE goods_stock
            SET stock = ?,
                update_datetime = ?
            WHERE goods_id = ?';;
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $remainStock,    PDO::PARAM_STR);
    $stmt->bindValue(2, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    $stmt->bindValue(3, $values['goods_id'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}



//investment_tool.php
//商品名の入力チェック関数
function goods_name_check() {
  $err_msg    = [];
  global $err_msg;
  $_POST['goods_name'] = preg_replace('/^[ 　]+/u', '', $_POST['goods_name']);
  if (isset($_POST['goods_name']) === FALSE || $_POST['goods_name'] === "") {
    $err_msg[] = '商品名を入力してください';
  }  else {
    $goods_name = $_POST['goods_name'];
  }
  return $goods_name;
}

//$valueの条件分岐
function value_check() {
  $err_msg    = [];
  global $err_msg;
  $_POST['value'] = preg_replace('/^[ 　]+/u', '', $_POST['value']);
  if (isset($_POST['value']) === FALSE || $_POST['value'] === "") {
    $err_msg[] = '値段を入力してください';
  }  else {
    $value = $_POST['value'];
  }
  return $value;
}

//$numberの条件分岐
function number_check() {
  $err_msg    = [];
  global $err_msg;
  $_POST['number'] = preg_replace('/^[ 　]+/u', '', $_POST['number']);
  if (isset($_POST['number']) === FALSE || $_POST['number'] === "") {
    $err_msg[] = '個数を入力してください';
  }  else {
    $number = $_POST['number'];
  }
  return $number;
}

//ステータスの条件分岐
function status_check() {
  if ($_POST['status'] == '1') {
    $status = '1';
  } else if ($_POST['status'] == '0') {
    $status = '0';
  }
  return $status;
}

//商品IDの条件分岐
function id_check() {
  $err_msg    = [];
  global $err_msg;
  $_POST['id'] = preg_replace('/^[ 　]+/u', '', $_POST['id']);
  if (isset($_POST['id']) === FALSE || $_POST['id'] === "") {
    $err_msg[] = '商品IDが指定されていません';
  }  else {
    $goods_id = $_POST['id'];
  }
  return $goods_id;
}

//在庫数の条件分岐
function stock_check() {
  $err_msg    = [];
  global $err_msg;
  $_POST['number'] = preg_replace('/^[ 　]+/u', '', $_POST['number']);
  if (isset($_POST['number']) === FALSE || $_POST['number'] === "") {
    $err_msg[] = '在庫数が入力されていません';
     //入力された数字が半角で正の整数ならば
  }  else if (preg_match("/^[0-9]+$/", $_POST['number'])) {
    $number = $_POST['number'];
  } else {
    $err_msg[] ='在庫数は半角、正の整数で入力してください';
  }
  return $number;
}

//次はデータベースの関数から
//二つのテーブルへの処理をするトランザクション関数
function insert_goods_master_stock($dbh, $goods_name, $value, $new_img_filename, $status, $number) {
  // トランザクション開始
  $dbh->beginTransaction();
  try {
    date_default_timezone_set('Asia/Tokyo');
    // drink_masterテーブルのSQL文を作成
    $sql = 'INSERT INTO goods_master(area, goods_name, price, img, status, create_datetime, update_datetime)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_POST['area'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $goods_name,    PDO::PARAM_STR);
    $stmt->bindValue(3, $value,    PDO::PARAM_STR);
    $stmt->bindValue(4, $new_img_filename,    PDO::PARAM_STR);
    $stmt->bindValue(5, $status,    PDO::PARAM_STR);
    $stmt->bindValue(6, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    $stmt->bindValue(7, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
     // SQLを実行
    $stmt->execute();

    // drink_stockテーブルのSQL文を作成
    $sql = 'INSERT INTO goods_stock(stock, create_datetime, update_datetime)
            VALUES (?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $number,    PDO::PARAM_STR);
    $stmt->bindValue(2, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    $stmt->bindValue(3, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    $dbh->commit();
  }
  catch (PDOException $e) {
    // ロールバック処理
    $dbh->rollback();
    // 例外をスロー
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}

// ステータスの変更ボタンが押された時に
// 公開ステータスをアップデートする関数
function update_goods_master($dbh, $status, $goods_id) {
  try {
    date_default_timezone_set('Asia/Tokyo');
    //公開ステータス変更のSQL
    $sql = 'UPDATE goods_master
            SET status = ?,
                update_datetime = ?
            WHERE goods_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $status,    PDO::PARAM_STR);
    $stmt->bindValue(2, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    $stmt->bindValue(3, $goods_id,    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}

//drink_masterとdrink_stockを結合して読み込み
function select_master_stock($dbh) {
  $data       = [];
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM goods_master
            INNER JOIN goods_stock
            ON goods_master.goods_id = goods_stock.goods_id';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $data[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $data;
}

//管理画面から商品を削除する
function delete_master($dbh, $goods_id) {
  try {
    //公開ステータス変更のSQL
    $sql = 'DELETE from  goods_master
            where goods_id = ?;';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $goods_id,    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}








//////investment_cart.php
//テーブルgoods_cartに書きこみ
function insert_goods_cart($dbh, $goods_id) {
  global $err_msg;
  try {
    date_default_timezone_set('Asia/Tokyo');
    $sql = 'INSERT INTO goods_cart(user_id, goods_id, create_datetime, update_datetime)
            VALUES (?, ?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $goods_id,    PDO::PARAM_STR);
    $stmt->bindValue(3, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    $stmt->bindValue(4, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}
//テーブルgoods_cart読み込んで、変数に格納
function select_goods_cart($dbh) {
  $goods_data = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM goods_cart
            INNER JOIN goods_master
            ON goods_cart.goods_id = goods_master.goods_id
            WHERE user_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $goods_data[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $goods_data;

}


//カートテーブルを削除
function delete_cart($dbh, $goods_id) {
  try {
    //公開ステータス変更のSQL
    $sql = 'DELETE from  goods_cart where goods_id = ? AND user_id = ?;';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $goods_id,    PDO::PARAM_STR);
    $stmt->bindValue(2, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}
//利用ユーザーidのテーブルgoods_cartを読み込んで、
function select_user_cart($dbh, $goods_id) {
  $user_cart = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM goods_cart
            WHERE user_id = ? AND goods_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $goods_id,    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $user_cart[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $user_cart;
}

//購入後にカートテーブルを上書き
function clear_cart($dbh) {
  try {
    //公開ステータス変更のSQL
    $sql = 'DELETE from  goods_cart where user_id = ?;';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}







//////ニュース投稿掲示板
//記事テーマの入力チェック
function urltheme_check() {
  global $err_msg;
  //ニックネームのチェック
  $_POST['urltheme'] = preg_replace('/^[ 　]+/u', '', $_POST['urltheme']);
  if (isset($_POST['urltheme']) === FALSE || $_POST['urltheme'] === '') {
    $err_msg[] = "記事の要約を入力してください\n";
  } else {
    $urltheme = $_POST['urltheme'];
  }
return $urltheme;
}

//URLの入力チェック
function url_check() {
  global $err_msg;
  //URLのチェック
  //$checkurl = preg_match('/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/u', $_POST['url']);
  //if ($checkurl !== TRUE) {
  //  $err_msg[] = "URLを正しく貼り付けてください\n";
  //} else {
  //  $url = $_POST['url'];
  //}
  $_POST['url'] = preg_replace('/^[ 　]+/u', '', $_POST['url']);
  if (isset($_POST['url']) === FALSE || $_POST['url'] === '') {
    $err_msg[] = "記事のURLを貼ってください\n";
  } else {
    $url = $_POST['url'];
  }
return $url;
}

//リンク先のタイトルを取得する関数
function getPageTitle( $url ) {
    $html = file_get_contents($url); //(1)
    $html = mb_convert_encoding($html, mb_internal_encoding(), "auto" ); //(2)
    if ( preg_match( "/<title>(.*?)<\/title>/i", $html, $matches) ) { //(3)
        return $matches[1];
    } else {
        return false;
    }
}



//ニュース投稿をデータベースに格納
function insert_news_contents($dbh, $urltheme, $url) {
  global $err_msg;
  try {
    date_default_timezone_set('Asia/Tokyo');
    $sql = 'INSERT INTO news_contents(user_id, theme, url, create_datetime)
            VALUES (?, ?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $urltheme,    PDO::PARAM_STR);
    $stmt->bindValue(3, $url,    PDO::PARAM_STR);
    $stmt->bindValue(4, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}

//ニュース投稿をデータベースから読み込んで表示
function select_news_contents($dbh) {
  $news_contents = [];
  global $err_msg;
  try {
    //内部結合して、ログインした人と投稿した同じ人の名前を表示
    $sql = 'SELECT *  FROM register_user
            INNER JOIN news_contents
            ON news_contents.user_id = register_user.user_id
            ORDER BY news_contents.create_datetime DESC';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド

    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $news_contents[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $news_contents;
}

//コメントの入力チェック
//投稿の入力チェック
function comment_check() {
  global $err_msg;
  //ニックネームのチェック
  $_POST['comment'] = preg_replace('/^[ 　]+/u', '', $_POST['comment']);
  if (isset($_POST['comment']) === FALSE || $_POST['comment'] === '') {
    $err_msg[] = "コメントを入力してください";
  } else {
    $comment = $_POST['comment'];
  }

  return $comment;
}

//データベースpost_commentに書き込み
function insert_post_comment($dbh,$comment) {
  global $err_msg;
  try {
    date_default_timezone_set('Asia/Tokyo');
    $sql = 'INSERT INTO post_comment(user_id, post_id, comment, create_datetime)
            VALUES (?, ?, ?, ?)';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $_POST['id'],    PDO::PARAM_STR);
    $stmt->bindValue(3, $comment,    PDO::PARAM_STR);
    $stmt->bindValue(4, date('Y-m-d H:i:s'),    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
  } catch(PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
}
//テーブルpost_contentsとテーブルregister_userを結合して読み込み、表示
function select_post_comment($dbh) {
  $post_comment = [];
  global $err_msg;
  try {
    //内部結合して、ログインした人と投稿した同じ人の名前を表示
    $sql = 'SELECT post_comment.post_id, register_user.user_name, post_comment.create_datetime, post_comment.comment
            FROM news_contents
            INNER JOIN post_comment
            ON news_contents.post_id = post_comment.post_id
            INNER JOIN register_user
            ON post_comment.user_id = register_user.user_id
            WHERE post_comment.post_id = ?
            ORDER BY post_comment.create_datetime DESC';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_POST['id'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $post_comment[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $post_comment;
}






//////imacafe_mypage.php

//自分のoutputをデータベースから読み込んで変数に格納
function my_contents($dbh) {
  $my_contents = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM register_user
            INNER JOIN post_contents
            ON post_contents.user_id = register_user.user_id
            WHERE post_contents.user_id = ?
            ORDER BY post_contents.create_datetime DESC';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $my_contents[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $my_contents;
}

//自分のCurationをデータベースから読み込んで変数に格納
function my_curation($dbh) {
  $my_curation = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT *  FROM register_user
            INNER JOIN news_contents
            ON news_contents.user_id = register_user.user_id
            WHERE news_contents.user_id = ?
            ORDER BY news_contents.create_datetime DESC';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $my_curation[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $my_curation;
}

//自分のキュレーションに書かれたコメントを表示
function my_curation_comment($dbh) {
  $my_curation_comment = [];
  global $err_msg;
  try {
    // SQL文を作成
    //内部結合
    $sql = 'SELECT * FROM news_contents
            INNER JOIN post_comment ON post_comment.user_id = news_contents.user_id AND post_comment.post_id = news_contents.post_id
            WHERE news_contents.user_id = ? AND post_comment.post_id = ?
            ORDER BY post_comment.create_datetime DESC';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $_SESSION['user'],    PDO::PARAM_STR);
    $stmt->bindValue(2, $_POST['id'],    PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    // 1行ずつ結果を配列で取得
    foreach ($rows as $row) {
      $my_curation_comment[] = $row;
    }
  } catch (PDOException $e) {
    $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
  }
  return $my_curation_comment;
}
