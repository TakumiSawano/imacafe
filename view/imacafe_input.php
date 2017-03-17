<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
  <link rel="stylesheet" href="css/recet.css">
  <link rel="stylesheet" href="imacafe_inputs.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(function() {
  var count = 480;
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

<article>
<h1>Output</h1>
<p class="h1_p">今カフェ会員たちによるビジネス本の要約を共有する掲示板</p>

<div class="error">
<?php
  foreach($err_msg as $errors){
    echo nl2br(h($errors));
  }
?>
</div>
<form method="post" enctype="multipart/form-data">
  <p>本のタイトル：<br>
  <input type="text" name="theme" placeholder="アドラー心理学 など"></p>
  <p>画像（本の写真など。なくても可）：<br>
  <input type="file" name="new_img"></p>
  <p>アウトプット：</p>
  <textarea name="textbox" cols="80" rows="8" wrap="hard"></textarea>
  <input type="submit" name="output" value="Output">
</form>

<?php foreach($contents as $values) { ?>
<div class="post">
&lt<?php echo $values['theme']?>&gt
<?php echo " ".$values['user_name']." " ?>
<?php echo $values['create_datetime'] ?><br>
<div class="img_text">
  <div class="img">
  <img src="<?php echo $img_dir . $values['img']; ?>">
  </div>
  <div class="textbox">
  <div class="text_overflow"><?php echo nl2br($values['textbox']) ?></div><br>
  </div>
</div>
</div>
<?php } ?>
</article>
</body>
</html>
