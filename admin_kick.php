<?php
require_once "lib.php";
if (!isset($_SESSION['id']) || strtolower($_SESSION['id']) !== 'admin') {
    back('잘못된 경로입니다.');
    exit;
}
