<?php
session_start();
require('dbconnect.php');

$dayOfTheWeek =array('日','月','火','水','木','金','土');

function changeMimit($hourAndMinitTime) {
  $splitTime = explode(":",$hourAndMinitTime);
  return (intval($splitTime[0] * 60)) + intval($splitTime[1]);
}

function changeHour($minitTime) {
  $hour = floor($minitTime / 60);
  $minit = $minitTime % 60;
  return $hour."時間".$minit."分";
}

?>
