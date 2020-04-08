<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
if (isset($_SESSION['login'])==false) {
    //ログインの証拠がない場合
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
<title>商品未選択</title>
</head>
<body>

商品が選択されていません。<br>
<a href="pro_list.php">戻る</a>

</body>
</html>
