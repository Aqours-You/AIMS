<?php
/**
* Filename:login.php
* Version:PHP5.6.2
* Create Date:2016/12/31
* Author:Aqours-you
**/
?>

<?php

?>

<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>勤怠管理システム-ログイン-</title>
    <link rel="stylesheet" href="./css/header-style.css">
    <link rel="stylesheet" href="./css/footer-style.css">
    <link rel="stylesheet" href="./css/login-style.css">
    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  </head>
  <body>
    <!--　ページヘッダー -->
    <div id="page_header" class="page_header_border">
      <div id="inner_page_header">
        <span class="home_icon_container">
          <div id="icon">
            <a href="./login.php"><img  width="36" src="./img/長波サマ.jpg"></a>
          </span>
          <div id="header_item">
            <a class="header_info_item" href = "https://www.google.co.jp/">アプリのダウンロード</a>
          </div>
          </div>
        </span>
      </div>
    </div>

    <!-- ページコンテンツ -->
    <div class="outer_frame">
      <div id="page_content">
        <div id="login_page_content">
          <img class="top_logo" src="./img/長波サマ.jpg"></img>
          <div class="login_container_wrapper">
            <div class="login_form_container">
              <div class="login_form">
                <form method="POST">
                  <div class="clearfix">
                    <div class="login_register_header">ログイン</div>
                    <div class="login_register_switch">または<a href="./temporarily_register_form.php">アカウントの作成</a></div>
                  </div>
                  <div class="input-group form-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-envelope"></i>
                   </span>
                   <input type="email"  class="form-control" name="email" placeholder="メールアドレス"/>
                  </div>
                  <div class="input-group form-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" placeholder="パスワード"/>
                  </div>
                  <div class="form-group">
                    <lavel><input type="checkbox">&nbsp;次回から入力を省略</lavel>
                    <div class="pull-right">
                      <lavel><button type="submit" class="btn btn-primary" name="login">ログイン</button></lavel>
                    </div>
                  </div>
                  <div class="login_need_pass">
                    <a href="./">パスワードを忘れてしまった場合</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ページフッター -->
    <div class="footer">copy left everything free.</div>
  </body>
</html>
