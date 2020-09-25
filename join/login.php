<?php 
session_start();
require('../dbconnect.php');
// ini_set('display_errors', 1);
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

if ($_COOKIE !== '')  {
  $name = $_COOKIE['name'];
}
if(!empty($_POST)) {
  if (($_POST['name'] !=='' && $_POST['password'] !=='')) {
    $loginWords = $db->prepare('SELECT * FROM users WHERE name=? AND password=?');
    $loginWords->execute(array($_POST['name'], sha1($_POST['password'])));
    $user = $loginWords->fetch();
      if ($user) {
        $_SESSION['userId'] = $user['id'];
        $_SESSION['time'] = time();
          if ($_POST['saveName'] === 'on') {
            setcookie('name',  $_POST['name'], time()+60*60*24*14);
          } else {
            setcookie('name', "", time()-60);
          }
          header('Location: ../calendar.php');
      } else {
        $error['login'] = 'faild';
      }
  } else {
    $error['login'] = 'blank';
  }
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
    <h1>ログイン</h1>
    <form action='' method='post'>
      <p>name</p>
        <input type='text' name='name' maxlength='10' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"/>
      <p>password</p>
        <input type='password' name='password' maxlength='10' value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>"/><br><br>
      名前を保存しますか？
        <input type='radio' name='saveName' value='on' checked="checked">保存する
        <input type='radio' name='saveName' value='off'>保存しない
        <?php if($error['login'] === 'blank'): ?>
          <p class='error-display'>空欄があります。</p>
        <?php endif; ?>
        <?php if($error['login'] === 'faild'): ?>
          <p class='error-display'>間違っています。</p>
        <?php endif; ?>
      <p>ログインしますか？</p>
        <input type='submit' value='OK' />
    </form>
    <a href='../join'>トップへ</a>
  </body>
</html>

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
echo '<pre><br>---------------【_POST】--------------------<br>';
print_r($_POST);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△

//▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
echo '<pre><br>---------------【_SESSION】--------------------<br>';
print_r($_SESSION);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "_COOKIE";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "_COOKIE['name']";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "_COOKIE['password']";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->