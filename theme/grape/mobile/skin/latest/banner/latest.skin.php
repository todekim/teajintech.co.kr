<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
global $is_admin; 
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);

$thumb_width = 300;
$thumb_height = 200;
?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="lt_bn">
    <ul>
    <?php
    for ($i=0; $i<count($list); $i++) {
    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

    if($thumb['ori']) {
        $img = $thumb['ori'];
    } else {
        $img = G5_IMG_URL.'/no_img.png';
        $thumb['alt'] = '이미지가 없습니다.';
    }
    ?>
        <li class="list_<?php echo $i ?>">
            <div style="background:<?php echo $list[$i]['wr_1']; ?>"><a href="<?php echo $list[$i]['wr_link1']?$list[$i]['wr_link1']:$list[$i]['href']; ?>" ><img src="<?php echo $img; ?>"></a></div>
            <div class="bn_txt">
                <div class="txt_wr">
                        <?php
                        echo "<a href=\"".($list[$i]['wr_link1']?$list[$i]['wr_link1']:$list[$i]['href'])."\"  class=\"bn_tit\" style='color:".$list[$i]['wr_2']."'>";
                            echo $list[$i]['subject'.($lang_type=="ko"?"":"_".$lang_type)];
                        echo "</a>";
                        ?>

                        <div class="bn_detail"> <?php echo $list[$i]['wr_content'.($lang_type=="ko"?"":"_".$lang_type)]; ?></div>

                        <?php
                        if($list[$i]['wr_link1']) echo "<a href=\"".$list[$i]['wr_link1']."\" class=\"bn_view\">자세히보기<span class=\"arrow\"></span></a>";
                        ?>
                        <?php
                        if($list[$i]['wr_link2']) echo "<a href=\"".$list[$i]['wr_link2']."\" class=\"bn_view bn_view2\" target='_blank'>데모보기<span class=\"arrow\"></span></a>";
                        ?>
                </div>
            </div>
        </li>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <?php if ($is_admin) { ?><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>" class="bn_link btn_admin btn_m"><i class="fa fa-cog"></i><span class="sound_only"><?php echo $bo_subject ?></span></a> <?php }  ?>
</div>


<script>
$('.lt_bn ul').show().bxSlider({
    pager:false,
    speed:1000,

    easing:'ease-in-out',
    controls:true,
    auto:true
});
</script>

<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->