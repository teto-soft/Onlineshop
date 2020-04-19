<?php
//ログアウト3ステップ：
//セッション変数を空、セッションIDをクッキーから削除、セッションを破棄
session_start(); //セッション変数（秘密文書）を空にする。
$_SESSION=array();
if (isset($_COOKIE[session_name()])==true) {
    //PC側のセッションIDをクッキーから削除する。
    setcookie(session_name(), '', time()-42000, '/');
}
session_destroy(); //セッションを破棄する。
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>スタッフログアウト</title>
</head>
<body>
    ログアウトしました。<br>
    <br>
    <a href="../staff_login/staff_login.html">ログイン画面へ</a>
</body>
</html>
