<?php
//ログイン状態の確認
session_start();
session_regenerate_id(true); //毎回合言葉を変える
if (isset($_SESSION['member_login'])==false) {//ログインの証拠がない場合
    print'オンラインショップへようこそ<br>';
    print'<a href="../shop/member_login.html">会員ログイン<a><br><br>';
//exit();
} else {//ログインの証拠がある場合
    print'ようこそ';
    print $_SESSION['member_name'];
    print'様ログイン中 ';
    print'<a href="member_logout.php">ログアウト</a><br><br>';
}
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

    //画面表示の部分
    print '商品一覧<br><br>';

    while (true) {
        $rec=$stmt->fetch(PDO::FETCH_ASSOC); //$stmtから1つ取り出す
        if ($rec==false) {
            //該当するデータがない場合ループを抜ける。
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