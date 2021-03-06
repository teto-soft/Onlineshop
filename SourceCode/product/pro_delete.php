<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>商品削除確認</title>
</head>

<body>

    <?php

try {
    //escape
    $get=e($_GET);
    $pro_code=$get['procode'];

    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //商品コードから商品の名前と画像を取得
    $sql = 'SELECT name,gazou FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$pro_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $pro_name=$rec['name'];
    $pro_gazou_name=$rec['gazou'];

    //DB切断
    $dbh = null;

    if ($pro_gazou_name=='') {
        $disp_gazou='';
    } else {
        $disp_gazou='<img src="./gazou/'.$pro_gazou_name.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    商品削除 <br>
    <br>
    商品コード：<?php print $pro_code; ?>
    <br>
    商品名：<?php print $pro_name;?>
    <br>
    <?php print $disp_gazou;?>
    <br>
    この商品を削除してもよろしいですか？<br>
    <br><br>
    <form method="post" action="pro_delete_done.php">
        <input type="hidden" name="code"
            value="<?php print $pro_code; ?>">
        <input type="hidden" name="gazou_name"
            value="<?php print $pro_gazou_name; ?>">
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="ＯＫ">
        <!-- measures for csrf/form -->
        <?php csrfForm(); ?>
    </form>

</body>

</html>