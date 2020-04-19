<?php
require_once('../common/common.php');
//check the login status of member
session_start();
session_regenerate_id(true); //毎回合言葉を変える
if (isset($_SESSION['member_login'])==false) {
    //ログインできていない場合
    print'オンラインショップへようこそ<br>';
    print'<a href="member_login.html">会員ログイン<a><br><br>';
    exit();
} 
//measures against csrf/check/shop
csrfCheckShop();

try {
    //escape
    $post=e($_POST);
    $onamae=$post['onamae'];
    $email=$post['email'];
    $postal1=$post['postal1'];
    $postal2=$post['postal2'];
    $address=$post['address'];
    $tel=$post['tel'];

    //メール本文の記述
    $honbun='';
    $honbun.=$onamae." 様 \n\n このたびはご注文ありがとうございました。 \n";
    $honbun.="\n";
    $honbun.="ご注文いただいた商品 \n";
    $honbun.="------------------------------ \n";
    
    //カートの中身とそれぞれの数量を代入
    $cart=$_SESSION['cart'];
    $kazu=$_SESSION['kazu'];
    $max=count($cart);

    //DB接続
    $user='root';
    $dsn='mysql:dbname=shop; host=localhost; charset=utf8';
    $password='';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //商品情報を取得
    for ($i=0; $i<$max; $i++) {
        $sql='SELECT name, price FROM mst_product WHERE code=?';
        $stmt=$dbh->prepare($sql);
        $data[0]=$cart[$i];
        $stmt->execute($data);
        $rec=$stmt->fetch(PDO::FETCH_ASSOC);

        //取得したデータを変数に代入
        $name=$rec['name'];
        $price=$rec['price'];
        $kakaku[]=$price; //注文確定時の価格を記録する。（価格変動に対応）
        $suryo=$kazu[$i];
        $shokei=$price * $suryo;

        $honbun.=$name.' ';
        $honbun.=$price.'円x';
        $honbun.=$suryo.'個 = ';
        $honbun.=$shokei."円 \n";
    }

    //DBへの同時接続を防ぐためロック
    $sql='LOCK TABLES dat_sales WRITE, dat_sales_product WRITE, dat_member WRITE';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    //最後に登録された会員コードの初期化
    $lastmembercode=$_SESSION['member_code'];

    //お客様情報を登録する。
    $sql='INSERT INTO dat_sales (code_member, name, email, postal1, postal2, address, tel) VALUES (?,?,?,?,?,?,?)';
    $stmt=$dbh->prepare($sql);
    $data=array(); //配列変数を初期化
    $data[]=$lastmembercode;
    $data[]=$onamae;
    $data[]=$email;
    $data[]=$postal1;
    $data[]=$postal2;
    $data[]=$address;
    $data[]=$tel;
    $stmt->execute($data);

    //追加した注文コードを取得して$lastcodeに代入する。
    $sql='SELECT LAST_INSERT_ID()';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode=$rec['LAST_INSERT_ID()'];

    //お客様コードが紐づいた商品明細を商品ごとに登録する。
    for ($i=0; $i<$max; $i++) {
        $sql='INSERT INTO dat_sales_product (code_sales, code_product, price, quantity) VALUES (?,?,?,?)';
        $stmt=$dbh->prepare($sql);
        $data=array(); //配列変数をクリア
        $data[]=$lastcode;
        $data[]=$cart[$i];
        $data[]=$kakaku[$i];
        $data[]=$kazu[$i];
        $stmt->execute($data);
    }

    //DBのロックを解除
    $sql='UNLOCK TABLES';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    //DB切断
    $dbh=null;
    
    //カートクリアする。
    //セッション変数を空、セッションIDをクッキーから削除、セッションを破棄
    $_SESSION=array(); //セッション変数（秘密文書）を空にする。
    if (isset($_COOKIE[session_name()])==true) {
        setcookie(session_name(), '', time()-42000, '/');
        //PC側のセッションIDをクッキーから削除する。
    }
    session_destroy(); //セッションを破棄する。

    //メール本文の記載
    $honbun.="送料は無料です。 \n";
    $honbun.="------------------------------ \n";
    $honbun.="\n";
    $honbun.="代金は以下の口座にお振込ください。\n";
    $honbun.="ろくまる銀行 \n やさい支店 \n 普通口座 \n 1234567 \n";
    $honbun.="\n";

    //メール本文の署名
    $honbun.="□□□□□□□□□□□□□□□□□□□□□ \n";
    $honbun.="～安心野菜のろくまる農園～ \n";
    $honbun.="\n";
    $honbun.="住所：大阪府大阪市北区 123-4 \n";
    $honbun.="電話：090-6060-xxxx \n";
    $honbun.="メール：info@rokumarunouen.xx.xx \n";
    $honbun.="□□□□□□□□□□□□□□□□□□□□□ \n";

    //print'<br>';
    //print nl2br($honbun); //$honbunの確認用。nl2br()は「\n」をブラウザ上で「<br>」として認識させる。?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>注文登録</title>
</head>

<body>
    <?php
    //お客様へのご案内
    print $onamae.' 様 <br>';
    print'ご注文ありがとうございました。 <br>';
    print $email.'にメールを送りましたのでご確認ください。<br />';
    print'商品は以下の住所に発送させていただきます。 <br>';
    print $postal1.'-'.$postal2.'<br>';
    print $address.'<br>';
    print $tel.'<br>';

    /*    //お客様宛に送るメール
        $title='ご注文ありがとうございます。'; //メールタイトル
        $header='From: info@rokumarunouen.co.jp'; //送信元のメールアドレス
        $honbun=html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        mb_send_mail($email, $honbun, $header); //メールを送信する関数 $emailは送信先（お客様）のメールアドレス

        //自分宛に送るメール
        $title='お客様からご注文がありました。'; //メールタイトル
        $header='From: '.$email; //送信元はお客様のメールアドレス
        $honbun=html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        mb_send_mail('info@rokumarunouen.co.jp', $honbun, $header); //メールを送信する関数
    */
} catch (Exception $e) {
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

    <br>
    <a href="shop_list.php">商品画面へ</a>

</body>

</html>