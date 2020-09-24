<?php
session_start();
require('dbconnect.php');
require('calculate.php');

$dayOfTheWeek =array('日','月','火','水','木','金','土');
$defineWorkTime = 0;

if (isset($_POST['approve'])) {  // 登録ボタンが押された場合

  $saveCalendar = $db->prepare('INSERT INTO calendar SET lackTime=?, year=?, month=?,
  -- 1=?, 2=?, 3=?, 4=?, 5=?, 6=?, 7=?, 8=?, 9=?, 10=?, 
  -- 11=?, 12=?, 13=?, 14=?, 15=?, 16=?, 17=?, 18=?, 19=?, 20=?, 
  -- 21=?, 22=?, 23=?, 24=?, 25=?, 26=?, 27=?, 28=?, 29=?, 30=?, 
  -- 31=?,
  lastday=?, user_id =?');
  $saveCalendar->execute(array($_SESSION['lackTimeMinit'], $_SESSION['year'],$_SESSION['month'], 
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
$word = "";
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