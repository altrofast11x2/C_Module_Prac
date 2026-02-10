<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100vh;
            color: #333;
        }

        .edit {
            width: 700px;
            height: 650px;
            padding: 40px;
            border-radius: 15px;
            background-color: #f3f3f3;
        }

        .edit form {
            display: flex;
            flex-direction: column;
        }

        .edit form>input {
            margin: 10px;
            padding: 15px;
            font-size: 1em;
            text-align: center;
            border-radius: 15px;
            border: 2px solid #33333370;
            background-color: #fff;
        }

        .title::before {
            left: -20px;
        }
    </style>
</head>
<?php
require_once "header.php";
require_once "data/db.php";
require_once "admin_kick.php";
$sql = DB::fetch("SELECT * FROM board");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    if (empty($type) || empty($title) || empty($date)) {
        back('내용을 모두 채워주세요');
    } else {
        DB::exec("INSERT INTO board (type,title,date) VALUES ('$type','$title','$date') ");
        move('admin.php', '업로드 성공!');
    }
}
?>

<body>
    <section class="edit">
        <h2 class="title"><span>게시글 추가</span>ADD</h2>
        <form method="post">
            <h3>유형</h3>
            <input type="text" name="type" placeholder="유형">
            <h3>제목</h3>
            <input type="text" name="title" placeholder="제목">
            <h3>날짜</h3>
            <input type="date" name="date" placeholder="날짜">
            <button type=" submit" style="background-color: rgb(172, 92, 255); width: 100px; margin: 10px auto; padding: 15px; font-size: 1em; font-weight: bold; border-radius: 15px; color: #f3f3f3; ">수정하기</button>
        </form>
    </section>
</body>

</html>