<?php
require_once "lib.php";
if (strtolower($_SESSION['id']) !== 'admin') {
    move('index.php', '잘못된 경로입니다.');
}
