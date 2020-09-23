<?php
session_start();
require('dbconnect.php');

function changeMimit($hourAndMinitTime) {
  $splitTime = explode(":",$hourAndMinitTime);
  return (intval($splitTime[0] * 60)) + intval($splitTime[1]);
}

function changeHour($time) {
  $hour = floor($time / 60);
  $minit = $time % 60;
  return $hour.":".$minit;
}

?>
