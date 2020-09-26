<?php 
session_start();
require('dbconnect.php');
require('calculate.php');
require('getDB.php');

// ログイン処理
if (isset($_SESSION['userId']) && $_SESSION['time'] + 3600 > time()) {
} else {
  header('Location: join/login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>check_work_time</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <h1><?php echo $_SESSION['userName']."さん"; ?></h1>
      <a href= 'edit.php'>カレンダー編集</a>
      <a href= 'join/logout.php'>ログアウト</a>
      <br>
      <br>
      <div class="inputTime">
        <form action = "" method='POST'>
        <?php  echo date("Y年m月d日"); ?>終了時点の労働時間入力
          <input type='number' name='lackTimeHour' min=0 max= 999 value=0>時間 <!-- 不足時間 -->
          <input type='number' name='lackTimeMinit' min=0 max=60 value=0>分 <!-- 不足分 -->
          <input type='submit' name="calculate" value="計算する">
        </form>
      </div>
    <!-- // =================================== 
    // 計算結果出力
    // =================================== -->
    <?php if (!empty($_POST['calculate'])) :?>
      <?php $today = (int)date("d");
        $fromTodayWorkTime = 0;
        for($i=1; $i < $today + 1; $i++) {
          if ($saveCalendar[$i."d"] == 0 ) { // 平日だった場合
            $fromTodayWorkTime += 8;
            }
          }
        $inuptTimeMinit = changeMimit($_POST['lackTimeHour'], $_POST['lackTimeMinit']);
        $result = ((int)$saveCalendar['lackTime'] + ($fromTodayWorkTime * 60)) - $inuptTimeMinit;
        // 不足時間  +  本日までの労働時間  +  入力された時間
        if ($result < 0) {
          $is_over = "超過";
        } else {
          $is_over = "不足";
        }
        $resultAbs = abs($result); // 自然数に
      ?>
      <br><div class='result'><?php echo changeHour($resultAbs).$is_over ?></div>;
    <? endif; ?>
      
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

