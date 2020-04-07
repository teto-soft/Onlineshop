<?php
require_once('C:/xampp/htdocs/common/common.php');

try {
    //サニタイジング
    $post=sanitize($_POST);

    $member_email=$_POST['email'];
    $member_pass=$_POST['pass'];
    
    //パスワードの暗号化
    $member_pass=md5($member_pass);

    //DB接続
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //SQL実行
    $sql='SELECT code, name FROM dat_member WHERE email=? AND password=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$member_email;
    $data[]=$member_pass;
    $stmt->execute($data);

    //DB切断
    $dbh=null;

    //$stmtから1レコード取り出す。
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rec==false) {
        //メールアドレスとパスワードが一致しない場合
        print'メールアドレスかパスワードが間違っています<br />';
        print'<a href="member_login.html">戻る</a>';
    } else {
        //メールアドレスとパスワードが一致する場合、セッションに保管する。
        session_start();
        $_SESSION['member_login']=1;
        $_SESSION['member_code']=$rec['code'];
        $_SESSION['member_name']=$rec['name'];
        header('Location: shop_list.php');
    }
    exit();
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
