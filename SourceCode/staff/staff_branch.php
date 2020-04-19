<?php
require_once('../common/common.php');
//measures for csrf/check
csrfCheck();

//修正ボタン押下
if (isset($_POST['disp'])==true) {
    if (isset($_POST['staffcode'])==false) {
        //どのスタッフも選択しない場合
        header('Location: staff_ng.php');
        exit();
    }
    $staff_code=$_POST['staffcode'];
    header('Location: staff_disp.php?staffcode='.$staff_code);
    exit();
}

//追加ボタン押下
if (isset($_POST['add'])==true) {
    header('Location: staff_add.php');
    exit();
}

//修正ボタン押下
if (isset($_POST['edit'])==true) {
    if (isset($_POST['staffcode'])==false) {
        //どのスタッフも選択しない場合
        header('Location: staff_ng.php');
        exit();
    }
    $staff_code=$_POST['staffcode'];
    header('Location: staff_edit.php?staffcode='.$staff_code);
    exit();
}

//削除ボタン押下
if (isset($_POST['delete'])==true) {
    if (isset($_POST['staffcode'])==false) {
        //どのスタッフも選択しない場合
        header('Location: staff_ng.php');
        exit();
    }
    $staff_code=$_POST['staffcode'];
    header('Location: staff_delete.php?staffcode='.$staff_code);
    exit();
}
