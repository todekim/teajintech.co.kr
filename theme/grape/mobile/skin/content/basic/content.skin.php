<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $content_skin_url . '/style.css">', 0);

?>

<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="ctt_con">
        <?php echo $str; ?>
    </div>

</article>

<link rel="stylesheet" href="/plugin/FlexSlider/flexslider.css" type="text/css" media="screen">
<style>
    h2.tit-his {
        text-align: center;
        font-size: 60px;
        font-weight: 100;
        padding: 1em 0;
        color: #222;
    }

    .flexslider dl {
        position: relative;
        padding-left: 70px;
    }

    .flexslider dd {
        position: relative;
    }

    .flexslider dd span {
        position: absolute;
        margin-left: -20px;
        opacity: .6;
    }

    .flexslider dt {
        font-weight: bold;
        color: #35358A;
        position: absolute;
        top: 0;
        left: 0;
        font-size: 120%;
    }

    .flex-control-paging {
        width: 50%;
        left: 0;
        top: 0;
        z-index: 2;
    }
</style>

<script defer="" src="/plugin/FlexSlider/jquery.flexslider.js"></script>

<script>
    $(window).load(function() {
        $('.flexslider').flexslider();
    });
</script>