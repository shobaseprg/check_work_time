<?php 
session_start();
require('../dbconnect.php');

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
        $_SESSION['userName'] = $user['name'];
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
      <div>
        name
          <input type='text' name='name' maxlength='10' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"/>
      </div>
      <div>
        password
          <input type='password' name='password' maxlength='10' value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>"/>
      </div>
      <br>
      <div>
        名前を保存しますか？
        <input type='radio' name='saveName' value='on' checked="checked">保存する
        <input type='radio' name='saveName' value='off'>保存しない
      </div>
      <br>
        <?php if($error['login'] === 'blank'): ?>
          <p class='error-display'>空欄があります。</p>
        <?php endif; ?>
        <?php if($error['login'] === 'faild'): ?>
          <p class='error-display'>間違っています。</p>
        <?php endif; ?>
        <input type='submit' value='ログインする' />
    </form>
    <br>
    <a href='../join/signup.php'>新規登録へ</a>
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
