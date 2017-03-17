<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>今カフェ</title>
<link rel="stylesheet" href="css/recet.css">
<style type="text/css">
<!--
@import url(https://fonts.googleapis.com/css?family=Lato:400,700);
@import url(http://fonts.googleapis.com/earlyaccess/notosansjp.css);

article {
  width: 1100px;
  margin-left: auto;
  margin-right: auto;
}
body {
  font-family: Lato, "Noto Sans JP", "游ゴシック Medium", "游ゴシック体", "Yu Gothic Medium", YuGothic, "ヒラギノ角ゴ ProN", "Hiragino Kaku Gothic ProN", "メイリオ", Meiryo, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
  background-image : url(img/cafe.jpg);
  background-attachment: fixed;
  margin-top: 0px;
  margin-left: 10px
}
/*ヘッダー*/
li {
  list-style-type: none;
  flex: 1;
}
ul {
  margin-left: 10px;
  padding-top: 7px;
}
.head {
  display: flex;
}
a {
  color: white;
}
.head_a {
  text-decoration: none;
  font-size: 20px;
}
.welcome {
  color: white;
  margin-left: 8px;
  text-align: right;
}
h1 {
  margin-top: 90px;
  margin-bottom: 8px;
  font-size: 40px;
  color: white;
}
.error {
  color: orange;
}
p {
  color: white;
  margin-bottom: 10px;
}

/* ヘッダーの固定 */
div#header-fixed
{
  position: fixed;            /* ヘッダーの固定 */
  top: 0px;                   /* 位置(上0px) */
  left: 0px;                  /* 位置(右0px) */
  width: 100%;                /* 横幅100%　*/
}


div#header-bk {
  background-color: rgba(0,0,0,0.5);
  margin-top: 0px;
	padding:5px 0 20px;       /* 上10px、下20pxをあける */
	width:100%;                 /* 横の幅を100% */
}


div#header {
  /* 表示領域を白枠で囲う */
  height: 100%;              /* 縦の表示領域はheader-bkと同じ */
  width: 1100px;              /* 横の幅970px */
  height: 55px;
  margin-left: auto;
  margin-right: auto;
}

input {
  background-color: rgba(0,0,0,0.5);
  color: white;
  width: 665px;
  height: 40px;
  font-size: 25px
}
button {
  background-color: rgba(0,0,0,0.5);
  color: white;
  width: 300px;
  height: 50px;
  font-size: 30px;
  margin-bottom: 10px;
}
-->
</style>

</head>



<body>
<header>
	<div id="header-fixed">
	  <div id="header-bk">
	    <div id="header">
	    <div class="welcome">
	    <?php echo "今カフェへようこそ！"; ?>
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
</header>


<article>
<form method="post">
	<h1>今？カフェで作業中。</h1>
  <p>ようこそ、ビジネスマン達によるビジネスマン達のための相互勉強サイト「今？カフェで作業中。」へ</p>
  <p>「今？カフェで作業中。」のご利用にはログインが必要です。</p>
  <div class="error">
  <?php echo $error; ?><br>
  <?php
    foreach ($err_msg as $errors) {
      echo $errors;
    }
  ?>
  </div>
  <p>
	<div class="form-group">
		<input type="email"  class="form-control" name="email" placeholder="メールアドレス" required />
	</div>
  </p>
  <p>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="パスワード" required />
	</div>
  </p>
	<button type="submit" class="btn btn-default" name="login">ログイン</button><br>
	<a href="imacafe_register.php">初めての方はコチラへ</a>
</form>
</article>
</body>
</html>
