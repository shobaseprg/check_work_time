<?php 
session_start();
require('dbconnect.php');
require('calculate.php');


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

        <?php
        // カレンダー呼び出し
        $saveDataCalendar = $db->prepare('SELECT * FROM calendar WHERE user_id = ?');
        $saveDataCalendar->execute(array($_SESSION['userId']));
        $saveCalendar = $saveDataCalendar->fetch();
        // 曜日呼び出し
        $saveDataDay = $db->prepare('SELECT * FROM day WHERE user_id = ?');
        $saveDataDay->execute(array($_SESSION['userId']));
        $saveDay = $saveDataDay->fetch();
        // 祝日名呼び出し
        $saveDataHolidayName = $db->prepare('SELECT * FROM holidayName WHERE user_id = ?');
        $saveDataHolidayName->execute(array($_SESSION['userId']));
        $saveHolidayName = $saveDataHolidayName->fetch();

        $defineWorkDay = 0;

        for($i=1; $i < $saveCalendar['lastday'] + 1; $i++) {
          echo "<br>";
          print($i);  // 日付出力
          $week = $saveDay[$i];// 曜日を数字で格納
          echo $dayOfTheWeek[$week];  // 日本語で曜日出力
          if ($saveCalendar[$i."d"] == 1 ) { // 休日だった場合
            echo "休日"; 
            if ($saveHolidayName[$i."d"] !== "") {  // 祝日名が格納されているか
              $holidayName = $saveHolidayName[$i."d"];
              echo $holidayName ; 
            }
          } else {  // 労働日の場合
            $defineWorkDay += 1;
          }
        }

      ?>
        <?php 
          fromDayToMinit($defineWorkDay);
          echo "所定労働日数  ".$defineWorkDay;
          echo "所定労働時間  ".fromDayToMinit($defineWorkDay);
          echo "先月不足時間  ".$saveCalendar['lackTime'];
          echo "必要労働時間".(fromDayToMinit($defineWorkDay) + $saveCalendar['lackTime']);
        ?>
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

