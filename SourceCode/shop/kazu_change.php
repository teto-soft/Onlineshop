<?php
session_start();
session_regenerate_id(true);

require_once('C:/xampp/htdocs/common/common.php');

//サニタイジング
$post=sanitize($_POST);

//商品の種類数を代入
$max=$post['max'];

for ($i=0; $i < $max; $i++) {
    if (preg_match("/\A[0-9]+\z/", $post['kazu'.$i])==0) {
        print'個数に入力できるのは半角数字のみです。<br>';
        print'<a href="shop_cartlook.php">カートに戻る</a>';
        exit();
    }
    if ($post['kazu'.$i]<1 || 100<=$post['kazu'.$i]) {
        print'個数に入力できるのは1~100個です。<br><br>';
        print'<a href="shop_cartlook.php">カートに戻る</a>';
        exit();
    }
    //入力された個数を代入
    $kazu[]=$post['kazu'.$i];
}

//カート内の商品をセッションに保管
$cart=$_SESSION['cart'];

for ($i=$max; 0<=$i; $i--) {
    //商品の種類数だけループ
    if (isset($post['sakujo'.$i])==true) {
        //チェックされた商品と個数を削除
        array_splice($cart, $i, 1);
        array_splice($kazu, $i, 1);
    }
}

$_SESSION['cart']=$cart;
$_SESSION['kazu']=$kazu;

header('Location: shop_cartlook.php');
exit();
