<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>スタッフ追加フォーム</title>
</head>
<body>

スタッフ追加<br><br>
<form method="post" action="staff_add_check.php">
スタッフ名を入力してください。<br>
<input type="text" name="name" style="width:200px"><br>
パスワードを入力してください。<br>
<input type="password" name="pass" style="width:100px"><br>
パスワードをもう一度入力してください。<br>
<input type="password" name="pass2" style="width:100px"><br><br>
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>
