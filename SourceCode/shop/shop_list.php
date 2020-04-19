<?php
require_once('../common/common.php');
//check the login status of member
checkLoginMember();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>商品一覧</title>
</head>

<body>

    <?php
try {
    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL実行
    $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
    $stmt=$dbh->prepare($sql);
    $stmt->execute(); //プリペアードステートメント

    //DB切断
    $dbh = null;

    //画面表示の部分
    print '商品一覧<br><br>';

    while (true) {
        $rec=$stmt->fetch(PDO::FETCH_ASSOC);
        //該当するデータがない場合ループを抜ける。
        if ($rec==false) {
            break;
        }
        //商品コードを渡す
        print '<a href="shop_product.php?procode='.$rec['code'].'">';
        print $rec['name'].'---';
        print $rec['price'].'円';
        print '</a><br>';
    }
    print'<br><br>';
    print'<a href="shop_cartlook.php">カートを見る<a><br>';
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

</body>

</html>