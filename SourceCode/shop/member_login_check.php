<?php
require_once('../common/common.php');

try {
    //escape
    $post=e($_POST);
    $member_email=$post['email'];
    $member_pass=$post['pass'];

    //DB接続
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //SQL実行
    $sql='SELECT code, name, password FROM dat_member WHERE email=?';
    $stmt=$dbh->prepare($sql);
    $data=array();
    $data[]=$member_email;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    //DB切断
    $dbh=null;

    //メールアドレスが存在しない場合
    if($rec==false){
        print'メールアドレスかパスワードが正しくありません。<br>';
        print'<a href="member_login.html">戻る</a>';
        exit();
    }

    if (!password_verify($member_pass, $rec['password'])) {
        //メールアドレスとパスワードが一致しない場合
        print'メールアドレスかパスワードが正しくありません。<br>';
        print'<a href="member_login.html">戻る</a>';
    } else {
        //メールアドレスとパスワードが一致する場合
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
