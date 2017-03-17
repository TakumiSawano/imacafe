<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>結果ページ</title>
    <link rel="stylesheet" href="css/recet.css">
    <link rel="stylesheet" href="result.css">
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
<?php if($_POST['sum'] > 0)  { ?>
<p>ご購入ありがとうございました。</p>
<?php } else { ?>
<p>商品がカートに入っていません。</p>
<?php } ?>
<!-- エラーを配列から取り出して表示 -->
<?php foreach ($err_msg as $error) { ?>
<?php print $error; ?>
<?php } ?>
<!-- 結果を表示 -->
<ul class="goods">
<?php
$sum = 0;
foreach ($buyData as $values){
?>
<li class="result_lists">
<img src="<?php echo $img_dir.$values['img']; ?>"><br>
<?php echo $values['goods_name']; ?><br>
<?php echo $values['price']."円"; ?>
<?php  $sum += $values['price'];  ?>
</li>
<?php } ?>
</ul>
<!-- 購入ページへ戻るボタン -->
<div class="clear">
<p class="sum">
合計：<?php echo $sum; ?>円
</p>
<p>
<input type="button" onclick="location.href='http://localhost:8888/kadai/php/final/imacafe_investment.php'" value="戻る">
</p>
</div>
</article>
</body>
</html>
