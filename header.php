<?php
require_once 'data/db.php';
require_once 'lib.php';
?>

<!-- 로딩 -->
<!-- <div id="loading">
  <div class="spinner"></div>
</div> -->
<!-- 헤더 -->
<header class="site_header">
  <div class="container">
    <h1 class="logo">
      <a href="index.php"><img
          src="./선수제공파일/공통/images/GIFTS_Mall.png"
          alt="./선수제공파일/공통/images/GIFTS_Mall.png"
          title="GIFTS:Mall" /></a>
    </h1>
    <nav class="nav01 gnb">
      <ul>
        <li>
          <a href="sub01.php">소개</a>
        </li>
        <li>
          <a href="sub02.php" class="special">판매상품</a>
          <ul>
            <li><a href="sub02.php">전체상품</a></li>
            <li><a href="sub03.php">인기상품</a></li>
          </ul>
        </li>
        <li>
          <a href="#">가맹점</a>
        </li>
        <li>
          <a href="sub04.php">장바구니</a>
        </li>
      </ul>
    </nav>
    <nav class="nav02 gnb">
      <ul>
        <li>
          <?php
          if ($_SESSION['id'] ?? '') {
            echo "<a href='logout.php' onclick='return confirm(\"로그아웃 하시겠습니까?\");'>{$_SESSION['id']} 님 안녕하세요 (로그아웃)</a>";
          } else {
            echo "<a href='login.php'>로그인/회원가입</a>";
          }
          ?>
        </li>
        <li><a href="sub04.php">장바구니</a></li>
        <?php
        //strtolower = 대소문자 상관없이
        if (isset($_SESSION['id']) && strtolower($_SESSION['id']) === 'admin') {
          echo "<a href='admin.php'>관리자</a>";
          // alert('관리자 계정입니다.');
        }
        ?>
      </ul>
    </nav>
  </div>
</header>