<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginMember();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>カート内容</title>
</head>

<body>

    <?php
try {
    if (isset($_SESSION['cart'])==true) {
        //カート内に商品が存在するときのみ実行
        $cart=$_SESSION['cart'];
        $kazu=$_SESSION['kazu'];
        $max=count($cart); //カートの商品の種類数
    } else {
        $max=0; //エラーを出さないために0を代入する。
    }

    if ($max==0) {
        print'カートに商品が入っていません。<br><br>';
        print'<a href="shop_list.php">商品一覧へ戻る</a>';
        exit();
    }

    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //商品コードから商品情報を取得する。
    foreach ($cart as $key => $val) {
        //カートの中の商品の数だけ繰り返す。
        $sql='SELECT code, name, price, gazou FROM mst_product WHERE code=?';
        $stmt=$dbh->prepare($sql);
        $data[0]=$val; //ループを回すたびに配列が増えないよう0を指定している。
        $stmt->execute($data);
        $rec=$stmt->fetch(PDO::FETCH_ASSOC);

        //取り出したデータを変数に代入
        $pro_name[]=$rec['name'];
        $pro_price[]=$rec['price'];
        if ($rec['gazou']=='') {
            $pro_gazou[]='';
        } else {
            $pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
        }
    }

    //DB切断
    $dbh=null;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    カートの中身<br>
    <br>
    <form method="post" action="kazu_change.php">
        <!--カート内の商品情報をテーブルにして表示-->
        <table border="1">
            <tr>
                <td>商品</td>
                <td>商品画像</td>
                <td>価格</td>
                <td>数量</td>
                <td>小計</td>
                <td>削除</td>
            </tr>
            <?php for ($i=0; $i < $max; $i++) {
    ?>
            <tr>
                <td><?php print $pro_name[$i]; ?>
                </td>
                <td><?php print $pro_gazou[$i]; ?>
                </td>
                <td><?php print $pro_price[$i]; ?>円</td>
                <td><input type="text" name="kazu<?php print $i; ?>"
                        value="<?php print $kazu[$i]; ?>" size="1px">
                </td>
                <!-- kazu0, kazu1を生成 -->
                <td><?php print $pro_price[$i] * $kazu[$i]; ?>円</td>
                <td><input type="checkbox"
                        name="sakujo<?php print $i; ?>"></td>
            </tr>
            <?php
}
    ?>
        </table>
        <input type="hidden" name="max" value="<?php print $max; ?>">
        <input type="submit" value="数量変更"> チェックを入れて[数量変更]ボタンを押すとカートから削除できます。<br><br>
        <input type="button" onclick="history.back()" value="商品一覧へ戻る">
        <!--measures against csrf/form -->
        <?php csrfForm(); ?>
    </form>
    <br>

    <?php
    if (isset($_SESSION["member_login"])==true) {
        print'<a href="shop_kantan_check.php">ご購入手続きへ進む</a><br>';
    } else {
        print'<a href="shop_form.php">ご購入手続きへ進む</a><br>';
    }
    ?>

</body>

</html>