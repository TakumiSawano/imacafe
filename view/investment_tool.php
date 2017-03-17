<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
<style>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  table, tr, th, td {
    border: solid 1px;
    padding: 10px;
    text-align: center;
  }
  img {
    height: 250px;
    width: 200px;
  }
</style>
</head>

<body>
<?php foreach($user_name as $values) { ?>
<?php echo $values['user_name']."さん。今カフェへようこそ！" ?>
<?php } ?>
  <h1>今？カフェで作業中。</h1>
  <h2>商品管理ページ</h2>
  <?php foreach ($err_msg as $error) { ?>
    <p><?php echo h($error); ?></p>
  <?php } ?>
  <h3>新規商品追加</h3>
  <form method="post" enctype="multipart/form-data">
    名前：<input type="text" name="goods_name"><br>
    値段：<input type="text" name="value"><br>
    個数：<input type="text" name="number"><br>
    分類：<select name="area">
      <option value="ビジネス">ビジネス</option>
      <option value="経済">経済</option>
      <option value="政治">政治</option>
      <option value="テクノロジー">テクノロジー</option>
      <option value="プログラミング">プログラミング</option>
      <option value="金融/マーケット">金融/マーケット</option>
      <option value="英語">英語</option>
      <option value="その他">その他</option>
    </select><br>
    商品画像：<input type="file" name="new_img"><br>
    公開ステータス：<select name="status">
    <option value = "1">公開</option>
    <option value = "0">非公開</option>
    </select><br>
    <input type="submit" name="submit" value="商品を追加">
  </form>
  <h3>商品情報変更</h3>
  <p>商品一覧</p>
  <table>
    <tr>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>ステータス</th>
      <th>取り消し</th>
    </tr>
  <?php foreach ($data as $values)  { ?>
    <tr>
      <td><img src="<?php echo $img_dir . $values['img']; ?>"></td>
      <td><?php echo h($values['goods_name']);?></td>
      <td><?php echo h($values['price'])."円";?></td>
      <form method="post"><input type="hidden" name="id" value="<?php echo $values['goods_id']; ?>">
      <td><input type="text" name="number" value="<?php echo $values['stock']; ?>">個 <input type="submit" name="change" value="変更"> </td>
      </form>
      <form method="post"><input type="hidden" name="id" value="<?php echo $values['goods_id']; ?>">
      <td>
        <?php
        if ($values['status'] == '1') {
          echo '公開';
        } else if ($values['status'] == '0') {
          echo '非公開';
        }
        ?>
        <select name="status">
        <option value = "1">公開</option>
        <option value = "0">非公開</option>
        <input type="submit" name="statusChange" value="変更">
      </td>
      </form>
      <td>
      <form method="post"><input type="hidden" name="id" value="<?php echo $values['goods_id']; ?>">
        <input type="submit" name="delete" value="削除">
      </form>
      </td>
    <tr>
  <?php } ?>
  </table>
</body>
</html>
