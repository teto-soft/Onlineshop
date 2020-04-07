<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
if (isset($_SESSION['login'])==false) {
    //ログインの証拠がない場合
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
    <title>商品修正フォーム</title>
</head>

<body>

    <?php
try {
    $pro_code=$_GET['procode'];

    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //商品コードからデータを取得
    $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$pro_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $pro_name=$rec['name'];
    $pro_price=$rec['price'];
    $pro_gazou_name_old=$rec['gazou'];

    //DB切断
    $dbh = null;

    //画像ファイルの有無を振り分け
    if ($pro_gazou_name_old=='') {
        $disp_gazou='';
    } else {
        $disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'">';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    商品修正 <br>
    <br>
    商品コード<br>
    <?php print $pro_code; ?>
    <br><br>

    <form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
        <input type="hidden" name="code"
            value="<?php print $pro_code; ?>">
        <input type="hidden" name="gazou_name_old"
            value="<?php print $pro_gazou_name_old; ?>">
        商品名<br>
        <input type="text" name="name" style="width:200px"
            value="<?php print $pro_name; ?>"><br>
        価格<br>
        <input type="text" name="price" style="width:50px"
            value="<?php print $pro_price; ?>">円<br>
        <br>
        <php print $disp_gazou; ?>
            <br>
            画像を選んでください。<br>
            <input type="file" name="gazou" style="width:400px"><br>
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="ＯＫ">
    </form>

</body>

</html>