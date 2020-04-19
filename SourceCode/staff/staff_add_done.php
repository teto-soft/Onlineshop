<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
//measures for csrf/check
csrfCheck();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>スタッフ追加実行</title>
</head>

<body>

    <?php
try {
    //escape
    $post = e($_POST);
    $staff_name = $post['name'];
    $staff_pass = $post['pass'];

    //DBへの接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //スタッフ名とパスワードを登録
    $sql = 'INSERT INTO mst_staff (name, password) VALUES (?,?)';
    $stmt=$dbh->prepare($sql);
    $data[] = $staff_name;
    $data[] = password_hash($staff_pass, PASSWORD_BCRYPT);
    $stmt->execute($data); //プリペアードステートメント

    //先ほど追加した注文コードを取得して$lastcodeに代入する。
    $sql='SELECT LAST_INSERT_ID()';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode=$rec['LAST_INSERT_ID()'];

    //DB切断
    $dbh = null;

    print $staff_name;
    print'さんを追加しました。<br>';
    print'次回からスタッフコードとパスワードを使ってログインできます。<br><br>';
    print'スタッフコードは '.$lastcode.' です。<br><br>';
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

    <a href="staff_list.php">戻る</a>

</body>

</html>