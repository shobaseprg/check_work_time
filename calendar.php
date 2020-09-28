<?php 
session_start();
require('dbconnect.php');
require('calculate.php');
require('getDB.php');

// ログイン処理
sessionCheck($_SESSION['userId'], $_SESSION['time']);

$defineWorkDay = 0;
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
<!-- ===================================
入力フォーム
=================================== -->
    <div class="inputTime">
      <form action = "" method='POST'>
      <?php  echo date("Y年m月d日"); ?>終了時点の労働時間入力
        <input type='number' name='lackTimeHour' min=0 max= 999 value=0>時間 <!-- 不足時間 -->
        <input type='number' name='lackTimeMinit' min=0 max=60 value=0>分 <!-- 不足分 -->
        <input type='submit' name="calculate" value="計算する">
      </form>
    </div>

<!-- ===================================
// 計算結果
// =================================== -->
    <?php
      if (!empty($_POST['calculate'])){
        $today = (int)date("d");
        $fromTodayWorkTime = 0;
        $fromTodayWorkDay = 0;
        for($i=1; $i < $today + 1; $i++) {
          if ($saveCalendar[$i."d"] == 0 ) { // 平日だった場合
            $fromTodayWorkTime += 8;
            $fromTodayWorkDay += 1;
            }
          }
        $inuptTimeMinit = changeMimit($_POST['lackTimeHour'], $_POST['lackTimeMinit']);
        $result = ((int)$saveCalendar['lackTime'] + ($fromTodayWorkTime * 60)) - $inuptTimeMinit;
        if ($result > 0) {
          $is_over = "不足";
        } else {
          $is_over = "超過";
        }
        $resultAbs = abs($result);
        echo "<br><div class='result'>".changeHour($resultAbs).$is_over."</div><br>";
        echo "<div class='detail'>";
        echo "本日までの所定労働日数(休日、有給を除く日数）：".$fromTodayWorkDay."日<br> ";
        echo "本日までの所定労働時間：".$fromTodayWorkTime."時間00分<br>";
        echo "先月までの不足時間：".changeHour((int)$saveCalendar['lackTime'])."<br>";
        echo "本日までの必要労働時間：".changeHour(((int)$saveCalendar['lackTime'] + ($fromTodayWorkTime * 60)))."<br>";
        echo "本日までの労働時間".changeHour($inuptTimeMinit);
        echo "</div>";

        }
    ?>
<!-- // ===================================
// カレンダー表
// ===================================-->
    <table class='t' border=1>
      <?php
          for($i=1; $i < $saveCalendar['lastday'] + 1; $i++) {
            echo "<tr>";
              echo "<td>";
                print($i);  // 日付出力
              echo "</td>";
              $week = $saveDay[$i];// 曜日を数字で格納
              echo "<td>";
                echo $dayOfTheWeek[$week];  // 日本語で曜日出力
              echo "</td>";

            if ($saveCalendar[$i."d"] == 1 ) { // 休日だった場合
              echo "<td>";
                echo "休"; 
              echo "</td>";
              if ($saveHolidayName[$i."d"] !== "") {  // 祝日名が格納されているか
                $holidayName = $saveHolidayName[$i."d"];
              echo "<td>";
                echo $holidayName ; 
              echo "</td>";
              }
            } else {  // 労働日の場合
              $defineWorkDay += 1;
            }
            echo "</tr>";
          }
        ?>
    </table>
  </body>
</html>
