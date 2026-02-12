<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link
        rel="stylesheet"
        href="선수제공파일/공통/fontawesome/css/font-awesome.css" />
    <link
        rel="stylesheet"
        href="선수제공파일/공통/fontawesome/css/font-awesome.min.css" />
</head>

<body>
    <?php
    require_once "header.php";
    ?>
    <!-- 전체상품 및 영상 -->
    <section class="all_category">
        <div class="container">
            <!-- 영상 -->
            <h2 class="title"><span>전체상품</span>ALL PRODUCTS</h2>
            <div class="category_wrap">
                <?php
                // 1. DB에서 전체 상품 가져오기
                // (DB 클래스와 fetchAll 함수가 정상 작동한다는 가정하에)
                $itemList = DB::fetchAll("SELECT * FROM item");

                // 2. 카테고리별로 상품 분류하기 (데이터 그룹화)
                $groupedItems = [];
                foreach ($itemList as $item) {
                    $catName = $item['cate']; // DB에 카테고리 컬럼명이 'category'라고 가정
                    $groupedItems[$catName][] = $item;
                }

                // 3. 출력할 5개 카테고리 순서 정의
                $targetCategories = ['건강식품', '디지털', '팬시', '향수', '헤어케어'];

                // 4. 카테고리별 반복 출력
                foreach ($targetCategories as $categoryName) {
                    // 해당 카테고리에 상품이 있는지 확인
                    if (isset($groupedItems[$categoryName])) {
                ?>
                        <div class="category-section">
                            <div class="all_product_title"><?= $categoryName ?></div>

                            <ul>
                                <?php foreach ($groupedItems[$categoryName] as $product) { ?>
                                    <li>
                                        <a href="#"><img src="<?= $product["img"] ?>" alt="<?= $categoryName ?>"></a>
                                        <ul class="name_box2">
                                            <li><strong><?= $product['title'] ?></strong></li>
                                            <li>
                                                <span>가격:</span>
                                                <?= number_format($product['price']) ?>원
                                                <?php
                                                if ($product['dis'] != 0) {
                                                    echo "
                                                <span class='sale_line'>" . number_format($product['dis']) . "원" . "</span>";
                                                } ?>
                                            </li>
                                            <li>
                                                <button>구매하기</button>
                                                <button onclick="addCart(<?= $product["idx"] ?> ,  '<?= $_SESSION["id"] ?>')">장바구니 담기</button>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                <?php
                    } // if isset end
                } // foreach category end
                ?>
            </div>
        </div>
    </section>
    <!-- 결제 알람 -->
    <div class="user-alert">
        방금 비회원 <span class="user-name"></span>님이
        <span class="cost"></span>원을 결제하셨습니다!
    </div>
    <!-- 비회원구매 -->
    <div class="non-user-bg">
        <div class="non-user-container">
            <header>
                <div class="userId">ID:</div>
                <div class="title">비회원 주문</div>
                <div class="close">닫기</div>
            </header>
            <main>
                <div class="cate">
                    <div onclick="category('건강식품',this)" class="active">
                        건강식품
                    </div>
                    <div onclick="category('디지털',this)">디지털</div>
                    <div onclick="category('팬시',this)">팬시</div>
                    <div onclick="category('향수',this)">향수</div>
                    <div onclick="category('헤어케어',this)">헤어케어</div>
                </div>
                <div class="product-container cart">
                    <div class="item">
                        <div class="img-cover"></div>
                        <div class="item_content">
                            <div class="item-title"></div>
                            <div class="item-price"><span class="price"></span></div>
                        </div>
                    </div>
                </div>
                <div class="drop product-container"></div>
            </main>
            <footer>
                <div class="checkout">
                    <div class="total">총: <span>0</span>원</div>
                    <div class="checoutBtn">구매하기</div>
                </div>
            </footer>
        </div>
    </div>
    <!-- 비회원주문 버튼(사이트에서 보임) -->
    <div class="open">비회원주문</div>
    <!-- 푸터 -->
    <footer class="site_footer">
        <div class="container">
            <div class="top_wrap">
                <div class="f_logo">
                    <a href="#"><img
                            src="./선수제공파일/공통/images/GIFTS_Mall_gray.png"
                            alt="./선수제공파일/공통/images/GIFTS_Mall_gray.png"
                            title="GIFTS:Mall" /></a>
                </div>
                <div class="mid">
                    <ul>
                        <li><a href="#">개인정보처리방침</a></li>
                        <li><a href="#">이용약관.법적고지</a></li>
                        <li><a href="#">청소년보호방침</a></li>
                        <li><a href="#">이메일무단수집거부</a></li>
                        <li><a href="#">사이트맵</a></li>
                        <li><a href="#">채용</a></li>
                    </ul>
                </div>
                <div class="sns">
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-facebook-official fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-git-square fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-pinterest-square fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-reddit-square fa-2x"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-youtube-square fa-2x"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bottom_wrap">
                <div class="help">
                    <ul>
                        <li><strong>고객센터 이용안내</strong></li>
                        <li>- 온라인몰 고객센터 1580-8282</li>
                        <li>- 매장고객센터 1577-8254</li>
                        <li>고객센터 운영시간 [평일 09:00 - 18:00]</li>
                        <li>주말 및 공휴일은 1:1문의하기를 이용해주세요.</li>
                        <li>업무가 시작되면 바로 처리해드립니다.</li>
                    </ul>
                </div>
                <div class="copyright">
                    <ul>
                        <li>
                            (주)GIFTS:Mall | 사업자등록번호 : 809-81-01157 | 대표이사 황기영
                        </li>
                        <li>주소 : 서울특별시 용산구 한강대로 123, 40층</li>
                        <li>
                            본사 대표전화 : 02-123-4567 | GIFTS:Mall 가맹상담전화 :
                            02-123-4568
                        </li>
                        <li>COPYRIGHTⓒ 2024 GIFTS:MALL KOREA INC. ALL RIGHTS RESERVED</li>
                    </ul>
                </div>
                <div class="check">
                    <ul>
                        <li>지방은행구매안전서비스</li>
                        <li>
                            GIFTS:Mall은 현금 결제한 금액에 대해 지방은행과 채무지급보증
                            계약을체결하여 안전한 거래를 보장하고 있습니다
                        </li>
                        <li><strong>서비스 가입사실 확인 ></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
<script src="./script/lib.js"></script>
<script src="./script/sub02.js"></script>

</html>