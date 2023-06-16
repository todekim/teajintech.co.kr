<?php 
include_once 'config.php';
$msg;
$success;
$fail;
function send_notification ($tokens, $notification, $data)
{
	global $success,$fail;
	$url = 'https://fcm.googleapis.com/fcm/send';
	$headers = array('Content-Type: application/json','Authorization:key ='.FIREBASE_API_KEY);
	foreach($tokens as $k=>$v){
		$fields = array("to"=>$v, "priority" => "high", "notification"=>$notification, "data"=>$data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);           
		if ($result === FALSE) $fail++;
		else $success++;
		curl_close($ch);
	}
}

$sql = "select token From fcm_user where role='".$_POST['role']."'";
$result = mysqli_query($conn,$sql);
$tokens = array();
while ($row = mysqli_fetch_assoc($result)) $tokens[] = $row["token"];
mysqli_close($conn);

$notification   = array("body" => $_POST['message'], "title" => $_POST['title']);
$data           = array("message" => $_POST['message'], "title" => $_POST['title']);
$message_status = send_notification($tokens, $notification, $data);

$msg = "메세지 전송 : 성공(".$success."), 실패(".$fail.")";

echo "<script> alert('".$msg."'); location.href='index.php'; </script>";
?>