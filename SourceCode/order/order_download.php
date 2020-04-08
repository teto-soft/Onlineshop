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
    <title>注文日選択</title>
</head>

<body>

    <?php
require_once('../common/common.php');
?>

    ダウンロードしたい注文日を選んでください。 <br>
    <form method="post" action="order_download_done.php">
        <!--プルダウンメニューの作成-->
        <?php pulldown_year(); ?>
        年
        <?php pulldown_month(); ?>
        月
        <?php pulldown_day(); ?>
        日<br><br>
        <input type="submit" value="ダウンロードへ"><br><br>
    </form>

    <a href="../staff_login/staff_top.php">トップメニュー</a><br>

</body>

</html>