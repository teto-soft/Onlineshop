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
    <title>スタッフ修正実行</title>
</head>

<body>

    <?php
try {
    //escape
    $post=e($_POST);
    $staff_code = $post['code'];
    $staff_name = $post['name'];
    $staff_pass = $post['pass'];

    //DBへの接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL実行
    $sql = 'UPDATE mst_staff SET name=?, password=? WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[] = $staff_name;
    $data[] = password_hash($staff_pass, PASSWORD_BCRYPT);
    $data[] = $staff_code;
    $stmt->execute($data); //プリペアードステートメント

    //DB切断
    $dbh = null;
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

    スタッフ情報を修正しました。<br>
    <br>
    <a href="staff_list.php">戻る</a>

</body>

</html>