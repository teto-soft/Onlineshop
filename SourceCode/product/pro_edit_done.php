<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
//ログインの証拠がない場合
if (isset($_SESSION['login'])==false) {
    print'ログインされていません。<br>';
    print'<a href="../staff_login/staff_login.html">ログイン画面へ<a>';
    exit();
} elseif (isset($_POST["csrf_token"])!= $_SESSION['csrf_token']) {
    print'不正なリクエストです。';
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
    <title>商品修正実行</title>
</head>

<body>


    <?php
try { //サーバー障害対策
    require_once('../common/common.php');

    $post=sanitize($_POST);
    $pro_code = $post['code'];
    $pro_name = $post['name'];
    $pro_price = $post['price'];
    $pro_gazou_name_old=$post['gazou_name_old'];
    $pro_gazou_name=$post['gazou_name'];

    //DBへの接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL実行
    $sql = 'UPDATE mst_product SET name=?, price=?, gazou=? WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[] = $pro_name; //一つ目の[?]に入力するデータ
    $data[] = $pro_price; //二つ目の[?]に入力するデータ
    $data[] = $pro_gazou_name; //三つ目の[?]に入力するデータ
    $data[] = $pro_code; //四つ目の[?]に入力するデータ
    $stmt->execute($data); //プリペアードステートメント

    //DB切断
    $dbh = null;

    //古い画像があり、修正前と違う場合は削除
    /* if($pro_gazou_name_old !=$pro_gazou_name)
    {
        unlink('./gazou/'.$pro_gazou_name_old);
    }
    */
    print '商品情報を修正しました。<br>';
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

    <a href="pro_list.php">戻る</a>

</body>

</html>