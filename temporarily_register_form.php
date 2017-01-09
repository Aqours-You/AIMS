<?php
  /**
  * Filename:temporarily_register_form.php
  * Version:PHP5.6.2
  * Create Date:2016/12/31
  * Author:y.shirahama
  **/

  //セッション開始
  session_start();
  //Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
  header("Content-type: text/html; charset=utf-8");

  //クロスサイトリクエストフォージェリ（CSRF）対策
  $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
  $token = $_SESSION['token'];

  //クリックジャッキング対策
  header('X-FRAME-OPTIONS: SAMEORIGIN');

?>

<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>勤怠管理システム-仮登録-</title>
    <link rel="stylesheet" href="./css/header-style.css">
    <link rel="stylesheet" href="./css/footer-style.css">
    <link rel="stylesheet" href="./css/temporarily_register_form.css">
    <link rel="stylesheet" href="./css/pwdMeasure-style.css">
    <!-- Bootstrap読み込み（スタイリングのため） -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/jquery.pwdMeasure.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#password").pwdMeasure();
      });
    </script>
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
      <!-- エラーメッセージ -->
      <?php
        if(isset($_SESSION['err_info']) && is_array($_SESSION['err_info'])) {
          $errors = $_SESSION['err_info'];
          echo "<div class=" . "'alert alert-danger'" . "role=" . "'alert'>";
          foreach($errors as $result) {
            echo "<span class=" . "'glyphicon glyphicon-exclamation-sign'" . "aria-hidden=" . "'true'></span>" . $result . "<br>";
          }
          //セッションを破棄する
          session_destroy();
        }
      ?>
    </div>
      <div id="page_content">
        <div id="register_page_content">
          <img class="top_logo" src="./img/長波サマ.jpg"></img>
          <div class="register_container_wrapper">
            <div class="register_form_container">
              <div class="register_form">
                <form method="POST" action="temporarily_register_check.php">
                  <div class="clearfix">
                    <div class="login_register_header">アカウントの作成</div>
                    <div class="login_register_switch">または<a href="./login.php">ログイン</a></div>
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
                    <input type="password" class="form-control" id="password" name="password" placeholder="パスワード"/>
                  </div>
                  <div class="form-group">
                    <div id="pm-indicator"></div>
                  </div>
                  <div class="form-group">
                    <div class="pull-right">
                      <input type="hidden" name="token" value="<?=$token?>">
                      <lavel><button type="submit" class="btn btn-primary" name="signup">アカウントの作成</button></lavel>
                    </div>
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
