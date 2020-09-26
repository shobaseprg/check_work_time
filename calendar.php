<?php 
session_start();
require('dbconnect.php');

if (isset($_SESSION['userId']) && $_SESSION['time'] + 3600 > time()) {
} else {
  header('Location: join/login.php');
  exit();
}
$users = $db->prepare('SELECT * FROM users WHERE id = ? ');
$users->execute(array($_SESSION['userId']));
$user = $users->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>check_work_time</title>
    <link rel="stylesheet" href="../style.css" />
  </head>

  <body>
  <h1><?php echo $_SESSION['userName']."さん"; ?></h1>
    本日：<?php  echo date("Y年m月d日"); ?>
  <a href= 'edit.php'>カレンダー編集</a>
  <a href= 'join/logout.php'>ログアウト</a>
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

