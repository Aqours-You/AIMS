<?php
/**
 * Filename:db_config.php
 * Version:PHP5.6.2
 * Create Date:2016/12/31
 * Author:Aqours-you
**/
?>
<?php
  /* データベース接続情報(MySQL) */
  $dsn = 'mysql:dbname=attendance_mng;host:localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $driver_options = [
                      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                  ];
  //print_r($driver_option);
?>
