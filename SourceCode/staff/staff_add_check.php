<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>データの参照</title>
</head>

<body>

    <?php
//escape
$post=e($_POST);
$staff_name=$post['name'];
$staff_pass=$post['pass'];
$staff_pass2=$post['pass2'];

if ($staff_name=='') {
    print'スタッフ名が入力されていません。<br><br>';
}

if ($staff_pass=='') {
    print'パスワードが入力されていません。<br><br>';
}

if ($staff_pass!=$staff_pass2) {
    print'パスワードが一致しません。<br><br>';
}

if ($staff_name==''|| $staff_pass==''|| $staff_pass!=$staff_pass2) {
    //入力ミスがある場合
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
} else {
    //正常に入力されている場合
    print'スタッフ名：'.$staff_name.'<br>';
    print'パスワード：********';

    print'<form method="post" action="staff_add_done.php">';
    print'<input type="hidden" name="name" value="'.$staff_name.'">';
    print'<input type="hidden" name="pass" value="'.$staff_pass.'">';
    print'<br>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'<input type="submit" value="ＯＫ">';
    //measures for csrf/form
    csrfForm();
    print'</form>';
}
?>

</body>

</html>