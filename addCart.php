<?php
require_once "data/db.php";

$id = $_GET["idx"];
$user = $_GET["user"];

$result;

$check = DB::fetch("SELECT * FROM cart WHERE itemIdx = '$id' and userIdx='$user'");

if ($check) {
    $result = DB::exec("UPDATE cart SET cnt= cnt + 1 WHERE itemIdx = '$id' and userIdx='$user'");
} else {
    $result = DB::exec("INSERT INTO cart(itemIdx, userIdx) VALUES ('$id','$user')");
}

header('Content-Type: application/json');

echo json_encode($check);
