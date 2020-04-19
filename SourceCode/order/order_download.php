<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>注文日選択</title>
</head>

<body>
    ダウンロードしたい注文日を選んでください。 <br>
    <form method="post" action="order_download_done.php">
        <!--プルダウンメニューの作成-->
        <?php pulldownYear(); ?> 年
        <?php pulldownMonth(); ?> 月
        <?php pulldownDay(); ?> 日<br><br>
        <input type="submit" value="ダウンロードへ"><br><br>
        <!-- measures for csrf/form -->
        <?php csrfForm(); ?>
    </form>

    <a href="../staff_login/staff_top.php">トップメニュー</a><br>

</body>

</html>