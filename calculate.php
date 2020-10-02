<?php
session_start();
require('dbconnect.php');
header('X-FRAME-OPTIONS:DENY');

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

function sanitize ($inputWord){
  return htmlspecialchars($inputWord, ENT_QUOTES, 'UTF-8');
}

function putcsv($lackTime, changeHour($inuptTimeMinit), changeHour(((int)$saveCalendar['lackTime'] + ($fromTodayWorkTime * 60)))){
  $today = date("Y-m-d");
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename={$today}.csv");
  header("Content-Transfer-Encoding: binary");
  
  // 変数の初期化
  $times = array();
  $csv = null;
  
  // 出力したいデータのサンプル
  $times = array(
    array(
      'lackTime' => "過不足時間",
      'workTime' => "労働時間",
      'mustTime' => '必要労働時間'
    ),
    array(
      'lackTime' => $lackTime,
      'workTime' => $workTime,
      'mustTime' => $mustTime
    )
  );
  
  // 出力データ生成
  foreach( $times as $value ) {
    $csv .= $value['lackTime'].",".$value['workTime'].",".$value['mustTime']."\n" ;
  }
  
  // CSVファイル出力
  echo $csv;
  exit;

}

?>