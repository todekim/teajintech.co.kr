<?php
//20200916 게시판 리스트 진열순서 변경
include_once('./_common.php');
if($is_admin !="super") exit;
if($wr_id && $wr_10 !==""){
	$sql="update g5_write_{$bo_table} set wr_10={$wr_10} where wr_id ={$wr_id}";
	sql_query($sql);
}
?>