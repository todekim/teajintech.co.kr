<?
include_once("./_common.php");
include_once("./config.php");

foreach ($_GET as $first_key => $first_value){
    $GET_VARS .= "&".$first_key."=".$first_value;
}

$sql = "select bo_table from g5_board order by bo_table asc";
$result = sql_query($sql);
while($row=sql_fetch_array($result)){
    $query = "alter table g5_write_".$row['bo_table']." add wr_subject_en varchar(255) null after wr_subject, 
    add wr_subject_cn varchar(255) null after wr_subject_en, 
    add wr_subject_jp varchar(255) null after wr_subject_cn, 
    add wr_content_en text null after wr_content,
    add wr_content_cn text null after wr_content_en,
    add wr_content_jp text null after wr_content_cn";
    sql_query($query);
    //echo $query."<br>";
}
?>