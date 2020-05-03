<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>商品修正チェック</title>
</head>

<body>

    <?php
//escape
$post=e($_POST);
$pro_code=$post['code'];
$pro_name=$post['name'];
$pro_price=$post['price'];
$pro_gazou_name_old=$post['gazou_name_old'];
$pro_gazou=$_FILES['gazou'];

//商品名の入力確認
if ($pro_name=='') {
    print'商品名が入力されていません。 <br />' ;
} else {
    print'商品名：'.$pro_name.'<br>';
}

//価格の入力確認
if (preg_match('/\A[0-9]+\z/', $pro_price)==0) {
    //半角数字以外が入力された場合
    print'価格を半角数字で入力してください。<br>';
} else {
    print'価格：'.$pro_price.'円<br>';
}

//画像の入力確認
if ($pro_gazou['size']>0) {
    //画像が入力されているかの確認
    if ($pro_gazou['size']>1000000) {
        //画像のサイズ制限
        print'画像のサイズが大きすぎます。';
    } else {
        move_uploaded_file($pro_gazou['tmp_name'], '../../gazou/'.$pro_gazou['name']);
        print'<img src="../../gazou/'.$pro_gazou['name'].'"><br>';
    }
}

if ($pro_name==''||preg_match('/\A[0-9]+\z/', $pro_price)==0||$pro_gazou['size']>1000000) {
    //入力ミスがある場合
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
} else {
    //入力がすべて正しい場合
    print '<br>上記のように変更します。<br />';
    print '<form method="post" action="pro_edit_done.php">';
    print '<input type="hidden" name="code" value="'.$pro_code.'">';
    print '<input type="hidden" name="name" value="'.$pro_name.'">';
    print '<input type="hidden" name="price" value="'.$pro_price.'">';
    print '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
    print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
    print '<br />';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="ＯＫ">';
    //measures for csrf/form
    csrfForm();
    print '</form>';
}

?>

</body>

</html>