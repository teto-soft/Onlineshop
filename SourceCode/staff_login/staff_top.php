<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ショップ管理画面</title>
</head>
<body>
    ショップ管理トップメニュー<br>
    <br>
    <a href="../staff/staff_list.php">スタッフ管理</a><br>
    <br>
    <a href="../product/pro_list.php">商品管理</a><br>
    <br>
    <a href="../order/order_download.php">注文ダウンロード</a><br>
    <br>
    <a href="staff_logout.php">ログアウト</a><br>
</body>
</html>
