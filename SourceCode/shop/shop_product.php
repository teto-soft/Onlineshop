<?php
require_once('../common/common.php');
//check the login status of member
checkLoginMember();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>商品詳細</title>
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

    //商品コードから商品情報を取得
    $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$pro_code;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    //取り出したデータを変数に代入
    $pro_name=$rec['name'];
    $pro_price=$rec['price'];
    $pro_gazou_name=$rec['gazou'];

    //DB切断
    $dbh = null;

    //画像ファイルの有無を確認
    if ($pro_gazou_name=='') {
        $disp_gazou='';
    } else {
        $disp_gazou='<img src="../../gazou/'.$pro_gazou_name.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    商品詳細 <br>
    <br>
    商品コード：<?php print $pro_code; ?>
    <br>
    商品名：<?php print $pro_name; ?>
    <br>
    価格：<?php print $pro_price; ?>円
    <br>
    <?php print $disp_gazou; ?>
    <?php print'<br><a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる<a><br>'; ?>
    <br>
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>

</body>

</html>