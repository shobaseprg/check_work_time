<?php  
session_start();
require('../dbconnect.php');

session_destroy();
$_SESSION = array();

if (!empty($_POST)) {
  if($_POST['name'] === ""){
    $error['name'] = 'blank';
  }
  if(strlen($_POST['password']) < 4 || strlen($_POST['password']) >11){
      $error['password'] = 'length';
  }
  if($_POST['password'] ==="") {
    $error['password'] = 'blank';
  }
  if(empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) as cnt FROM users WHERE name = ?');
    $member->execute(array($_POST['name']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
      $error['name'] = "duplicate";
    } 
  }
  if (empty($error)) {
      $user = $db->prepare('INSERT INTO users SET name=?, password=?');
      $user->execute(array($_POST['name'],sha1($_POST['password'])));
      // ユーザーを作成する

      $userForCreateCalendar = $db->prepare('SELECT *  FROM users WHERE name = ?');
      $userForCreateCalendar->execute(array($_POST['name']));
      $targetUser = $userForCreateCalendar->fetch();
      // 作成したユーザーを取得

      $baseCalendar = $db->prepare('INSERT INTO calendar SET user_id=?');
      $baseCalendar->execute(array($targetUser['id']));
      // ユーザーに紐づくカレンダーを作成

      $baseDay = $db->prepare('INSERT INTO day SET user_id=?');
      $baseDay->execute(array($targetUser['id']));
      // ユーザーに紐づく曜日を作成

      $baseHN = $db->prepare('INSERT INTO holidayName SET user_id=?');
      $baseHN->execute(array($targetUser['id']));
      // ユーザーに紐づく祝日名を作成

      header('Location: thanks.php');
      exit();
  }
  unset($_SESSION);
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
  <h1>新規登録</h1>
    <form action="" method="post">
      <div>
        name
          <input type="text" name="name" maxlength="10" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES));?>" />
      </div>
        <?php if($error['name'] === 'blank'): ?>
          <p class='error-display'>nameを入力してください</p>
        <?php endif; ?>
        <?php if($error['name'] === 'duplicate'): ?>
          <p class='error-display'>nameが重複しています。</p>
        <?php endif; ?>
      <div>
      パスワード
        <input type="password" name="password" size="10" maxlength="20" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>" />
      </div>
        <?php if($error['password'] === 'length'): ?>
          <p class='error-display'>*パスワードを4文字以上、１０文字以内で入力してください</p>
        <?php endif; ?>
        <?php if($error['name'] === 'blank'): ?>
          <p class='error-display'>passwordを入力してください</p>
        <?php endif; ?>
      <p>登録しますか？</p>
      <div><input type="submit" value="OK" /></div>
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

