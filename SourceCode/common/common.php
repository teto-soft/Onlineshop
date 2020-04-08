<?php

//下の関数を使ってこのファイルを取得する。
//require_once('..common/common.php');

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

//サニタイズする
function sanitize($before)
{
    foreach ($before as $key => $value) {
        $after[$key]=htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $after;
}

//プルダウンメニュー(年)
function pulldown_year()
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
function pulldown_month()
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
function pulldown_day()
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
