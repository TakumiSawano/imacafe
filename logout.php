<?php
session_start();

// logout.php?logoutにアクセスしたユーザーをログアウトする
if(isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['user']);
  header("Location: imacafe_top.php");
} else {
  header("Location: imacafe_top.php");
}
