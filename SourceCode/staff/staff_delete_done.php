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
    <title>スタッフ削除実行</title>
</head>

<body>


    <?php
try {
    $post = e($_POST);
    $staff_code = $post['code'];

    //DB接続
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //スタッフコードから該当レコードを削除
    $sql='DELETE FROM mst_staff WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$staff_code;
    $stmt->execute($data);

    //DB切断
    $dbh=null;
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

    削除しました。<br>
    <br>
    <a href="staff_list.php">戻る</a>

</body>

</html>