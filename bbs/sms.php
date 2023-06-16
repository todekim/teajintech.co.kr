<?php
include_once('./_common.php');

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';
if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw'])  $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
if (!$config['cf_icode_id']) $config['cf_icode_id'] = 'sir_';

include_once(G5_SMS5_PATH.'/sms5.lib.php');


$list = array();
$hps = array();
//SMS

$SMS_INFO=sql_fetch("select * from sms5_config");

$wr_name=trim($_POST[wr_name]);//사용자 이름
$wr_1 = trim($_POST[wr_1]);//사용자 번호
$wr_subject = trim($_POST[wr_subject]);//글제목
$wr_content = trim($_POST[wr_content]);//글제목
$wr_admin_hp=explode(",",trim($SMS_INFO[cf_admin_hp]));//관리자 휴대폰 번호
//$wr_admin_hp=array("01037697116");
$wr_message=$wr_name."님 온라인 상담 요청\n연락처 : {$wr_1} \n이메일 : {$wr_email} \n\n제목 : ".conv_unescape_nl($wr_subject)."\n내용 : \n".strip_tags(conv_unescape_nl($wr_content),"");

$wr_reply   = preg_replace('#[^0-9\-]#', '', trim($SMS_INFO[cf_phone]));
$wr_message = clean_xss_tags(trim($wr_message));
$reply = str_replace('-', '', trim($wr_reply));

foreach($wr_admin_hp as $key=>$val){
    array_push($list, array('bk_hp' => str_replace("-","",$val), 'bk_name' => $wr_name, 'mb_id' => '', 'bg_no' => '', 'bk_no' => ''));
    array_push($hps, $reply);  
}

$wr_total=count($list);
$SMS = new SMS5;
if($config['cf_sms_type'] == 'LMS') {
    $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

    if($port_setting !== false) {
        $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

        $wr_success = 0;
        $wr_failure = 0;
        $count      = 0;

        $row2 = sql_fetch("select max(wr_no) as wr_no from {$g5['sms5_write_table']}");
        if ($row2)
            $wr_no = $row2['wr_no'] + 1;
        else
            $wr_no = 1;

        for($i=0; $i<$wr_total; $i++) {
            $strDest = array();
            $strDest[]   = $list[$i]['bk_hp'];
            $strCallBack = $reply;
            $strCaller   = $config['cf_title'];
            $strSubject  = '';
            $strURL      = '';
            $strData     = $wr_message;
            if( !empty($list[$i]['bk_name']) ){
                $strData    = str_replace("{이름}", $list[$i]['bk_name'], $strData);
            }
            $strDate = $booking;
            $nCount = 1;

            $result = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

            if($result) {
                $result = $SMS->Send();

                if ($result) //SMS 서버에 접속했습니다.
                {
                    foreach ($SMS->Result as $result)
                    {
                        list($phone, $code) = explode(":", $result);

                        if (substr($code,0,5) == "Error")
                        {
                            $hs_code = substr($code,6,2);

                            switch ($hs_code) {
                                case '02':   // "02:형식오류"
                                $hs_memo = "형식이 잘못되어 전송이 실패하였습니다.";
                                break;
                                case '23':   // "23:인증실패,데이터오류,전송날짜오류"
                                $hs_memo = "데이터를 다시 확인해 주시기바랍니다.";
                                break;
                                case '97':   // "97:잔여코인부족"
                                $hs_memo = "잔여코인이 부족합니다.";
                                break;
                                case '98':   // "98:사용기간만료"
                                $hs_memo = "사용기간이 만료되었습니다.";
                                break;
                                case '99':   // "99:인증실패"
                                $hs_memo = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
                                break;
                                default:     // "미 확인 오류"
                                $hs_memo = "알 수 없는 오류로 전송이 실패하였습니다.";
                                break;
                            }
                            $wr_failure++;
                            $hs_flag = 0;
                        }
                        else
                        {
                            $hs_code = $code;
                            $hs_memo = get_hp($phone, 1)."로 전송했습니다.";
                            $wr_success++;
                            $hs_flag = 1;
                        }

                        $row = $list[$i];
                        $row['bk_hp'] = get_hp($row['bk_hp'], 1);

                        $log = array_shift($SMS->Log);
                        $log = @iconv('euc-kr', 'utf-8', $log);

                        sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='{$row['bg_no']}', mb_id='{$row['mb_id']}', bk_no='{$row['bk_no']}', hs_name='".addslashes($row['bk_name'])."', hs_hp='{$row['bk_hp']}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'", false);
                    }

                    $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
                }
            }
        }

        sql_query("insert into {$g5['sms5_write_table']} set wr_no='$wr_no', wr_renum=0, wr_reply='$wr_reply', wr_message='$wr_message', wr_success='$wr_success', wr_failure='$wr_failure', wr_memo='$str_serialize', wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='".G5_TIME_YMDHIS."'");
    }
} else {
    $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
    $result = $SMS->Add2($list, $reply, '', '', $wr_message, $booking, $wr_total);

    if ($result)
    {
        $result = $SMS->Send();

        if ($result) //SMS 서버에 접속했습니다.
        {
            $row = sql_fetch("select max(wr_no) as wr_no from {$g5['sms5_write_table']}");
            if ($row)
                $wr_no = $row['wr_no'] + 1;
            else
                $wr_no = 1;

            sql_query("insert into {$g5['sms5_write_table']} set wr_no='$wr_no', wr_renum=0, wr_reply='$wr_reply', wr_message='$wr_message', wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='".G5_TIME_YMDHIS."'");

            $wr_success = 0;
            $wr_failure = 0;
            $count      = 0;

            foreach ($SMS->Result as $result)
            {
                list($phone, $code) = explode(":", $result);

                if (substr($code,0,5) == "Error")
                {
                    $hs_code = substr($code,6,2);

                    switch ($hs_code) {
                        case '02':   // "02:형식오류"
                            $hs_memo = "형식이 잘못되어 전송이 실패하였습니다.";
                            break;
                        case '23':   // "23:인증실패,데이터오류,전송날짜오류"
                            $hs_memo = "데이터를 다시 확인해 주시기바랍니다.";
                            break;
                        case '97':   // "97:잔여코인부족"
                            $hs_memo = "잔여코인이 부족합니다.";
                            break;
                        case '98':   // "98:사용기간만료"
                            $hs_memo = "사용기간이 만료되었습니다.";
                            break;
                        case '99':   // "99:인증실패"
                            $hs_memo = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
                            break;
                        default:     // "미 확인 오류"
                            $hs_memo = "알 수 없는 오류로 전송이 실패하였습니다.";
                            break;
                    }
                    $wr_failure++;
                    $hs_flag = 0;
                }
                else
                {
                    $hs_code = $code;
                    $hs_memo = get_hp($phone, 1)."로 전송했습니다.";
                    $wr_success++;
                    $hs_flag = 1;
                }

                $row = array_shift($list);
                $row['bk_hp'] = get_hp($row['bk_hp'], 1);

                $log = array_shift($SMS->Log);
                $log = @iconv('euc-kr', 'utf-8', $log);

                sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='{$row['bg_no']}', mb_id='{$row['mb_id']}', bk_no='{$row['bk_no']}', hs_name='".addslashes($row['bk_name'])."', hs_hp='{$row['bk_hp']}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'", false);
            }
            $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

            sql_query("update {$g5['sms5_write_table']} set wr_success='$wr_success', wr_failure='$wr_failure', wr_memo='$str_serialize' where wr_no='$wr_no' and wr_renum=0");
        }
        //else "에러: SMS 서버와 통신이 불안정합니다.";
    }
    //else "에러: SMS 데이터 입력도중 에러가 발생하였습니다.";
}
?>