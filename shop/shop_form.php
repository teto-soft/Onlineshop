<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>注文フォーム</title>
    <?php require_once('C:/xampp/htdocs/common/common.php'); ?>
</head>

<body>
    お客様情報をご入力ください。<br><br>
    <form method="post" action="shop_form_check.php">
        お名前<br>
        <input type="text" name="onamae" style="width:200px"><br><br>
        メールアドレス <br>
        <input type="text" name="email" style="width:200px"><br><br>
        郵便番号<br>
        <input type="text" name="postal1" style="width:50px"> -
        <input type="text" name="postal2" style="width:80px"><br><br>
        住所<br>
        <input type="text" name="address" style="width:500px"><br><br><br>
        電話番号<br>
        <input type="text" name="tel" style="width:150px"><br><br>

        <input type="radio" name="chumon" value="chumonkonkai" checked>今回だけの注文<br>
        <input type="radio" name="chumon" value="chumontouroku">会員登録しての注文   ＊おすすめ！<br>
        <br>
        <br>※会員登録する方は以下の項目も入力してください。<br>
        <br>パスワードを入力してください。<br>
        <input type="password" name="pass" style="width:100px"><br>
        <br>パスワードをもう1度入力してください。<br>
        <input type="password" name="pass2" style="width:100px"><br>
        <br>性別<br>
        <input type="radio" name="danjo" value="dan" checked>男性<br>
        <input type="radio" name="danjo" value="ja">女性<br>
        <br>生まれ年<br>
        <?php pulldown_year(); ?>
        <br><br><br>

        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="ＯＫ"><br>
    </form>
</body>

</html>