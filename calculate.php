<?php
session_start();
require('dbconnect.php');

$dayOfTheWeek =array('日','月','火','水','木','金','土');

function changeMimit($hour, $minit) {
  return ($hour * 60) + $minit;
}

function changeHour($minitTime) {
  $hour = floor($minitTime / 60);
  $minit = $minitTime % 60;
  return $hour."時間".$minit."分";
}

function fromDayToMinit($day) {
  return $day * 8 * 60;
}
