<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>今カフェ</title>
  <link rel="stylesheet" href="css/recet.css">
  <link rel="stylesheet" href="imacafe_tops.css">
</head>

<body>

<div class="header">
<header>
<div class="title">
<h1>今？カフェで作業中。</h1>
<p class="intro">ビジネスマン達によるビジネスマン達のためのサイト</p>
</div>
<div class="welcome">
<?php foreach($user_name as $values) { ?>
<?php echo $values['user_name']."さん。今カフェへようこそ" ?><br>
<?php } ?>
<?php if(!isset($_SESSION['user'])) { ?>
<a href="imacafe_login.php" class="log">ログイン</a>
<?php } else if (isset($_SESSION['user'])) { ?>
<a href="logout.php?logout" class="log">ログアウト</a>
<?php } ?>
</div>
</header>

</div>
<div class="headback">
<div class="head">
  <a href="imacafe_input.php" class="head_a">
  <h2>Output</h2>
  <p class="text">今カフェ会員たちによるビジネス本の要約を共有する掲示板</p>
  </a>
</div>
</div>
<div class="headback">
<div class="head">
  <a href="imacafe_news.php" class="head_a">
  <div class="column">
  <h2>Curation</h2>
  <p class="text">今カフェ会員で作り上げるニュースのキュレーション掲示板</p>
  </div>
  </a>
</div>
</div>
<div class="headback">
<div class="head">
  <a href="imacafe_investment.php" class="head_a">
  <div class="column">
  <h2>Self investment</h2>
  <p class="text">今カフェ会員の自己投資銘柄を紹介するショップ</p>
  </div>
  </a>
</div>
</div>
<div class="headback">
<div class="head">
  <a href="imacafe_mypage.php" class="head_a">
  <div class="column">
  <h2>My page</h2>
  <p class="text">自分のアウトプット、投稿した記事を振り返る場</p>
  </div>
  </a>
</div>
</div>
<div class="footercolor">
<footer>
<ul>
  <li><a href="promise.php" class="foot_text">利用規約</a></li>
  <li><a href="policy.php" class="foot_text">プライバシーポリシー</a></li>
</ul>
</footer>
</div>

</body>
</html>
