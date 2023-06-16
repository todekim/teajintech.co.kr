<?php
if(isset($_POST["Token"])){
	include_once 'config.php';	

	$token   = trim($_POST["Token"]);//데이터베이스에 접속해서 토큰을 저장
	$rel_id  = trim($_POST["rel_id"]);//연관아이디
	$role    = trim($_POST["role"]);//사용자 권한
	$regdate = G5_TIME_YMDHIS;

	$query = "insert into fcm_user(token,rel_id,role,regdate) values ('$token','$rel_id','$role','$regdate') ON DUPLICATE KEY UPDATE token = '$token'; ";
	mysqli_query($conn, $query);
	mysqli_close($conn);
}
?>