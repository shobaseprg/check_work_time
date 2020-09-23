<?php
session_start();
require('dbconnect.php');
require('calculate.php');

$dayOfTheWeek =array('日','月','火','水','木','金','土');
$defineWorkTime = 0;

if (isset($_POST['approve'])) {  // 登録ボタンが押された場合
  $_SESSION['lackTimeMinit'] = $lackTimeToMimit;
  header('Location: check.php');
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
    <?php echo $_SESSION['lackTime'] ;?>
    <p>設定年月日</p>
    <?php echo $_SESSION['year']."年".$_SESSION['month']."月" ;?>

    <?php $i = 0; ?>
    <?php foreach ($_SESSION['week'] as $week) : ?>
      <p><?php echo ($i + 1)."日"."  ".$dayOfTheWeek[$week] ;?>
        <?php if(in_array(($i + 1), $_SESSION['holiday'])) { // 配列の要素に合致するものがあるか(休日かどうか)
          echo "休日  ";
        } else {
          $defineWorkTime += 8;
        }
        echo $_SESSION['holidayName'][$i + 1];  // 該当日が祝日に合致したら
        ?>
      <?php  $i++; ?>
    <?php endforeach ;?>
    <br>
    <?php 
      echo "所定労働時間  ".$defineWorkTime.":00" ;
      $defineWorkTimeToMimit = changeMimit($defineWorkTime);
      echo "(".$defineWorkTimeToMimit."分)";
      echo "先月不足時間  ".$_SESSION['lackTime'];
      $lackTimeToMimit = changeMimit($_SESSION['lackTime']);
      echo "(".$lackTimeToMimit."分)";
      $totalMinit = $defineWorkTimeToMimit + $lackTimeToMimit;
      echo "必要労働時間".changeHour($totalMinit)."(".$totalMinit."分)";
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