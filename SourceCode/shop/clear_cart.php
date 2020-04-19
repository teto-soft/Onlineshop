<?php
session_start();
//カートクリア3ステップ：
//セッション変数を空、セッションIDをクッキーから削除、セッションを破棄
$_SESSION=array(); //セッション変数（秘密文書）を空にする。
if (isset($_COOKIE[session_name()])==true) {
    setcookie(session_name(), '', time()-42000, '/');
    //PC側のセッションIDをクッキーから削除する。
}
session_destroy(); //セッションを破棄する。
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>カート内削除実行</title>
</head>
<body>
    カートを空にしました。<br>
</body>
</html>
