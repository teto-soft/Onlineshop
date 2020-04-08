<?php
try {        
    $staff_code=$_POST['code'];
    $staff_pass=$_POST['pass'];
  
    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //入力されたコードに該当するデータを取得
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
        //セッションを確認する
        session_start();
        $_SESSION['login']=1;
        $_SESSION['staff_code']=$staff_code;
        $_SESSION['staff_name']=$rec['name'];
        header('Location: staff_top.php');
    }
    exit();
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
