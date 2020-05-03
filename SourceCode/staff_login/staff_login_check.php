<?php
require_once('../common/common.php');

try { 
    //escape
    $post = e($_POST);
    $staff_code=$post['code'];
    $staff_pass=$post['pass'];
  
    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //入力されたスタッフコードに該当するスタッフを取得
    $sql = 'SELECT name, password FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[]=$staff_code;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    //DB切断
    $dbh = null;

    if (!password_verify($staff_pass, $rec['password'])) {
        print'スタッフコードかパスワードが正しくありません。<br><br>';
        print'<a href="staff_login.html">戻る</a>';
    } else {
        session_start();
        $_SESSION['login']=1;
        $_SESSION['staff_code']=$staff_code;
        $_SESSION['staff_name']=$rec['name'];
        header('Location: staff_top.php');
        //header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/file1.php');
    }
    exit();
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
