<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
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
    //DBへの接続
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
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>
    
    商品一覧<br><br>

    <form method="post" action="pro_branch.php">
        <?php
        //商品一覧を箇条書きで表示
    while (true) {
        $rec=$stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec==false) {
            break;
        }
        //商品コードを渡す
        print '<input type="radio" name="procode" value="'.$rec['code'].'">';
        print $rec['name'].'---';
        print $rec['price'].'円<br>';
    }
    //measures for csrf/form
    csrfForm();
    ?>
        <!-- 操作ボタンによる分岐 -->
        <input type="submit" name="disp" value="参照">
        <input type="submit" name="add" value="追加">
        <input type="submit" name="edit" value="修正">
        <input type="submit" name="delete" value="削除">
    </form><br>

    <a href="../staff_login/staff_top.php">トップメニュー</a><br>

</body>

</html>