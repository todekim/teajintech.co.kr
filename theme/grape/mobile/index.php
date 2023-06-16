<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>

<!-- 배너 최신글 -->
<?php
// 이 함수가 바로 최신글을 추출하는 역할을 합니다.
// 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
// 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
echo latest('theme/banner', 'banner', 10, 33);
?>

<div class="idx_rs">
   <h2><i class="fa fa-calendar"></i> 이메일</h2>
   <p class="tel">info@taejintech.co.kr</p>
</div>
<!--  최신글 -->
<div class="idx_lt">
    <div class="bg"><span></span><span></span><span></span></div>
    <div class="lt_wr">
        <h2>상담</h2>
        <strong class="tel">02-3397-3825~6</strong>
        <p>FAX : 02)3397-3824</p>
        <a href="/bbs/board.php?bo_table=qa" class="btn_m btn_b02">온라인상담</a>
    </div>

    <div class="lt_wr time">
        <h2>업무시간안내</h2>
        <ul>
            <li><strong><i class="fa fa-clock-o"></i> 평일</strong> 08:00 ~ 17:00</li>
            <li><strong><i class="fa fa-clock-o"></i> 점심시간</strong> 11:50 ~ 12:50</li>
            <li><strong><i class="fa fa-clock-o"></i> 토,일,공휴일</strong> 휴무</li>
        </ul>
    </div>

    <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    echo latest('theme/basic', 'd_1', 4, 33);
    ?>

</div>

<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>