<?php
/**
 * Filename:db_connect.php
 * Version:PHP5.6.2
 * Create Date:2016/12/31
 * Author:Aqours-you
**/
?>

<?php

  try {
    //データベース接続情報呼び出し
    require_once('db_config.php');

    //データベース接続
    $pdo = new PDO($dsn, $user, $password, $driver_options);

  } catch (PDOException $e) {
    //エラーが発生した場合は、「500 Internal Server Error」でテキストとして表示して終了する
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
  }

  //Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
  header('Content-Type: text/html; charset=utf-8');
?>
