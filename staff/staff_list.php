<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
//ログインの証拠がない場合
if (isset($_SESSION['login'])==false) {
    print'ログインされていません。<br>';
    print'<a href="../staff_login/staff_login.html">ログイン画面へ<a>';
    exit();
} else {
    print $_SESSION['staff_name'];
    print'さんログイン中<br><br>';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>スタッフ一覧</title>
</head>

<body>

    <?php
try {
    //DBへの接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL実行
    $sql = 'SELECT code,name FROM mst_staff WHERE 1';
    $stmt=$dbh->prepare($sql);
    $stmt->execute(); //プリペアードステートメント

    //DB切断
    $dbh = null;

    print 'スタッフ一覧<br><br>';
    //修正画面
    print '<form method="post" action="staff_branch.php">';

    while (true) {
        $rec=$stmt->fetch(PDO::FETCH_ASSOC); //$stmtから一つずつ取り出す
        if ($rec==false) {
            break;
        }
        //スタッフコードを渡す
        print '<input type="radio" name="staffcode" value="'.$rec['code'].'">';
        print $rec['name'];
        print '<br>';
    }
    print '<input type="submit" name="disp" value="参照">';
    print '<input type="submit" name="add" value="追加">';
    print '<input type="submit" name="edit" value="修正">';
    print '<input type="submit" name="delete" value="削除">';
    print '</form>';
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

    <br>
    <a href="../staff_login/staff_top.php">トップメニュー</a><br>

</body>

</html>