<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>商品追加フォーム</title>
</head>
<body>

商品追加<br><br>
<form method="post" action="pro_add_check.php" enctype="multipart/form-data">
商品名を入力してください。<br>
<input type="text" name="name" style="width:200px"><br><br>
価格を入力してください。<br>
<input type="text" name="price" style="width:50px">円<br><br>
画像を選んでください。<br>
<input type="file" name="gazou" style="width:400px"><br>
<br><br>
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>
