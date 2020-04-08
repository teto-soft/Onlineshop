<?php

session_start();
session_regenerate_id(true);
if (isset($_SESSION['member_login'])==false) {
    print 'ログインされていません。<br><br>';
    print '<a href="shop_list.php">商品一覧へ</a>';
    exit();
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>注文チェック</title>
</head>

<body>

    <?php
    try {
        //DB接続
        $code=$_SESSION['member_code'];
        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //ログイン情報から会員情報を取得する。
        $sql = 'SELECT name, email, postal1, postal2, address, tel FROM dat_member WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[]=$code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        //DB切断
        $dbh = null;

        $onamae=$rec['name'];
        $email=$rec['email'];
        $postal1=$rec['postal1'];
        $postal2=$rec['postal2'];
        $address=$rec['address'];
        $tel=$rec['tel'];

        print'お名前<br>';
        print $onamae;
        print'<br><br>';

        print'メールアドレス<br>';
        print $email;
        print'<br><br>';

        print'郵便番号<br>';
        print $postal1;
        print'-';
        print $postal2;

        print'住所<br>';
        print $address;
        print '<br><br>';
    
        print'電話番号<br>';
        print $tel;
        print'<br><br>';

        //取得した会員情報を渡す。
        print'<form method="post" action="shop_kantan_done.php">';
        print'<input type="hidden" name="onamae" value="'.$onamae.'">';
        print'<input type="hidden" name="email" value="'.$email.'">';
        print'<input type="hidden" name="postal1" value="'.$postal1.'">';
        print'<input type="hidden" name="postal2" value="'.$postal2.'">';
        print'<input type="hidden" name="address" value="'.$address.'">';
        print'<input type="hidden" name="tel" value="'.$tel.'">';

        print'<input type="button" onclick="history.back()" value="戻る">';
        print'<input type="submit" value="ＯＫ"><br>';
        print'</form>';
    } catch (\Throwable $th) {
        print'ただいま障害が発生しており、ご迷惑をおかけしております。';
    }
?>

</body>

</html>