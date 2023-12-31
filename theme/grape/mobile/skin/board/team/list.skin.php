<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/jquery.fancylist.js"></script>

<?php // 게시판 관리의 상단 내용
if (G5_IS_MOBILE) {
    echo '<div class="bo_top_img">';
    // 모바일의 경우 설정을 따르지 않는다.
    echo html_purifier(stripslashes($board['bo_mobile_content_head']));
     echo '</div>';

} 
?>

<div id="bo_list_total" class="pc_view">
    <span>전체 <?php echo number_format($total_count) ?>건</span>
    <?php echo $page ?> 페이지
</div>

<div id="nav">
    <div class="nav_wr"><a href="<?php echo G5_URL ?>"><i class="fa fa-home"></i> </a><span><?php echo ($board['bo_mobile_subject'.($lang_type=="ko"?"":"_".$lang_type)] ? $board['bo_mobile_subject'.($lang_type=="ko"?"":"_".$lang_type)] : $board['bo_subject'.($lang_type=="ko"?"":"_".$lang_type)]); ?></span></div>
</div>

<?php if ($is_category) { ?>
<nav id="bo_cate">
    <h2><?php echo ($board['bo_mobile_subject'.($lang_type=="ko"?"":"_".$lang_type)] ? $board['bo_mobile_subject'.($lang_type=="ko"?"":"_".$lang_type)] : $board['bo_subject'.($lang_type=="ko"?"":"_".$lang_type)]) ?> 카테고리</h2>
    <ul id="bo_cate_ul">
        <?php echo $category_option ?>
    </ul>
</nav>
<?php } ?>

<div id="bo_gallery">
   

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <h2 class="sound_only">이미지 목록</h2>

    <?php if ($is_checkbox) { ?>
    <div class="all_chk">
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
        <label for="chkall"><span class="chk_img"></span> 전체선택</label>
    </div>
    <?php } ?>

    <ul id="team_ul">
        <?php for ($i=0; $i<count($list); $i++) {
        ?>
        <li class="gall_li <?php if ($wr_id == $list[$i]['wr_id']) { ?>gall_now<?php } ?> <?=($list[$i][wr_1])?"dis_pro":"";?>">
            <a href="<?php echo $list[$i]['href'] ?>" class="gall_img">
            <?php
            if ($list[$i]['is_notice']) { // 공지사항 ?>
                <strong style="width:<?php echo $board['bo_mobile_gallery_width'] ?>px;height:<?php echo $board['bo_mobile_gallery_height'] ?>px">공지</strong>
            <?php
            } else {
                $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height']);

                if($thumb['src']) {
                    $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_mobile_gallery_width'].'" height="'.$board['bo_mobile_gallery_height'].'">';
                } else {
                    $img_content = '<img src="'.G5_THEME_IMG_URL.'/noimage.png">';
                }

                echo $img_content;
            }
            ?>
            </a>
            <div class="gall_txt">

                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <? if($list[$i][wr_1]){ echo "<span class=badge badge-danger>단종</span>";} ?>

                <?php if ($is_checkbox) { // 게시글별 체크박스 ?>
                <span class="sel bo_chk li_chk">
                    <label for="chk_wr_id_<?php echo $i ?>"><span class="chk_img"></span> <span class="sound_only"><?php echo $list[$i]['subject'.($lang_type=="ko"?"":"_".$lang_type)] ?></span></label>
                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                </span>
                순서 : <input type="text" name="wr_10[]" class="frm_input wr_10" value="<?=$list[$i][wr_10];?>" rel="<?=$list[$i]['wr_id'];?>" size="4"/>
                <?php } ?>

                <?php
                // echo $list[$i]['icon_reply']; 갤러리는 reply 를 사용 안 할 것 같습니다. - 지운아빠 2013-03-04
                if ($is_category && $list[$i]['ca_name']) {
                ?>
                <?php } ?>
                <a href="<?php echo $list[$i]['href'] ?>" class="gall_li_tit">
                    <?php if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret']; ?>

                    <?php echo $list[$i]['subject'.($lang_type=="ko"?"":"_".$lang_type)] ?>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
                </a>
                <div class="lt_detail"> <?php echo get_text(cut_str(strip_tags($list[$i]['wr_content']), 25), 1); ?></div>
            </div>
        </li>
        <?php } ?>
        <?php if (count($list) == 0) { echo "<li class=\"empty_list\">게시물이 없습니다.</li>"; } ?>
    </ul>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01 btn"> 목록</a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn_m btn_b01">선택삭제</button></li>
            <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn_m btn_b01">선택복사</button></li>
            <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn_m btn_b01">선택이동</button></li>
            <?php } ?>
        </ul>
        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_wr">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_m btn_b01">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class=" btn_admin" target="_blank"><i class="fa fa-cog"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_m btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>

    </form>

     
    <fieldset id="bo_sch">
        <legend>게시물 검색</legend>

        <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sop" value="and">
        <label for="sfl" class="sound_only">검색대상</label>
        <select name="sfl" id="sfl">
            <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
            <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
            <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
            <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
            <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
            <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
            <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
        </select>
        <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="sch_input" size="15" maxlength="20">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
        </form>
    </fieldset>

</div>


<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>


<?php if ($is_checkbox) { ?>
<script>
$(".wr_10").keyup(function(e){
    var v=$(this).val();
    var wr_id=$(this).attr("rel");
    var ajsxUrl="ajax_wr_10.php?bo_table="+g5_bo_table +"&wr_id="+wr_id+"&wr_10="+v;
    v = v.replace(/[^\d]/gi,"");
    $(this).val(v);
    $.post( ajsxUrl, function( data ) {
      if(data) alert(data);
    });

})
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
