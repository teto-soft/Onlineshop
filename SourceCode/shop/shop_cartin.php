<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
if (isset($_SESSION['member_login'])==false) {
    //ログインの証拠がない場合
    print'オンラインショップへようこそ<br>';
    print'<a href="member_login.html">会員ログイン<a><br><br>';
//exit();
} else {
    print'ようこそ';
    print $_SESSION['member_name'];
    print'様<br><br>';
    print'<a href="member_logout.html">ログアウト<a><br>';
    print'<br>';
}
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
    $pro_code=$_GET['procode'];
    
    if (isset($_SESSION['cart'])==true) {
        //変数がセットされているかの確認
        $cart=$_SESSION['cart'];
        $kazu=$_SESSION['kazu'];
        //すでに入っている商品かを確認
        if (in_array($pro_code, $cart)==true) {
            print'その商品はすでにカートに入っています。<br>';
            print'<a href="shop_list.php">商品一覧</a>';
            exit();
        }
    }
    $cart[]=$pro_code; //商品をカートに入れる。
    $kazu[]=1; //数量1を入れる。
    $_SESSION['cart']=$cart; //カートの中身をSESSIONに保管する。
    $_SESSION['kazu']=$kazu; //カート内の商品数をSESSIONに保管する。
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