<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$is_admin && $group['gr_device'] == 'pc')
    alert($group['gr_subject'].' 그룹은 PC에서만 접근할 수 있습니다.');

include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>

<!-- 메인화면 최신글 시작 -->
<div class="grid">
<?php
//  최신글
$sql = " select bo_table, bo_subject
            from {$g5['board_table']}
            where gr_id = '{$gr_id}'
              and bo_list_level <= '{$member['mb_level']}'
              and bo_device <> 'pc' ";
if(!$is_admin)
    $sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $rn=sql_fetch("select count(wr_id) as n from g5_write_{$row['bo_table']}");
    // latest(스킨, 게시판아이디, 출력라인, 글자수);
    if($rn[n]) echo latest('theme/pic_basic', $row['bo_table'], 20, 70);
}
?>
</div>
<!-- 메인화면 최신글 끝 -->

<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>
