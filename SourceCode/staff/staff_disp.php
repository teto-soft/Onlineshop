<?php
require_once('../common/common.php');
//check the login status of staff
 checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>スタッフ情報参照</title>
</head>

<body>

    <?php

try {
    $get = e($_GET);
    $staff_code=$get['staffcode'];

    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //スタッフコードからスタッフの名前を取得
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

    スタッフ情報参照 <br>
    <br>
    スタッフコード：
    <?php print $staff_code; ?>
    <br>
    スタッフ名：
    <?php print $staff_name; ?>
    <br><br>

    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>

</body>

</html>