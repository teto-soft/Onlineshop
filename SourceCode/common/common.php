<?php
//下の関数を使ってこのファイルを取得する。
//require_once('../common/common.php');

//--------------------login_check--------------------

//check the login status of staff
function checkLoginStaff()
{
    session_start();
    session_regenerate_id(true); //毎回合言葉を変える。
    if (isset($_SESSION['login'])==false) {
        //ログインできていない場合
        print'ログインされていません。<br><br>';
        print'<a href="../staff_login/staff_login.html">ログイン画面へ<a>';
        exit();
    } else {
        //ログインできている場合
        print $_SESSION['staff_name'].'さんログイン中<br><br><br>';
    }
}

//check the login status of member
function checkLoginMember()
{
    session_start();
    session_regenerate_id(true); //毎回合言葉を変える
    if (isset($_SESSION['member_login'])==false) {
        //ログインできていない場合
        print'オンラインショップへようこそ<br>';
        print'<a href="member_login.html">会員ログイン<a><br><br><br>';
    } else {
        //ログインできている場合
        print $_SESSION['member_name'].'様ログイン中 ';
        print'<a href="member_logout.php">ログアウト<a><br><br><br>';
    }
}


//--------------------security--------------------

//escape
function e($before)
{
    foreach ($before as $key => $value) {
        $after[$key]=htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $after;
}

//measures against csrf/form
//</form>タグの直前に<?phpを書いてその中に入れる。
function csrfForm()
{
    session_start();
    //一意なハッシュ化された文字列を生成
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
    print '<input type="hidden" name="token" value='.$token.' />';
}

//measures against csrf/check
function csrfCheck()
{
    session_start();
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die('不正なアクセスです。<br><br><a href="../staff_login/staff_top.php">戻る</a>');
    }
}

//measures against csrf/check for shop
function csrfCheckShop()
{
    session_start();
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {  
        die('不正なアクセスです。<br><br><a href="../shop/shop_list.php">戻る</a>');
    }
}

//--------------------Database--------------------

//connect to the database
/*function connectDb(){
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
*/

//query
/*
function query($sql){
    $stmt=$dbh->prepare($sql);
    $data=array();
    $data[]=$member_email;
    $stmt->execute($data);
}
*/

//disconnect from the database
function disconnectDb()
{
    $dbh=null;
}

//--------------------その他--------------------

//西暦から元号を導く
function gengo($seireki)
{
    if (1868<=$seireki && $seireki<=1911) {
        $gengo='明治';
    }
    
    if (1912<=$seireki && $seireki<=1925) {
        $gengo='大正';
    }
    
    if (1926<=$seireki && $seireki<=1988) {
        $gengo='昭和';
    }
    
    if (1989<=$seireki && $seireki<=2018) {
        $gengo='平成';
    }
    
    if (2019<=$seireki) {
        $gengo='令和';
    }

    return($gengo);
}

//プルダウンメニュー(年)
function pulldownYear()
{
    print'<select name="year">';
    for ($i=1900; $i <= 2100; $i++) {
        if ($i==date("Y")) {
            print'<option value="'.$i.'" selected>'.$i.'</option>';
        } else {
            print'<option value="'.$i.'">'.$i.'</option>';
        }
    }
    print'</select>';
}

//プルダウンメニュー(月)
function pulldownMonth()
{
    print'<select name="month">';
    for ($i=1; $i <= 12; $i++) {
        if (1<=$i && $i<10) {
            print'<option value="0'.$i.'">0'.$i.'</option>';
        } else {
            print'<option value="'.$i.'">'.$i.'</option>';
        }
    }
    print'</select>';
}

//プルダウンメニュー(日)
function pulldownDay()
{
    print'<select name="day">';
    for ($i=1; $i <= 31; $i++) {
        if (1<=$i && $i<10) {
            print'<option value="0'.$i.'">0'.$i.'</option>';
        } else {
            print'<option value="'.$i.'">'.$i.'</option>';
        }
    }
    print'</select>';
}
