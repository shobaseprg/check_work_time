<?php
// 祝日を取得↓ ------------------------
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
if ($date = file_get_contents($url.http_build_query($query), true)) {
  // $queryをクエリ化してURLに結合する。
    $date = json_decode($date);
}
/// 祝日を取得↑------------------------
?>