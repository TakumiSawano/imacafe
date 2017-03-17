<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
  <link rel="stylesheet" href="css/recet.css">
  <link rel="stylesheet" href="see_comments.css">
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
<h1>Curation</h1>
<p>今カフェ会員で作り上げるニュースのキュレーション掲示板</p>
<input type="button" value="前のページへ" onclick="history.back()">
<div class="error">
<?php
  foreach($err_msg as $errors){
    echo nl2br(h($errors));
  }
?>
</div>

<div class="article2">
<?php foreach($news_contents as $values) { ?>
<?php if($_POST['id'] ==  $values['post_id'])  {?>

<?php echo " ".$values['user_name']." " ?>
<?php echo $values['create_datetime'] ?><br>
<div class="news">
<h2><a href="<?php echo $values['url']; ?>" target="_blank"><?php echo getPageTitle( $values['url'] );?></a></h2><br>
<?php echo $values['theme']; ?><br>
</div>
<?php } ?>
<?php } ?>

<ul class="comments">
<?php foreach($news_contents as $values) { ?>
<?php foreach($post_comment as $value) { ?>
<?php if($value['post_id'] ===  $values['post_id'])  {?>
<li class="comments_list">
<?php echo $value['user_name']. " " ?>
<?php echo $value['create_datetime'] ?><br>
<?php echo "　".$value['comment'] ?><br>
</li>
<?php } ?>
<?php } ?>
<?php } ?>
</ul>

</div>
<input type="button" value="前のページへ" onclick="history.back()">
</article>

</body>
</html>
