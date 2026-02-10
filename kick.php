<?php
require_once "data/db.php";
if (empty($_SESSION['id'])) {
  move('login.php', '로그인해주세요.');
  exit;
}
