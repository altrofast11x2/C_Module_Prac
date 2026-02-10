<?php
require_once "data/db.php";
require_once "admin_kick.php";
require_once "lib.php";
$idx = $_GET['idx'];
$DEL = DB::exec("DELETE FROM board WHERE idx = '$idx'");
if (isset($_SESSION['id']) || strtolower($_SESSION['id']) === 'admin') {
    if ($DEL) {
        move('admin.php', '게시글이 성공적으로 삭제되었습니다');
    } else {
        back('게시글 삭제 실패 다시 시도해주세요');
    }
} else {
    "";
}
