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
    <title>商品追加チェック</title>
</head>

<body>

    <?php
require_once('C:/xampp/htdocs/common/common.php');

//サニタイジング
$post=sanitize($_POST);
$pro_name=$post['name'];
$pro_price=$post['price'];

$pro_gazou=$_FILES['gazou'];

if ($pro_name=='') {
    print'商品名が入力されていません。<br><br>' ;
} else {
    print'商品名：';
    print $pro_name;
    print'<br>';
}

if (preg_match('/\A[0-9]+\z/', $pro_price)==0) {
    //価格に半角数字以外が入力された場合
    print'価格を半角数字で入力してください。<br><br>';
} else {
    print'価格：';
    print $pro_price;
    print'円<br>';
}

if ($pro_gazou['size']>0) {
    //画像が入力されているかの確認
    if ($pro_gazou['size']>1000000) {
        //画像サイズの大きさ制限
        print'画像のサイズが大きすぎます。<br><br>';
    } else {
        move_uploaded_file($pro_gazou['tmp_name'], './gazou/'.$pro_gazou['name']);
        print'<img src="./gazou/'.$pro_gazou['name'].'">';
        print'<br>';
    }
}

if ($pro_name==''||preg_match('/\A[0-9]+\z/', $pro_price)==0||$pro_gazou['size']>1000000) {
    //入力ミスがある場合
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    print '上記の商品を追加します。<br />';
    print '<form method="post" action="pro_add_done.php">';
    print '<input type="hidden" name="name" value="'.$pro_name.'">';
    print '<input type="hidden" name="price" value="'.$pro_price.'">';
    print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
    print '<br>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="ＯＫ">';
    print '</form>';
}

?>

</body>

</html>