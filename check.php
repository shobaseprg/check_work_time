<?php
session_start();
require('dbconnect.php');
require('calculate.php');

sessionCheck($_SESSION['userId'], $_SESSION['time']);

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

  // 登録ボタンを押すしたときデーターベースに保
  if (isset($_POST['approve'])) {
      push_approve();
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
    <?php echo $_SESSION['year']."年".$_SESSION['month']."月" ;?>

    <?php 
    $i = 0; 
    ?>
    <table class="t" border=1>
      <?php foreach ($_SESSION['week'] as $week) : ?>
        <tr>
        <?php 
          echo "<td>".($i + 1)."</td><td>".$dayOfTheWeek[$week]."</td>" ;
            if(in_array(($i + 1), $_SESSION['holiday'])) { // 配列の要素に合致するものがあるか(休日かどうか)
              echo "<td>休</td>";
            } 
            if ($_SESSION['holidayName'][$i + 1] ==! "") {
              echo "<td>".$_SESSION['holidayName'][$i + 1]."</dt>";  // 該当日が祝日に合致したら
            }
          $i++; ?>
        </tr>
        <?php endforeach ;?>
    </table>
    <?php 
      echo "先月不足時間  ".changeHour($_SESSION['lackTime']);
    ?>
    <br>
    <a href='edit.php'>戻る</a>
    <form action="" method='post'>
      <input type="submit" name="approve" method="post" value='登録する'>
    </form> 
  </body>
</html>
