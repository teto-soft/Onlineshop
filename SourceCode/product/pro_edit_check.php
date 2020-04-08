<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
//ログインの証拠がない場合
if (isset($_SESSION['login'])==false) {
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
    <title>商品修正チェック</title>
</head>

<body>

    <?php
require_once('../common/common.php');
    
$post=sanitize($_POST);
$pro_code=$post['code'];
$pro_name=$post['name'];
$pro_price=$post['price'];
$pro_gazou_name_old=$post['gazou_name_old'];
$pro_gazou=$_FILES['gazou'];

if ($pro_name=='') {
    print'商品名が入力されていません。 <br />' ;
} else {
    print'商品名：';
    print $pro_name;
    print'<br />';
}
//もし半角数字じゃなかったら
if (preg_match('/\A[0-9]+\z/', $pro_price)==0) {
    print'価格を半角数字で入力してください。<br>';
} else {
    print'価格：';
    print $pro_price;
    print'円<br />';
}

//画像が入力されているかの確認
if ($pro_gazou['size']>0) {
    //画像サイズの大きさ制限
    if ($pro_gazou['size']>1000000) {
        print'画像のサイズが大きすぎます。';
    } else {
        move_uploaded_file($pro_gazou['tmp_name'], './gazou/'.$pro_gazou['name']);
        print'<img src="./gazou/'.$pro_gazou['name'].'">';
        print'<br>';
    }
}

//ランダムなバイナリを生成し、16進数に変換することでASCII文字列に変換
$toke_byte = openssl_random_pseudo_bytes(16);
$csrf_token = bin2hex($toke_byte);

// 生成したトークンをセッションに保存
$_SESSION['csrf_token'] = $csrf_token;

if ($pro_name==''||preg_match('/\A[0-9]+\z/', $pro_price)==0||$pro_gazou['size']>1000000) {
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    print '上記のように変更します。<br />';
    print '<form method="post" action="pro_edit_done.php">';
    print '<input type="hidden" name="code" value="'.$pro_code.'">';
    print '<input type="hidden" name="name" value="'.$pro_name.'">';
    print '<input type="hidden" name="price" value="'.$pro_price.'">';
    print '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
    print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
    print '<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">';
    print '<br />';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="ＯＫ">';
    print '</form>';
}

?>

</body>

</html>