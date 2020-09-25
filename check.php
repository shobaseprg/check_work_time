<?php
session_start();
require('dbconnect.php');
require('calculate.php');


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

// 祝日名前用配列
$holidayNameArray = [];
  for ($i=1; $i < 32; $i++ ) {
    if (array_key_exists($i, $_SESSION['holidayName'])) {
      $holidayNameArray[] = $_SESSION['holidayName'][$i];
    } else {
      $holidayNameArray[] = "";
    }
  }

if (isset($_POST['approve'])) {  // 登録ボタンが押された場合

  $saveCalendar = $db->prepare('UPDATE calendar SET lackTime=?, year=?, month=?,
  1d=?, 2d=?, 3d=?, 4d=?, 5d=?, 6d=?, 7d=?, 8d=?, 9d=?, 10d=?, 
  11d=?, 12d=?, 13d=?, 14d=?, 15d=?, 16d=?, 17d=?, 18d=?, 19d=?, 20d=?, 
  21d=?, 22d=?, 23d=?, 24d=?, 25d=?, 26d=?, 27d=?, 28d=?, 29d=?, 30d=?, 
  31d=?,
  lastday=?
  WHERE user_id =?');

  $saveCalendar->execute(array($_SESSION['lackTimeMinit'], $_SESSION['year'],$_SESSION['month'], 
  $holidayArray[0],$holidayArray[1],  $holidayArray[2],$holidayArray[3],  $holidayArray[4],
  $holidayArray[5],$holidayArray[6],  $holidayArray[7],$holidayArray[8],  $holidayArray[9],
  $holidayArray[10],$holidayArray[11],  $holidayArray[12],$holidayArray[13],  $holidayArray[14],
  $holidayArray[15],$holidayArray[16],  $holidayArray[17],$holidayArray[18],  $holidayArray[19],
  $holidayArray[20],$holidayArray[21],  $holidayArray[22],$holidayArray[23],  $holidayArray[24],
  $holidayArray[25],$holidayArray[26],  $holidayArray[27],$holidayArray[28],  $holidayArray[29],
  $holidayArray[30],
  $_SESSION['lastday'], $_SESSION['userId']));

  $saveDay = $db->prepare('UPDATE day SET
  1d=?, 2d=?, 3d=?, 4d=?, 5d=?, 6d=?, 7d=?, 8d=?, 9d=?, 10d=?, 
  11d=?, 12d=?, 13d=?, 14d=?, 15d=?, 16d=?, 17d=?, 18d=?, 19d=?, 20d=?, 
  21d=?, 22d=?, 23d=?, 24d=?, 25d=?, 26d=?, 27d=?, 28d=?, 29d=?, 30d=?, 
  31d=?
  WHERE user_id =?');
  $saveDay->execute(array(
  $_SESSION['week'][0],$_SESSION['week'][1],$_SESSION['week'][2],$_SESSION['week'][3],$_SESSION['week'][4],$_SESSION['week'][5],
  $_SESSION['week'][6],$_SESSION['week'][7],$_SESSION['week'][8],$_SESSION['week'][9],$_SESSION['week'][10],
  $_SESSION['week'][11],$_SESSION['week'][12],$_SESSION['week'][13],$_SESSION['week'][14],$_SESSION['week'][15],
  $_SESSION['week'][16],$_SESSION['week'][17],$_SESSION['week'][18],$_SESSION['week'][19],$_SESSION['week'][20],
  $_SESSION['week'][21],$_SESSION['week'][22],$_SESSION['week'][23],$_SESSION['week'][24],$_SESSION['week'][25],
  $_SESSION['week'][26],$_SESSION['week'][27],$_SESSION['week'][28],$_SESSION['week'][29],$_SESSION['week'][30],
  $_SESSION['userId'],));

  $saveHolidayName = $db->prepare('UPDATE holidayName SET
  1d=?, 2d=?, 3d=?, 4d=?, 5d=?, 6d=?, 7d=?, 8d=?, 9d=?, 10d=?, 
  11d=?, 12d=?, 13d=?, 14d=?, 15d=?, 16d=?, 17d=?, 18d=?, 19d=?, 20d=?, 
  21d=?, 22d=?, 23d=?, 24d=?, 25d=?, 26d=?, 27d=?, 28d=?, 29d=?, 30d=?, 
  31d=?
  WHERE user_id =?');
  $saveHolidayName->execute(array($holidayNameArray[0], 
    $holidayNameArray[1], $holidayNameArray[2], $holidayNameArray[3], $holidayNameArray[4], $holidayNameArray[5], 
    $holidayNameArray[6], $holidayNameArray[7], $holidayNameArray[8], $holidayNameArray[9], $holidayNameArray[10], 
    $holidayNameArray[11], $holidayNameArray[12], $holidayNameArray[13], $holidayNameArray[14], $holidayNameArray[15], 
    $holidayNameArray[16], $holidayNameArray[17], $holidayNameArray[18], $holidayNameArray[19], $holidayNameArray[20], 
    $holidayNameArray[21], $holidayNameArray[22], $holidayNameArray[23], $holidayNameArray[24], $holidayNameArray[25], 
    $holidayNameArray[26], $holidayNameArray[27], $holidayNameArray[28], $holidayNameArray[29], $holidayNameArray[30], 
    $_SESSION['userId']
  ));
  session_destroy();
  $_SESSION = array();
  header('Location: join/login.php');
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

<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "holidayNameArray";
echo '<pre><br>---------------【(＄)'.$word.'】--------------------<br>';
print_r($$word);
echo '</pre>';
?>
<!-- //△△△△△△△----デバッグ----△△△△△△△ -->