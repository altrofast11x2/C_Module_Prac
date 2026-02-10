<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<style>
    input {
        border: 1px solid #333333;
        background-color: #ffffff;
        border-radius: 16px;
        width: 100%;
        height: 55px;
        margin: 15px 0;
        padding: 20px;
        font-size: 1.1em;
    }

    .sign_up_bk {
        top: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sign_up {
        padding: 50px;
        width: 600px;
        height: 720px;
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        background-color: #ededed;
    }

    form {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        font-size: 1.1em;
    }

    .title {
        margin: 34px 2px;
    }

    .title::before {
        position: absolute;
        left: -3%;
        content: "";
        width: 15px;
        height: 100%;
        background-color: #ac5cff;
    }

    .send {
        margin: 20px 0;
        width: 150px;
        height: 55px;
        font-size: 1.1em;
        border-radius: 25px;
        color: #f3f3f3;
        font-weight: bold;
        background-color: rgb(172, 92, 255);
        text-align: center;
    }
</style>
<?php
require_once 'header.php';
if ($_SESSION['id'] ?? '') {
    move('index.php', '이미 로그인이 되어있습니다.');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $pw = $_POST['pw'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $check = DB::fetch("SELECT count(*) AS cnt FROM users WHERE id = '$id'");
    if ($check['cnt'] > 0) {
        back('이미 존재하는 아이디입니다.');
        exit;
    }
    $salt = uniqid();
    $enc_pw = hash('SHA256', $pw . $salt);
    DB::exec("INSERT INTO users (id,pw,name,email,salt,date) VALUES ('$id','$enc_pw','$name','$email','$salt',NOW())");
    move('login.php', '회원가입완료');
    exit;
}

?>

<body>
    <section class="sign_up_bk">
        <div class="container sign_up">
            <h2 class="title"><span>회원가입</span>SIGN UP</h2>
            <form method="post">
                <input type="text" name="id" placeholder="아이디" required>
                <input type="password" name="pw" placeholder="비밀번호" required>
                <input type="text" name="name" placeholder="이름" required>
                <input type="email" name="email" placeholder="이메일" required>
                <button type="submit" class="send">가입하기</button>
                <a href="login.php">계정이 이미 있으신가요?</a>
            </form>
        </div>
    </section>
</body>

</html>