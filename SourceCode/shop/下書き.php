<?php
        print basename(__DIR__);

    require_once('../common/common.php');
    csrfCheck();

        //注文時に会員登録をする場合、会員情報を登録する。
        //まずメールアドレスが被っていないか確認
        $email=$_POST['email'];

        $sql='SELECT email FROM dat_member WHERE email=?';
        $stmt=$dbh->prepare($sql);
        $stmt->execute($email);

        $rec=$stmt->fetch(PDO::FETCH_ASSOC);

        if($rec==true){
            print $email;
            print'はすでに登録されているメールアドレスです。';
            exit();
        }
        print basename(__DIR__);
?>