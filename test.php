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



<div class="bg-dark-4">
	<div class="grid">
		<div class="row">
			<div class="col-sm-5"><img src="/images/a_1.png" alt="hand shake" class="img-responsive"></div>
			<div class="col-sm-7">hello?<br>Welcome to the Taejin Tech homepage.<br>Since its establishment in 1998, our company is a controller specialist company that develops and manufactures fan controls, warming lights, temperature alarms, and wireless temperature alarms.<br>We are striving to make products that all livestock farmers can use with confidence through original and groundbreaking research and development.<br><br>Looking forward to working harder<br>continuously growing<br>As we do our best for our customers<br><br>We will not stop research and development to make better products, and we will always do our best to repay your support.<br>thank you<br><br>All TaejinTech employees</div>
		</div>
	</div>
</div>
