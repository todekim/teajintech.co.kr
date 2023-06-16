<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
</div>
</div>
<div class="q">
	<a href="https://blog.naver.com/taejin5523" target="_blank"><img src="/images/blog.jpg" alt="블로그 바로가기"/></a>
	<a href="https://www.youtube.com/channel/UCAj_p1TBxbHlvd7njR7PUbw" target="_blank"><img src="/images/youtube.png" alt="youtube채널 바로가기"/></a>
</div>
<div class="mq mq_blog">
	<a href="https://blog.naver.com/taejin5523" target="_blank"><img src="/images/blog_s.jpg" alt="youtube채널 바로가기"/> BLOG 바로가기</a>
</div>
<div class="mq">
	<a href="https://www.youtube.com/channel/UCAj_p1TBxbHlvd7njR7PUbw" target="_blank"><img src="/images/youtube_icon.png" alt="youtube채널 바로가기"/> YOUTUBE 채널 바로가기</a>
</div>
<div id="ft">
    <div class="ft_wr">
        <div id="ft_company">태진테크 | 서울특별시 금천구 벚꽃로 278(가산동, SJ테크노빌) 607,611,B101호</div>
        <div id="ft_copy">Copyright &copy; <b>taejintech.co.kr.</b> All rights reserved.</div>
    </div>
    <button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></button>
    <?php
    if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
        <a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전으로 보기</a>
        <?php
    }

    if ($config['cf_analytics']) {
        echo $config['cf_analytics'];
    }
    ?>
</div>
<script>
    jQuery(function($) {
        $( document ).ready( function() {
            //상단고정
            if( $(".top").length ){
                var jbOffset = $(".top").offset();
                $( window ).scroll( function() {
                    if ( $( document ).scrollTop() > jbOffset.top ) {
                        $( '.top' ).addClass( 'fixed' );
                    }
                    else {
                        $( '.top' ).removeClass( 'fixed' );
                    }
                });
            }
            // 폰트 리사이즈 쿠키있으면 실행
            font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));        
            //상단으로
            $("#top_btn").on("click", function() {
                $("html, body").animate({scrollTop:0}, '500');
                return false;
            });
        });
    });
</script>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>