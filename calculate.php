<?php
session_start();
require('dbconnect.php');

$dayOfTheWeek =array('日','月','火','水','木','金','土');

// 時間と分を分に変更
function changeMimit($hour, $minit) {
  return ($hour * 60) + $minit;
}

// 分を時間と分に変更
function changeHour($minitTime) {
  $hour = floor($minitTime / 60);
  $minit = $minitTime % 60;
  return $hour."時間".$minit."分";
}

// 労働日から労働分を算出
function fromDayToMinit($day) {
  return $day * 8 * 60;
}

// ログイン処理
function sessionCheck($userId, $sessionTime) {
  if (isset($userId) && $sessionTime + 3600 > time()) {
  } else {
    header('Location: join/login.php');
    exit();
  }
}


function push_approve() {
    // 登録ボタンが押された場合
    $saveCalendar = $db->prepare('UPDATE calendar SET lackTime=?, year=?, month=?,
    1d=?, 2d=?, 3d=?, 4d=?, 5d=?, 6d=?, 7d=?, 8d=?, 9d=?, 10d=?, 
    11d=?, 12d=?, 13d=?, 14d=?, 15d=?, 16d=?, 17d=?, 18d=?, 19d=?, 20d=?, 
    21d=?, 22d=?, 23d=?, 24d=?, 25d=?, 26d=?, 27d=?, 28d=?, 29d=?, 30d=?, 
    31d=?,
    lastday=?
    WHERE user_id =?');

    $saveCalendar->execute(array($_SESSION['lackTime'], $_SESSION['year'],$_SESSION['month'], 
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
    // session_destroy();
    // $_SESSION = array();
    header('Location: calendar.php');
    exit();
}
