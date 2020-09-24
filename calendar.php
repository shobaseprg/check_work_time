<?php 
session_start();
require('dbconnect.php');

if (empty($_SESSION['userId'])){
  header("Location: join/login.php");
}

ini_set('display_errors', 1);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

if (isset($_SESSION['userId']) && $_SESSION['time'] + 3600 > time()) {
  $users = $db->prepare('SELECT * FROM users WHERE id = ? ');
  $users->execute(array($_SESSION['userId']));
  $user = $users->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>check_work_time</title>
    <link rel="stylesheet" href="../style.css" />
  </head>

  <body>
  <h1><?php echo $user['name']."さんようこそ"; ?></h1>
    本日：<?php  echo date("Y年m月d日"); ?>
  <a href= 'edit.php'>カレンダー編集</a>
  <a href= 'join/login.php'>ログインへ</a>
  </body>
</html>

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "_SESSION";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "user";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->