<?php
require_once "data/db.php";
require_once "lib.php";
session_destroy();
move('login.php', '로그아웃되었습니다.');
