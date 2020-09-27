<?php
// ユーザー取得
$users = $db->prepare('SELECT * FROM users WHERE id = ? ');
$users->execute(array($_SESSION['userId']));
$user = $users->fetch();

// カレンダー呼び出し
$saveDataCalendar = $db->prepare('SELECT * FROM calendar WHERE user_id = ?');
$saveDataCalendar->execute(array($_SESSION['userId']));
$saveCalendar = $saveDataCalendar->fetch();
// 曜日呼び出し
$saveDataDay = $db->prepare('SELECT * FROM day WHERE user_id = ?');
$saveDataDay->execute(array($_SESSION['userId']));
$saveDay = $saveDataDay->fetch();
// 祝日名呼び出し
$saveDataHolidayName = $db->prepare('SELECT * FROM holidayName WHERE user_id = ?');
$saveDataHolidayName->execute(array($_SESSION['userId']));
$saveHolidayName = $saveDataHolidayName->fetch();
?>
