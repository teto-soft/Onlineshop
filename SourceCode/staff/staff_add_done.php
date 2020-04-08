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
    <title>スタッフ追加実行</title>
</head>

<body>

    <?php
try {
    $staff_name = $_POST['name'];
    $staff_pass = $_POST['pass'];

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
    print'スタッフコードは'.$lastcode.'です。<br>';
    print'ログインするときに使用するのでメモしておいてください。<br><br>';
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

    <a href="staff_list.php">戻る</a>

</body>

</html>