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
    <title>スタッフ修正フォーム</title>
</head>

<body>

    <?php

try {
    require_once('../common/common.php');
    $staff_code=sanitize($_GET['staffcode']);

    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //スタッフコードからスタッフ名を取得
    $sql = 'SELECT name FROM mst_staff WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$staff_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name=$rec['name'];

    //DB切断
    $dbh = null;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    スタッフ修正<br>
    <br>
    スタッフコード<br>
    <?php print $staff_code; ?>

    <br><br>
    <form method="post" action="staff_edit_check.php">
        <input type="hidden" name="code"
            value="<?php print $staff_code; ?>">
        スタッフ名<br>
        <input type="text" name="name" style="width:200px"
            value="<?php print $staff_name; ?>"><br>
        パスワードを入力してください。<br>
        <input type="password" name="pass" style="width:100px"><br>
        パスワードをもう1度入力してください。<br>
        <input type="password" name="pass2" style="width:100px"><br>
        <br>

        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>

</body>

</html>