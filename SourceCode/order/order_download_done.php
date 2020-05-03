<?php
require_once('../common/common.php');
//check the login status of staff
checkLoginStaff();
//measures for csrf/check
csrfCheckShop();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>ダウンロード</title>
</head>

<body>

    <?php
try {
    //escape
    $post=e($_POST);
    $year=$post['year'];
    $month=$post['month'];
    $day=$post['day'];

    //DBへの接続
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL実行
    $sql='SELECT
        dat_sales.code,
        dat_sales.date,
        dat_sales.code_member,
        dat_sales.name AS dat_sales_name,
        dat_sales.email,
        dat_sales.postal1,
        dat_sales.postal2, 
        dat_sales.address,
        dat_sales.tel,
        dat_sales_product.code_product,
        mst_product.name AS mst_product_name,
        dat_sales_product.price,
        dat_sales_product.quantity
    FROM
        dat_sales, dat_sales_product, mst_product
    WHERE  
        dat_sales.code=dat_sales_product.code_sales
        AND dat_sales_product.code_product =mst_product.code
        AND substr(dat_sales.date,1,4)=?
        AND substr(dat_sales.date,6,2)=?
        AND substr(dat_sales.date,9,2)=?
    ';
       
    $stmt=$dbh->prepare($sql);
    $data[]=$year;
    $data[]=$month;
    $data[]=$day;
    $stmt->execute($data); //プリペアードステートメント

    //DB切断
    $dbh = null;

    $csv='注文コード,注文日時,会員番号,お名前,メール,郵便番号,住所,TEL,商品コード,商品名,価格,数量';
    $csv.="\n";

    //1レコードでも取れたらtrueになるフラグ
    $okflg=false;
    while (true) {
        $rec=$stmt->fetch(PDO::FETCH_ASSOC);

        if ($rec==false) {
            break;
        }
        //1レコードでも取れたらtrueになるフラグ
        $okflg=true;
        $csv.=$rec['code'];
        $csv.=',';
        $csv.=$rec['date'];
        $csv.=',';
        $csv.=$rec['code_member'];
        $csv.=',';
        $csv.=$rec['dat_sales_name'];
        $csv.=',';
        $csv.=$rec['email'];
        $csv.=',';
        $csv.=$rec['postal1'].'-'.$rec['postal2'];
        $csv.=',';
        $csv.=$rec['address'];
        $csv.=',';
        $csv.=$rec['tel'];
        $csv.=',';
        $csv.=$rec['code_product'];
        $csv.=',';
        $csv.=$rec['mst_product_name'];
        $csv.=',';
        $csv.=$rec['price'];
        $csv.=',';
        $csv.=$rec['quantity'];
        $csv.="\n";
    }
    
    //print nl2br($csv);
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

    if ($okflg==true) {
        //ランダムな文字列を生成する
        $rand_str = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) .
        chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90));

        //ファイルの書き込み
        $file=fopen('../../order_list/'.$rand_str.'.csv', 'w'); //ファイルを開ける。
        $csv=mb_convert_encoding($csv, 'SJIS', 'UTF-8'); //文字コードの変換
        fputs($file, $csv); //ファイルに書き込む。
        fclose($file); //ファイルを閉じる。
        print'<a href="../../order_list/'.$rand_str.'.csv">注文データのダウンロード</a><br>';
        print'<br>';
    } else {
        print $year.'年'.$month.'月'.$day.'日';
        print'に該当するデータはありませんでした。<br>';
        print'<br>';
    }
    ?>

    <a href="order_download.php">日付選択へ</a><br>
    <br>
    <a href="../staff_login/staff_top.php">トップメニュー</a><br>

</body>

</html>