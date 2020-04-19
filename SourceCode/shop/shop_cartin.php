<?php
require_once('../common/common.php');
//check the login status of member
checkLoginMember();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>カートに入れる</title>
</head>

<body>

    <?php
try {
    //escape
    $get = e($_GET);
    $pro_code=$get['procode'];
    
    //変数の有無を確認
    if (isset($_SESSION['cart'])==true) {
        $cart=$_SESSION['cart'];
        $kazu=$_SESSION['kazu'];
        //すでに入っている商品かを確認
        if (in_array($pro_code, $cart)==true) {
            print'その商品はすでにカートに入っています。<br>';
            print'<a href="shop_list.php">商品一覧</a>';
            exit();
        }
    }

    //商品と数量1を入れてセッションに保管
    $cart[]=$pro_code;
    $kazu[]=1;
    $_SESSION['cart']=$cart;
    $_SESSION['kazu']=$kazu;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    カートに追加しました。<br>
    <br>
    <a href="shop_list.php">商品一覧</a>

</body>

</html>