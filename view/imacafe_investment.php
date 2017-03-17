<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
  <link rel="stylesheet" href="css/recet.css">
  <link rel="stylesheet" href="investment_top.css">
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
    <ul class="head_ul">
    <div class="head">
      <li class="head_lists"><a href="imacafe_top.php" class="head_a">Top</a></li>
      <li class="head_lists"><a href="imacafe_input.php" class="head_a">Output</a></li>
      <li class="head_lists"><a href="imacafe_news.php" class="head_a">Curation</a></li>
      <li class="head_lists"><a href="imacafe_investment.php" class="head_a">Self investment</a></li>
      <li class="head_lists"><a href="imacafe_mypage.php" class="head_a">My page</a></li>
      <a href="investment_cart.php"><img src="img/cart2.png" class="cart"></a>
    </div>
    </ul>
    </div>
  </div>
</div>

<article>
<h1>Self investment</h1>
<p>今カフェ会員の自己投資銘柄を紹介するショップ</p>
<p>
<form method="post">
  <select name="area">
    <option value="ビジネス">ビジネス</option>
    <option value="経済">経済</option>
    <option value="政治">政治</option>
    <option value="テクノロジー">テクノロジー</option>
    <option value="プログラミング">プログラミング</option>
    <option value="金融/マーケット">金融/マーケット</option>
    <option value="英語">英語</option>
    <option value="その他">その他</option>
  </select>
に関する自己投資を
<input type="submit" name="area_find" value="探す" >
</form>
</p>
<?php if(isset($_POST['area_find'])) { ?>
<h2><?php echo "＜".$_POST['area']."＞"; ?>の検索結果</h2>
<?php } ?>
<ul class="select_goods">
  <?php foreach ($area_data as $values)  { ?>
  <li class="select_lists">
  <img src="<?php echo $img_dir . $values['img']; ?>"><br>
  <?php echo h("【".$values['goods_name']."】"); ?><br>
  <?php echo h($values['price']).'円'; ?><br>
  <?php if ($values['stock'] == '0') {
          echo '売り切れです';
        } else {
  ?>
  <form method="post" action="investment_cart.php">
  <input type="hidden" name="id" value="<?php echo $values['goods_id']; ?>">
  <input type="submit" name="cart" value="カートに入れる">
  </form>
  <?php }?>
  </li>
  <?php }?>
</ul>

<div class="clear">
<h2>全ての商品</h2>
<ul class="goods">
  <?php foreach ($data as $values)  { ?>
  <li class="result_lists">
  <img src="<?php echo $img_dir . $values['img']; ?>"><br>
  <?php echo h("【".$values['goods_name']."】"); ?><br>
  <?php echo h($values['price']).'円'; ?><br>
  <?php if ($values['stock'] == '0') {
          echo '売り切れです';
        } else {
  ?>
  <form method="post" action="investment_cart.php">
  <input type="hidden" name="id" value="<?php echo $values['goods_id']; ?>">
  <input type="submit" name="cart" value="カートに入れる">
  </form>
  <?php }?>
  </li>
  <?php }?>
</ul>
</div>
</article>

</body>
</html>
