<?php
try {
  $db = new PDO('mysql:dbname=checkWorkTime; host=localhost; port=8889;charset=utf8','root','root');
} catch (PDOException $e) {
  print('DB接続エラー:'. $e->getMessage());
}

// try {
//   $db = new PDO('mysql:dbname=checkWorkTime; host=database-1.ctota27wia3w.ap-northeast-1.rds.amazonaws.com; port=3306;charset=utf8','root','ueponzu88');
// } catch (PDOException $e) {
//   print('DB接続エラー:'. $e->getMessage());
// }


?>