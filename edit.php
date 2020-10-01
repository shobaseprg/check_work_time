<?php
session_start();
require('dbconnect.php');
require('calculate.php');

sessionCheck($_SESSION['userId'], $_SESSION['time']);

$year = date("Y");
$month = date("m");
$lastday = date('d', strtotime('last day of '.$year.'-'.$month));

if (isset($_POST['confirm'])) {  // 確認するが押された場合
  $_SESSION = $_POST;
  $_SESSION['holiday'] = $_POST['holiday'];
  if (!empty($_POST['lackTimeHour']) || !empty($_POST['lackTimeMinit'])) {
    $_SESSION['lackTime'] = changeMimit($_POST['lackTimeHour'], $_POST['lackTimeMinit']);
  } else {
    $_SESSION['lackTime'] = 0;
  }
  header('Location: check.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>check_work_time</title>
    <link rel="stylesheet" href="./style.css" />
  </head>

  <body>
    <h1><?php echo "カレンダー編集" ?></h1>
    <form action="" method="post">
      <input type="submit" name='get' value="今月のカレンダーを取得する(※祝日はgoogleカレンダーに基づきます。)">
    </form>
    <br>
    <form action="" method="post">
      <input type="submit" name='recall' value="保存したカレンダーを呼び出す">
    </form>

      <!-- ===================================
      呼び出した時
      =================================== -->

    <?php if (!empty($_POST['recall'])) : ?>  
      <br>
        ※休日（有給含む）にチェックを入れてくください。
        （後から編集可能です。）
      <br>
      <table class='t' border=1>
        <form action='' method="post">
            <?php
            // データーベース 呼び出し
            require('getDB.php');
            for($i=1; $i < $saveCalendar['lastday'] + 1; $i++) {
              echo "<tr>";
              echo "<td>".$i."</td>";
                $week = $saveDay[$i];// 曜日を数字で格納
                echo "<input type='hidden' name='week[]' value='".$week."' />"; 
                echo "<td>".$dayOfTheWeek[$week]."</td>";  // 日本語で曜日出力
              if ($saveCalendar[$i."d"] == 1 ) { // 休日だった場合
                echo "<td><input type='checkbox' name='holiday[]' value=".$i." checked='checked'></td>"; 
                if ($saveHolidayName[$i."d"] !== "") {  // 祝日を回して調査日と合致するか確認
                  $holidayName = $saveHolidayName[$i."d"];
                  echo "<input type='hidden' name='holidayName[".$i."]' value='".$holidayName."'>"; 
                  echo "<td>".$holidayName."</td>";
                }
              } else {
                echo "<td><input type='checkbox' name='holiday[]' value='".$i."'></td>";
              }
              echo "</tr>";
            }
            $saveLackTimeHour = changeHour($saveCalendar['lackTime']);
          ?>
      </table>

        <p>前月の不足時間</p>
        <?php echo $saveLackTimeHour ; ?>
          <div id="lackTimeBottun">
          不足時間を変更する
        </div>
        <div id="lackTimeInputForm" class='non-show'>
          <input type='number' name='lackTimeHour' min=0 max=999 value=0>時間 <!-- 不足時間 -->
          <input type='number' name='lackTimeMinit' min=0 max=60 value=0> 分<!-- 不足分 -->
        </div>
        <input type='hidden' name='year' value="<?php echo $saveCalendar['year'] ?>" />
        <input type='hidden' name='month' value="<?php echo $saveCalendar['month'] ?>" />
        <input type='hidden' name='lastday' value="<?php echo $saveCalendar['lastday'] ?>" />
        <input type='hidden' name='userId' value="<?php echo $_SESSION['userId'] ?>" />
        <input type='hidden' name='userName' value="<?php echo $_SESSION['userName'] ?>" />
        <input type='hidden' name='time' value="<?php echo $_SESSION['time'] ?>" />
        <input type='submit' name='confirm' value="確認する" />
      </form>
    <?php endif; ?>

      <!-- ===================================
      取得した時
      =================================== -->

    <?php if (!empty($_POST['get'])) : ?>  
      <br>
        ※休日（有給含む）にチェックを入れてくください。
        （後から編集可能です。）
      <br>
      <?php require('getHoliday.php'); ?><!-- 祝日を取得 -->
      <form action='' method="post"><!-- 日付のチェックボックス -->
        <table class="t" border=1>
          <?php for($i=1; $i < $lastday + 1; $i++) {
            echo "<tr>";
              echo "<td>".$i."</td>";  // 日付出力
              $timestamp = mktime(0,0,0,$month,$i,$year);
              $week = date("w", $timestamp);  // 曜日を数字で格納
              echo "<input type='hidden' name='week[]' value='".$week."' />"; 
              echo "<td>".$dayOfTheWeek[$week]."</td>";  // 日本語で曜日出力

              if ($i < 10) {
                $targetDay = $year."-".$month."-0".$i;  // 2020-9-01の形で格納
              } else {
                $targetDay = $year."-".$month."-".$i;  // 日付が十桁以上ならそのまま
              }

              if ($week == 0  || $week == 6 ) { // 土日だった場合
                echo "<td><input type='checkbox' name='holiday[]' value=".$i." checked='checked'></td>"; 
                continue;
                // 土日だった場合は、ループをスキップ
              }
              foreach($date->items as $row) {
                if ($row->start->date === $targetDay) {  // 祝日を回して調査日と合致するか確認
                  $holidayName = $row->summary;
                  echo "<td><input type='checkbox' name='holiday[]' value=".$i." checked='checked'></td>"; 
                  echo "<input type='hidden' name='holidayName[".$i."]' value='".$holidayName."'>"; 
                  echo "<td>".$holidayName."</td>";
                  $isHoliday = "ON";
                  break;
                }
              }
              if ($isHoliday !=="ON") {  // 土日でも祝日でもなかった場合
                echo "<td><input type='checkbox' name='holiday[]' value='".$i."'></td>";
              }
              $isHoliday = "OFF";
            echo "</tr>";
          }
          ?>
          </table>
        <p>前月の不足時間</p>
        <input type='number' name='lackTimeHour' min=0 max=999 value=0>時間<!-- 不足時間 -->
        <input type='number' name='lackTimeMinit' min=0 max=60 value=0>分 <!-- 不足分 -->
        <input type='hidden' name='year' value="<?php echo $year ?>" />
        <input type='hidden' name='month' value="<?php echo $month ?>" />
        <input type='hidden' name='lastday' value="<?php echo $lastday ?>" />
        <input type='hidden' name='userId' value="<?php echo $_SESSION['userId'] ?>" />
        <input type='hidden' name='userName' value="<?php echo $_SESSION['userName'] ?>" />
        <input type='hidden' name='time' value="<?php echo $_SESSION['time'] ?>" />
        <br><br>
        <input type='submit' name='confirm' value="確認する" />
      </form>
    <?php endif; ?>
    <script src="button.js"></script>
  </body>
</html>
