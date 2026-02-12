<?php
require_once 'data/db.php';
DB::exec("TRUNCATE TABLE item");
$item = file_get_contents('./data.json');
$json = json_decode($item);

foreach ($json as $key => $value) {
    $num = 1;
    foreach ($value as $key2 => $value2) {
        $price = str_replace(',', '', $value2->price);
        $dis = str_replace(',', '', $value2->dis);
        DB::exec("insert into item (img, cate, title, price, dis, des, date)
            values ('./선수제공파일/A-Module/images/$key/$num.PNG',
            '$key', '$value2->title','$price','$dis','$value2->des',NOW())");
        $num++;
    }
}
