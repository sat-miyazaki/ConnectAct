<?php
function getDB() {
  try {
    $sql = new PDO('mysql:host=localhost;dbname=connectact;charset=utf8mb4;unix_socket=/tmp/mysql.sock', 'root', 'sunburst1121');
  } catch ( PDOException $e ) {
    print "接続エラー:{$e->getMessage()}";
    $sql = null;
  }
  return $sql;
}
?>
