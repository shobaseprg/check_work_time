<?php
session_start();
require('dbconnect.php');
$year = $_POST['year'];
$month = $_POST['month'];
$lastday = date('d', strtotime('last day of '.$year.'-'.$month));
$dayOfTheWeek =array('日','月','火','水','木','金','土');

// 祝日を取得------------------------
$api_key = 'AIzaSyDn5SBBZZ0sW9OehOXESw-EEoIpym4KX_4';
$calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');  // Googleの提供する日本の祝日カレンダ

$start = date($year."-".$month."-1\T00:00:00\Z");
$end = date($year."-".$month."-".$lastday."\T00:00:00\Z");

$url = "https://www.googleapis.com/calendar/v3/calendars/".$calendar_id."/events?";
$query = array(
    'key' => $api_key,
    'timeMin' => $start,
    'timeMax' => $end,
    'maxResults' => 50,
    'orderBy' => 'startTime',
    'singleEvents' => 'true'
);

$results = [];
if ($data = file_get_contents($url.http_build_query($query), true)) {
  // $queryをクエリ化してURLに結合する。
    $data = json_decode($data);
    foreach ($data->items as $row) {
        $results[$row->start->date] = $row->summary;
    }
}
/// 祝日を取得------------------------

$timestamp = mktime(0,0,0,$month,1,$year);
$week = date("w", $timestamp);
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>check_work_time</title>
    <link rel="stylesheet" href="../style.css" />
  </head>

  <body>
  <p>カレンダーを取得する。</p>
  <form action="" method="post">
    <select name="year">
      <option value=2020>2020</option>
      <option value=2021>2021</option>
      <option value=2022>2022</option>
    </select>

    <select name="month">
      <option value=01>1</option>
      <option value=02>2</option>
      <option value=03>3</option>
      <option value=04>4</option>
      <option value=05>5</option>
      <option value=06>6</option>
      <option value=07>7</option>
      <option value=08>8</option>
      <option value=09>9</option>
      <option value=10>10</option>
      <option value=11>11</option>
      <option value=12>12</option>
    </select>
  <input type="submit" value="取得する">
  <?php echo $year.$month; ?>

</form>
  <form action='' method="post">
    <?php for($i=1; $i < $lastday + 1; $i++) {
      print($i);  // 日付出力
      $timestamp = mktime(0,0,0,$month,$i,$year);
      $week = date("w", $timestamp);
      echo $dayOfTheWeek[$week];  // 日本語で曜日出力
      $targetDay = $year."-".$month."-".$i;
      // ループ日が祝日だった場合

      if ($week == 0  || $week == 6 ) {
        echo "<input type='checkbox' name='holiday' value=".$i." checked='checked'><br>"; 
        continue;
      }
      foreach($data->items as $row) {
        if ($row->start->date === $targetDay) {
          echo "<input type='checkbox' name='holiday' value=".$i." checked='checked'>"; 
          echo $row->summary."<br>";
          $isHoliday = "ON";
          break;
        }
      }
      if ($isHoliday !=="ON") {
        echo "<input type='checkbox' name='holiday' value=".$i."><br>";
      }
      $isHoliday = "OFF";
    }
    ?>
    <input type='submit' value="登録する" />
  </form>
  <h1><?php echo "カレンダー編集" ?></h1>
    本日：<?php  echo date("Y年m月d日"); ?>
    <form action="" method="post">
    
    </form>
  </body>
</html>
<!-- //▽▽▽▽▽▽▽----デバッグ----▽▽▽▽▽▽▽ -->
<?php
$word = "results";
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