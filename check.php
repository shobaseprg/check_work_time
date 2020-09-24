<?php
session_start();
require('dbconnect.php');
require('calculate.php');

$dayOfTheWeek =array('日','月','火','水','木','金','土');
$defineWorkTime = 0;

// 休日用配列を作成
$holidayArray = [];
for ($i=1; $i < 32; $i++) { 
  if(in_array(($i), $_SESSION['holiday'])) { // 配列の要素に合致するものがあるか(休日かどうか)
    $holidayArray[] = 1;
  } else {
    $holidayArray[] = 0;
  }
}


if (isset($_POST['approve'])) {  // 登録ボタンが押された場合

  $saveCalendar = $db->prepare('INSERT INTO calendar SET lackTime=?, year=?, month=?,
  1d=?, 2d=?, 3d=?, 4d=?, 5d=?, 6d=?, 7d=?, 8d=?, 9d=?, 10d=?, 
  11d=?, 12d=?, 13d=?, 14d=?, 15d=?, 16d=?, 17d=?, 18d=?, 19d=?, 20d=?, 
  21d=?, 22d=?, 23d=?, 24d=?, 25d=?, 26d=?, 27d=?, 28d=?, 29d=?, 30d=?, 
  31d=?,
  lastday=?, user_id =?');
  $saveCalendar->execute(array($_SESSION['lackTimeMinit'], $_SESSION['year'],$_SESSION['month'], 
  $holidayArray[0],$holidayArray[1],  $holidayArray[2],$holidayArray[3],  $holidayArray[4],
  $holidayArray[5],$holidayArray[6],  $holidayArray[7],$holidayArray[8],  $holidayArray[9],
  $holidayArray[10],$holidayArray[11],  $holidayArray[12],$holidayArray[13],  $holidayArray[14],
  $holidayArray[15],$holidayArray[16],  $holidayArray[17],$holidayArray[18],  $holidayArray[19],
  $holidayArray[20],$holidayArray[21],  $holidayArray[22],$holidayArray[23],  $holidayArray[24],
  $holidayArray[25],$holidayArray[26],  $holidayArray[27],$holidayArray[28],  $holidayArray[29],
  $holidayArray[30],
  $_SESSION['lastday'], $_SESSION['userId']));

  header('Location: check.php');
  exit();
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
    <h1>この設定で登録しますか？</h1>
    <p>先月不足時間</p>
    <?php echo $_SESSION['lackTimeMinit'] ;?>
    <p>設定年月日</p>
    <?php echo $_SESSION['year']."年".$_SESSION['month']."月" ;?>

    <?php $i = 0; 
    $defineWorkTime = 0;
    $defineWorkDay = 0;
    ?>

    <?php foreach ($_SESSION['week'] as $week) : ?>
      <p><?php echo ($i + 1)."日"."  ".$dayOfTheWeek[$week] ;?>
        <?php if(in_array(($i + 1), $_SESSION['holiday'])) { // 配列の要素に合致するものがあるか(休日かどうか)
          echo "休日  ";
        } else {
          $defineWorkTime += 8;
          $defineWorkDay += 1;
        }
        echo $_SESSION['holidayName'][$i + 1];  // 該当日が祝日に合致したら
        ?>
      <?php  $i++; ?>
    <?php endforeach ;?>
    <br>
    <?php 
      echo "所定労働日数  ".$defineWorkDay;
      echo "所定労働時間  ".changeMimit($defineWorkTime);
      echo "先月不足時間  ".$_SESSION['lackTimeMinit'];
      echo "必要労働時間".(changeMimit($defineWorkTime) + $_SESSION['lackTimeMinit']);
    ?>
    <br>
    <a href='edit.php'>戻る</a>
    <form action="" method='post'>
      <input type="submit" name="approve" method="post" value='登録する'>
    </form> 
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
$word = "start";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "end";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->
<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "lastday";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "_POST";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "lastday";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->
<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "holidayArray";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($_SESSION['lackTimeMinit']);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "_SESSION['userId']";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->

