<?php
session_start();
session_regenerate_id(true); //毎回合言葉を変える
if (isset($_SESSION['login'])==false) {
    //ログインの証拠がない場合
    print'ログインされていません。<br>';
    print'<a href="../staff_login/staff_login.html">ログイン画面へ<a>';
    exit();
}

//修正ボタン押下
if (isset($_POST['disp'])==true) {
    if (isset($_POST['procode'])==false) {
        //商品を選択していない場合
        header('Location: pro_ng.php');
        exit();
    }
    $pro_code=$_POST['procode'];
    header('Location: pro_disp.php?procode='.$pro_code);
    exit();
}

//追加ボタン押下
if (isset($_POST['add'])==true) {
    header('Location: pro_add.php');
    exit();
}

//修正ボタン押下
if (isset($_POST['edit'])==true) {
    if (isset($_POST['procode'])==false) {
        //商品を選択していない場合
        header('Location: pro_ng.php');
        exit();
    }
    $pro_code=$_POST['procode'];
    header('Location: pro_edit.php?procode='.$pro_code);
    exit();
}

//削除ボタン押下
if (isset($_POST['delete'])==true) {
    if (isset($_POST['procode'])==false) {
        //商品を選択していない場合
        header('Location: pro_ng.php');
        exit();
    }
    $pro_code=$_POST['procode'];
    header('Location: pro_delete.php?procode='.$pro_code);
    exit();
}
