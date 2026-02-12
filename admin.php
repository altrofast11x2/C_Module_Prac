<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<style>
  .btn {
    width: 50px;
    height: 50px;
    /* font-size: .9em; */
    font-weight: 550;
    padding: 5px 7px;
    margin: 0 5px;
    color: #f3f3f3;
    border-radius: 10px;
  }

  .e {
    background-color: rgb(172, 92, 255);
  }

  .d {

    background-color: #ff1616;
  }
</style>
<?php
require_once "header.php";
// require_once "kick.php";
require_once "admin_kick.php"
?>

<body>
  <section class="notice" id="board" style="margin-top: 90px;">
    <div class="container">
      <h2 class="title"><span>공지사항 관리</span>NOTICE MANAGEMENT</h2>
      <?php
      // 검색
      // $search = $_GET['search'] ?? '';
      // $srch = "";
      // if ($search) {
      //   $srch = "WHERE  OR type LIKE '%$search%'";
      // }

      // pagenation
      $type = $_GET['type'] ?? '';
      $page = $_GET['page'] ?? 1;
      $sort = $_GET['sort'] ?? 'desc';
      $where_sql = "";
      if ($type) {
        $where_sql = "WHERE type = '$type'";
      }
      $counter = DB::fetch("SELECT count(*)AS cnt FROM board $where_sql");
      $cnt = $counter['cnt'] ?? 0;

      $scale = 6;
      $start = ($page - 1) * $scale;

      $total_page = ceil($cnt / $scale);
      if ($total_page == 0) $total_page = 1;

      $board_list = DB::fetchAll("SELECT * FROM board $where_sql ORDER BY date $sort LIMIT $start,$scale");
      ?>
      <div class="noti_head" style="display: flex;justify-content: space-between;">
        <div class="count">
          <h2 style="color: #333;">총 <?= $cnt ?> 개</h2>
        </div>
        <form action="#board" method="GET" style="display: flex; margin:20px 0;">
          <a href="add.php" style="color: #f3f3f3;background-color: rgb(172, 92, 255);padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">글 추가하기</a>
          <!-- <input type="text" name="search" placeholder="검색하실 제목 또는 유형을 적어주세요." style="border: 2px solid #33333370; padding:12px; width: 300px; font-size: 1em; border-radius: 16px;"> -->
          <a href="?type=일반#board" style="color: rgb(172, 92, 255);background-color:#f3f3f3;padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">일반</a>
          <a href="?type=이벤트#board" style="color: rgb(172, 92, 255);background-color:#f3f3f3;padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">이벤트</a>
          <a href="?#board" style="color: #f3f3f3;background-color: rgb(172, 92, 255);padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">전체보기</a>
          <a href="?sort=asc#board" style="color: #f3f3f3;background-color: rgb(172, 92, 255);padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">ASC (오래된순)</a>
          <a href="?sort=desc#board" style="color: #f3f3f3;background-color: rgb(172, 92, 255);padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">DESC (최신순)</a>
        </form>
      </div>
      <table>
        <thead>
          <tr>
            <th scope="col" style="width: 200px;">유형</th>
            <th scope="col" style="width: 300px;">제목</th>
            <th scope="col" style="width: 200px;">공지일자</th>
            <th scope="col" style="width: 100px;">관리</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($board_list as $data) { ?>
            <tr>
              <td><?php echo $data['type'] ?? '' ?></td>
              <td><a href="#?idx=<?= $data['idx'] ?>"><?php echo $data['title'] ?? '' ?></a></td>
              <td><?php echo $data['date'] ?? '' ?></td>
              <td>
                <a href="edit.php?idx=<?= $data['idx'] ?>" class="e btn">수정</a>
                <a href="delete.php?idx=<?= $data['idx'] ?>" onclick="return confirm('정말 게시글을 삭제 하시겠습니까?');" class="d btn">삭제</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php if (empty($board_list)) {
        echo "<h2 class='empty'style='margin: 250px 0;text-align: center;'color='#3333''>등록된 공지사항이 없습니다.</h2>";
      } ?>
      <div class="arrows" style="text-align:center;">
        <?php if ($page > 1) { ?>
          <a href="?page=<?= $page - 1 ?>&type=<?= $type ?>" class="left arrow">&lt;</a>
        <?php } else { ?>
          <span class="left arrow" style="opacity:0.5;">&lt;</span>
        <?php } ?>

        <div class="num" style="display:inline-block; margin:0 10px;">
          <?= $page ?> / <?= $total_page ?>
        </div>

        <?php if ($page < $total_page) { ?>
          <a href="?page=<?= $page + 1 ?>&type=<?= $type ?>" class="right arrow">&gt;</a>
        <?php } else { ?>
          <span class="right arrow" style="opacity:0.5;">&gt;</span>
        <?php } ?>
      </div>
    </div>
  </section>
  <section class="notice" id="user_list">
    <div class="container">
      <h2 class="title"><span>회원관리</span>USER MANAGEMENT</h2>
      <?php
      $srch = "";
      $search = $_GET['search'] ?? '';
      if ($search) {
        $srch = "WHERE id LIKE '%$search%'";
      }
      $sort2 = $_GET['sort2'] ?? 'DESC';
      $counter2 = DB::fetch("SELECT COUNT(*) AS CNT2 FROM users $search");
      $cnt2 = $counter2['CNT2'] ?? 0;
      $page2 = $_GET['page'] ?? 1;
      $scale2 = 6;
      $start2 = ($page2 - 1) * $scale2;
      $total_page2 = ceil($cnt2 / $scale2);
      if ($total_page2 == 0) $total_page2 = 1;
      $user_list = DB::fetchAll("SELECT * FROM users $srch ORDER BY date $sort2 LIMIT $start2,$scale2");
      ?>
      <!-- class noti_head 재활용한것 -->
      <div class="noti_head" style="display: flex;align-items: center; justify-content: space-between; margin: 20px 0;">
        <div class="count">
          <h2 style="color: #333;">총 <?= $cnt2 ?> 명</h2>
        </div>
        <div class="rope" style="display: flex; align-items: center; justify-content:space-between;">
          <form method="GET">
            <input type="search" name="search" style="border: 2px solid #33333370; padding: 12px; width: 300px; font-size: 1em;margin: 0 10px; border-radius: 16px;" placeholder="아이디 검색">
          </form>
          <a href="?sort2=desc#user_list" style="color: #f3f3f3;background-color: rgb(172, 92, 255);padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">ASC (가입 최신순)</a>
          <a href="?sort2=asc#user_list" style="color: #f3f3f3;background-color: rgb(172, 92, 255);padding: 10px; margin: 0 10px; border-radius: 16px; font-weight: 550; border: 2px solid #33333370;">DESC (가입 오래된순)</a>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th scrop="col" style="width: 250px;">아이디</th>
            <th scrop="col" style="width: 250px;">암호화된 비밀번호</th>
            <th scrop="col" style="width: 250px;">이름</th>
            <th scrop="col" style="width: 250px;">이메일</th>
            <th scrop="col" style="width: 250px;">생성날짜</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($user_list as $data) { ?>
            <tr>
              <td><?= $data['id'] ?></td>
              <td><?= $data['pw'] ?></td>
              <td><?= $data['name'] ?></td>
              <td><?= $data['email'] ?></td>
              <td><?= $data['date'] ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="arrows" style="text-align:center;">
        <?php if ($page2 > 1) { ?>
          <a href="?page=<?= $page2 - 1 ?>#user_list" class="left arrow">&lt;</a>
        <?php } else { ?>
          <span class="left arrow" style="opacity:0.5;">&lt;</span>
        <?php } ?>
        <div class="num" style="display:inline-block; margin:0 10px;">
          <?= $page2 ?> / <?= $total_page2 ?>
        </div>
        <?php if ($page2 < $total_page2) { ?>
          <a href="?page=<?= $page2 + 1 ?>#user_list" class="right arrow">&gt;</a>
        <?php } else { ?>
          <span class="right arrow" style="opacity:0.5;">&gt;</span>
        <?php } ?>
      </div>
    </div>
  </section>