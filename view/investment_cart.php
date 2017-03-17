<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
  <link rel="stylesheet" href="css/recet.css">
  <link rel="stylesheet" href="investment_cart3.css">
</head>
<body>

<div id="header-fixed">
  <div id="header-bk">
    <div id="header">
    <div class="welcome">
    <?php foreach($user_name as $values) { ?>
    <?php echo $values['user_name']."さん。今カフェへようこそ！" ?>
    <?php } ?>
    </div>
    <ul>
    <div class="head">
      <li><a href="imacafe_top.php" class="head_a">Top</a></li>
      <li><a href="imacafe_input.php" class="head_a">Output</a></li>
      <li><a href="imacafe_news.php" class="head_a">Curation</a></li>
      <li><a href="imacafe_investment.php" class="head_a">Self investment</a></li>
      <li><a href="imacafe_mypage.php" class="head_a">My page</a></li>
    </div>
    </ul>
    </div>
  </div>
</div>

<article>
<h1>Self investment</h1>
<img src="img/cart2.png" class="cart">
<div class="error">
<?php foreach($err_msg as $errors) {
  nl2br(h($errors));
} ?>
<?php echo $error; ?>
</div>

<ul class="goods">
<?php
  $sum = 0;
  foreach($goods_data as $values) {
?>
<li class="result_lists">
<form method="post" action="investment_cart.php">
<img src="<?php echo $img_dir . $values['img']; ?>">
<br>
<?php  echo "【".$values['goods_name']."】";  ?><br>
<?php  echo $values['price']."円";  ?>
<?php  $sum += $values['price'];  ?><br>
<input type="hidden" name="id" value="<?php echo $values['goods_id']; ?>">
<input type="submit" name="delete" value="削除">
</form>
</li>
<?php } ?>
</ul>

<div class="clear">
<p class="sum">
合計：<?php echo $sum; ?>円
</p>
<form method="post" action="investment_result.php">
<input type="hidden" name="sum" value="<?php echo $sum; ?>">
<input type="submit" name="buy" value="購入">
</form>
<input type="button" value="前のページへ" onclick="history.back()">
</div>
</article>

</body>
</html>
