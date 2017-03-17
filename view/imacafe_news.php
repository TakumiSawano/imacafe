<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
  <link rel="stylesheet" href="css/recet.css">
  <link rel="stylesheet" href="imacafe_news.css">
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
<p class="h1_p">今カフェ会員で作り上げるニュースのキュレーション掲示板</p>
<div class="error">
<?php
  foreach($err_msg as $errors){
    echo nl2br(h($errors));
  }
?>
</div>

<form method="post" action="imacafe_news.php">
  <p>ニュースのURL：<input type="text" name="url" placeholder="ニュース記事などのリンク"></p>
  <p>ニュースの要約：</p>
  <textarea name="urltheme" cols="70" rows="5" wrap="hard"></textarea>
  <input type="submit" name="urlpost" value="投稿" class="link">
</form>

<?php foreach($news_contents as $values) { ?>

<div class="post_box">
<div class="form">
<form method="post">
<input type="hidden" name="id" value="<?php echo $values['post_id']?>">
<?php echo " ".$values['user_name']." "; ?>
<?php echo $values['create_datetime']; ?><br>
</form>
<form method="post" action="see_comment.php">
<input type="hidden" name="id" value="<?php echo $values['post_id'];?>">
コメント：<br><textarea name="comment" cols="50" rows="3" wrap="hard"></textarea><br>
<input type="submit" name="post_comment" value="コメント">
</form>
<form method="post" action="see_comment.php">
<input type="hidden" name="id" value="<?php echo $values['post_id'];?>">
<input type="submit" name="see_comment" value="コメントを見る">
</form>
</div>
<div class="news">
<h2><a href="<?php echo $values['url']; ?>" target="_blank"><?php echo getPageTitle( $values['url'] );?></a></h2><br>
<?php echo $values['theme']; ?><br>
</div>
</div>

<?php } ?>
</article>
</body>
</html>
