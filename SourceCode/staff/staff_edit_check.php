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
    <title>スタッフ修正チェック</title>
</head>

<body>

    <?php
require_once('C:/xampp/htdocs/common/common.php');
    
$post=sanitize($_POST);
$staff_code=$post['code'];
$staff_name=$post['name'];
$staff_pass=$post['pass'];
$staff_pass2=$post['pass2'];

if ($staff_name=='') {
    print'スタッフ名が入力されていません。<br>';
} else {
    print'スタッフ名';
    print $staff_name;
    print '<br>';
}

if ($staff_pass=='') {
    print'パスワードが入力されていません。<br>';
}

if ($staff_pass!=$staff_pass2) {
    print'パスワードが一致しません。<br>';
}

if ($staff_name==''|| $staff_pass==''|| $staff_pass!=$staff_pass2) {
    //入力ミスがある場合
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
} else {
    //正常に入力された場合
    $staff_pass=md5($staff_pass); //パスワードの暗号化
    print'<form method="post" action="staff_edit_done.php">';
    print'<input type="hidden" name="code" value="'.$staff_code.'">';
    print'<input type="hidden" name="name" value="'.$staff_name.'">';
    print'<input type="hidden" name="pass" value="'.$staff_pass.'">';
    print'<br>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'<input type="submit" value="ＯＫ">';
    print'</form>';
}
?>

</body>

</html>