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
    <title>スタッフ削除確認</title>
</head>

<body>

    <?php

try {
    require_once('../common/common.php');
    $get=sanitize($_GET);
    $staff_code=$get['staffcode'];

    //DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password ='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //スタッフコードからスタッフの名前を取得
    $sql = 'SELECT name FROM mst_staff WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$staff_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name=$rec['name'];

    //DB切断
    $dbh = null;

    //ランダムなバイナリを生成し、16進数に変換することでASCII文字列に変換
    $toke_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($toke_byte);

    // 生成したトークンをセッションに保存
    $_SESSION['csrf_token'] = $csrf_token;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

    スタッフ削除 <br>
    <br>
    スタッフコード<br>
    <?php print $staff_code; ?><br>
    スタッフ名<br>
    <?php print $staff_name;?>
    <br>
    このスタッフを削除してもよろしいですか？<br>
    <br>

    <form method="post" action="staff_delete_done.php">
        <input type="hidden" name="code"
            value="<?php print $staff_code; ?>">
        <input type="hidden" name="csrf_token"
            value="<?=$csrf_token?>">
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>

</body>

</html>