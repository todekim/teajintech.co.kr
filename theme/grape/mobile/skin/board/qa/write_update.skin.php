<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$w){
    //sms발송 
    $msg_from="server";//문자발송 요청 주체
    $strData  = iconv_euckr($msg);
    $sendType = strlen($strData) > 90 ? 1 : 0; // 0: SMS / 1: LMS
    $msg_type = (!$sendType)?"sms":"lms";//sms : 단문 , lms : 장문 
    $post_data = array("link_url" => $link_url ,"wr_subject" => $wr_subject ,"wr_email" => $wr_email,"wr_content" => $wr_content ,"wr_1" => $wr_1 , "wr_name" => $wr_name);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, G5_DOMAIN."/bbs/sms.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_exec($ch);
}

?>