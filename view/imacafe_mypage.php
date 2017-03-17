<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>今カフェ</title>
<link rel="stylesheet" href="css/recet.css">
<link rel="stylesheet" href="imacafe_mypage.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(function() {
  var count = 150;
  $('.text_overflow').each(function() {
    var thisText = $(this).text();
    var textLength = thisText.length;
    if (textLength > count) {
      var showText = thisText.substring(0, count);
      var hideText = thisText.substring(count, textLength);
      var insertText = showText;
      insertText += '<span class="hide">' + hideText + '</span>';
      insertText += '<span class="omit">…</span>';
      insertText += '<a href="" class="more">もっと見る</a>';
      $(this).html(insertText);
    };
  });
  $('.text_overflow .hide').hide();
  $('.text_overflow .more').click(function() {
    $(this).hide()
      .prev('.omit').hide()
      .prev('.hide').fadeIn();
    return false;
  });
});
</script>
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


<div class="h1">
<h1>My page</h1>
<p>自分のOutput、Curationを振り返る場</p>
</div>
<?php foreach($err_msg as $errors) {
  echo $errors;
} ?>

<article>
<div class="article1">
<h2>My Output</h2>
<?php foreach($my_contents as $values) { ?>
<div class="post">
<br>
&lt<?php echo $values['theme']; ?>&gt
<?php echo $values['create_datetime']; ?><br>
<div class="img_text">
<div class="img">
<img src="<?php echo $img_dir . $values['img']; ?>">
</div>
<div class="textbox">
<div class="text_overflow"><?php echo $values['textbox']; ?></div><br>
</div>
</div>
<br>
</div>
<?php } ?>
</div>

<div class="article2">
<h2>My Curation</h2>
<?php foreach($my_curation as $values) { ?>
<div class="post_box">
<?php echo $values['create_datetime']; ?><br>
<form method="post" action="see_comment.php">
<h2 class="news"><a href="<?php echo $values['url']; ?>" target="_blank"><?php echo getPageTitle( $values['url'] );?></a></h2>
<input type="submit" name="submit" value="コメントを見る"><br>
<?php echo $values['theme']; ?><br>
<input type="hidden" name="id" value="<?php echo $values['post_id']; ?>">
</form>
</div>
<?php } ?>
</div>
</article>

</body>
</html>
