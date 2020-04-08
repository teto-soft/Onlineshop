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
    <title>商品削除実行</title>
</head>

<body>

    <?php
try { 
    require_once('../common/common.php');

    $post=sanitize($_POST);
    $pro_code = $post['code'];
    $pro_gazou_name = $post['gazou_name'];

    //DBへの接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL実行
    $sql = 'DELETE FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[] = $pro_code;
    $stmt->execute($data);

    //DB切断
    $dbh = null;

    if ($pro_gazou_name !='') {
        unlink('./gazou/'.$pro_gazou_name);
    }
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

    削除しました。<br>
    <br>
    <a href="pro_list.php">戻る</a>

</body>

</html>