<?php
require_once('../common/common.php');
//measures for csrf/check
csrfCheck();

//escape
$post = e($_POST);
$pro_disp = $post['disp'];
$pro_code = $post['procode'];
$pro_add = $post['add'];
$pro_edit = $post['edit'];
$pro_delete = $post['delete'];

//修正ボタン押下
if (isset($pro_disp)==true) {
    if (isset($pro_code)==false) {
        //商品を選択していない場合
        header('Location: pro_ng.php');
        exit();
    }
    header('Location: pro_disp.php?procode='.$pro_code);
    exit();
}

//追加ボタン押下
if (isset($pro_add)==true) {
    header('Location: pro_add.php');
    exit();
}

//修正ボタン押下
if (isset($pro_edit)==true) {
    if (isset($pro_code)==false) {
        //商品を選択していない場合
        header('Location: pro_ng.php');
        exit();
    }
    header('Location: pro_edit.php?procode='.$pro_code);
    exit();
}

//削除ボタン押下
if (isset($pro_delete)==true) {
    if (isset($pro_code)==false) {
        //商品を選択していない場合
        header('Location: pro_ng.php');
        exit();
    }
    header('Location: pro_delete.php?procode='.$pro_code);
    exit();
}

//header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/file1.php');