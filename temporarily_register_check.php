<?php
  /**
  * Filename:temporarily_register_check.php
  * Version:PHP5.6.2
  * Create Date:2016/12/31
  * Author:y.shirahama
  **/

  //セッション開始
  session_start();

  //Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
  header("Content-type: text/html; charset=utf-8");

  //クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
  if ($_POST['token'] != $_SESSION['token']) {
    echo "不正アクセスの可能性があります。";
    exit();
  }

  //クリックジャッキング対策
  header('X-FRAME-OPTIONS: SAMEORIGIN');

  //データベースとの接続
  include_once './common/db_connect.php';

  //エラーメッセージの初期化
  $errormsg = array();

  //「アカウントの作成」がPOSTされた時に仮登録処理を行う。
  if (isset($_POST['signup'])) {
    //POSTされたデータを変数に格納する
    $email = $_POST['email'];
    $password = $_POST['password'];

    /**
     * メールアドレスの入力チェック
     * 1.空チェック
     * 2.形式チェック
     * 3.重複チェック
     */

    if (empty($email) || !is_string($email)) {
      array_push($errormsg, 'メールアドレスが入力されていません。');
    } else if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
      array_push($errormsg, 'メールアドレスの形式が正しくありません。');
    }

    //入力したメールアドレスの登録件数を取得
    //$email_chk_query = 'SELECT COUNT(*) as mail_chk FROM pre_member WHERE mail = :mail';
    //$chk_stmt = $pdo->prepare($email_chk_query);
    //バインド
    //$chk_stmt->bindParam(':mail', $email, PDO::PARAM_STR);
    //$chk_stmt->execute();

    //SQL実行結果を取得
    //while ($row = $chk_stmt->fetch(PDO::FETCH_ASSOC)) {
      //$result = $row['mail_chk'];
    //}

    //if ($result > 0) {
      //array_push($errormsg, $email . 'は既に登録されているメールアドレスです。');
    //}

    /**
     * パスワードの入力チェック
     * 1. 空チェック
     * 2. 文字数チェック(8文字以上・64文字以内)
     * 3. 入力文字チェック(半角英数字)
     * 4. パスワード一致チェック
     */
    if (empty($password) || !is_string($password)) {
      array_push($errormsg, 'パスワードが入力されていません。');
    } else if ((strlen($password) < 8) || (strlen($password) > 64)) {
      array_push($errormsg, 'パスワードは8文字以上64文字以内で入力して下さい。');
    } else if (!preg_match("/^[A-Za-z0-9]{8,64}$/", $password)) {
      array_push($errormsg, 'パスワードの入力値が不正です。');
    }

  }

  if (count($errormsg) === 0) {
    //URLトークンを生成
    $urltoken = hash('sha256', uniqid(rand(), 1));
    $url = "http://192.168.3.2:8888/EEMS/register_form.php" . "?urltoken=" . $urltoken;

    //データベースへの登録処理を行う
    try {
      //INSERT文の生成
      $query = 'INSERT INTO pre_member(urltoken, mail, password, r_date) VALUES (:urltoken, :mail, :password, now())';
      $stmt = $pdo->prepare($query);
      //プレースホルダへ入力値をバインドする
      $stmt->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
      $stmt->bindParam(':mail', $email, PDO::PARAM_STR);
      $stmt->bindParam(':password', $password, PDO::PARAM_STR);
      //SQL実行
      $stmt->execute();

      //データベース接続の切断
      $pdo = null;

    } catch (PDOException $e) {
      print('Error:' . $e->getMessage());
      die();
    }

    //送信完了メッセージの初期化
    $message = array();

    //メール送信宛先
    $mailTo = $email;

    //Return-Pathに指定するメールアドレス
    $returnMail = 'sys.test.adm1n@gmail.com';

    $name = 'システム管理者';
    $mail = 'sys.test.adm1n@gmail.com';
    $subject = '【勤怠管理システム】会員登録用URLのお知らせ';

    //メールアドレスのローカル部分(@前)の文字列を取得
    $local = strstr($mailTo, "@", TRUE);

    //テンプレートからメール本文を読み込む
    ob_start();
    require_once './tpl/mail_template.tpl';
    $body = ob_get_contents();
    ob_end_clean();

    //本文への文字列置き換え
    $body = str_replace("%name", $local, $body);
    $body = str_replace("%mail", $email, $body);
    $body = str_replace("%url", $url, $body);

    $mailbody = mb_convert_encoding($body, "iso-2022-jp", "UTF-8");

    mb_language('ja');
    mb_internal_encoding('UTF-8');

    //Fromヘッダーの作成
    $header = 'From:' . mb_encode_mimeheader($name) . '<' . $mail . '>';
    if (mb_send_mail($mailTo, $subject, $mailbody, $header, '-f' . $returnMail)) {
      //セッションを全て解除する
      $_SESSION = array();

      //Cookieの削除
      if (!empty($_COOKIE["PHPSESSID"])) {
        setcookie("PHPSESSID", '', time() - 1800, '/');
      }

      //セッションを破棄する
      session_destroy();

    } else {
      array_push($errormsg, 'メール送信に失敗しました。');
      $_SESSION['err_info'] = $errormsg;
      header("Location:temporarily_register_form.php");
    }
  //バリデーションエラーが存在する場合
  } else {
    $_SESSION['err_info'] = $errormsg;
    header("Location:temporarily_register_form.php");
  }

?>

<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>勤怠管理システム-仮登録(完了)-</title>
    <link rel="stylesheet" href="./css/header-style.css">
    <link rel="stylesheet" href="./css/footer-style.css">
    <link rel="stylesheet" href="./css/temporarily_register_check.css">
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
        <div id="check_comp_content">
          <img class="top_logo" src="./img/長波サマ.jpg"></img>
          <div class="check_comp_container_wrapper">
            <div class="check_comp_form_container">
              <div id="check_comp_form">
                <div class="check_comp_header">
                  <h2>仮登録が完了いたしました。</h2>
                </div>
                <div class="check_comp_description">
                  <h4 style="line-height:30px;">入力いただいたメールアドレスに<br>
                    勤怠管理システム本登録へのご案内メールが届きます。<br>
                    受信メールの本文から本登録を行ってください。</h4>
                </div>
                <div class="check_comp_caution">
                  <h5><font color="red">"会員登録用URLのお知らせ"</font>が届かない場合は、メールアドレスが間違っているか、迷惑メール等に届いている可能性があります。</h5>
                </div>
                <div class="form-group">
                  <div class="pull-right">
                    <a href="./login.php" class="btn btn-primary" style="margin-top:20px;">ログイン画面へ</a>
                  </div>
                </div>
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
