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
   <h2><i class="fas fa-envelope"></i> <?=$lang['words17'];/*이메일 주소*/?></h2>
   <p class="tel">info@taejintech.co.kr</p>
</div>
<!--  최신글 -->
<div class="idx_lt">
    <div class="bg"><span></span><span></span><span></span></div>
    <div class="lt_wr">
        <h2><?=strtoupper($lang['cmd69']);/*상담*/?></h2>
        <strong class="tel"><?=$lang_type=="ko"?"0":"+82";?> 2-3397-3825~6</strong>
        <p>FAX : <?=$lang_type=="ko"?"0":"+82";?> 2-3397-3824</p>
        <a href="mailto:info@taejintech.co.kr" class="btn_m btn_b02"><?=strtoupper($lang['cmd70']);/*온라인 상담*/?></a>
    </div>

    <div class="lt_wr time">
        <h2><?=strtoupper($lang['cmd71']);/*업무시간안내*/;?></h2>
        <ul>
            <li><strong><i class="fa fa-clock-o"></i> <?=$lang['cmd72'];/*평일*/;?></strong> 08:00 ~ 17:00</li>
            <li><strong><i class="fa fa-clock-o"></i> <?=$lang['cmd73'];/*점심시간*/;?></strong> 11:50 ~ 12:50</li>
            <li><strong><i class="fa fa-clock-o"></i> <?=$lang['cmd74'];/*토,일,공휴일*/;?></strong> <?=$lang['cmd75'];/*휴무*/;?></li>
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