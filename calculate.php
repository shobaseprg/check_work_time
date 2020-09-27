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

