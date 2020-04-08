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
<title>商品追加フォーム</title>
</head>
<body>

商品追加<br><br>
<form method="post" action="pro_add_check.php" enctype="multipart/form-data">
商品名を入力してください。<br>
<input type="text" name="name" style="width:200px"><br>
価格を入力してください。<br>
<input type="text" name="price" style="width:50px"><br>
画像を選んでください。<br>
<input type="file" name="gazou" style="width:400px"><br>
<br>
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ＯＫ">
</form>

</body>
</html>
