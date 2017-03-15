<?

Class STREAM {
    function SendToServer($src,$href){
        $res = '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CRLF, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $src);
        curl_setopt($ch, CURLOPT_URL, $href);
        $data = curl_exec($ch);
        return $data;
        curl_close($ch);
    }
    function GetBalance($user,$pass){
        $src = '<?xml version="1.0" encoding="utf-8"?><request><security><login value="'.$user.'" /><password value="'.$pass.'" /></security></request>';
        $href = 'http://web.szk-info.ru/xml/balance.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        return array(
            "money" => $vals[1]['value'],
            "curr" => $vals[1]['attributes']['CURRENCY']
        );
    }
    function SendSms($phone,$text,$sender,$user,$pass){
        $src = '<?xml version="1.0" encoding="utf-8" ?>
	<request>
	<message>
    <sender>'.$sender.'</sender>
    <text>'.$text.'</text>'.$phone.'</message>
	<security>
    <login value="'.$user.'" />
    <password value="'.$pass.'" />
	</security>
	</request>';


        $href = 'http://web.szk-info.ru/xml/';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=3;
        $idsms=$vals[1]['attributes']['ID_SMS'];
        $idsms1=$vals[1]['attributes']['ID_SMS'];
        while ($vals[$x]['tag']=='INFORMATION')
        {
            $idsms.="\n".$vals[$x]['attributes']['ID_SMS'];
            $idsms1.=",".$vals[$x]['attributes']['ID_SMS'];
            $x=$x+2;
        }
        return array(
            "idsms" => $idsms,
            "idsms1" => $idsms1
        );

    }
    function GetStatys($user,$pass,$ID_SMS){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>

	<security>

     <login value="'.$user.'" />

     <password value="'.$pass.'" />

	</security>

	<get_state>'.$ID_SMS .'</get_state>

	</request>';

        $href = 'http://web.szk-info.ru/xml/state.php';

        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals,$index);
        xml_parser_free($p);
        $x=3;
        $state=$vals[1]['value'];
        while ($vals[$x]['tag']=='STATE')
        {
            $state.="\n".$vals[$x]['value'];
            $x=$x+2;
        }
        return array(
            "state" => $state
        );


    }
    function GetSenders($user,$pass){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>

	<request>

	<security>

     <login value="'.$user.'"/>

     <password value="'.$pass.'"/>

	</security>

	</request>';
        $href = 'http://web.szk-info.ru/xml/originator.php';

        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);

        $x=3;
        while ($vals[$x]['tag']=='ORIGINATOR')
        {
            $Senders.=$vals[$x]['value']."\n";
            $x++;
        }
        return array(
            "Senders" => $Senders
        );

    }
    function GetSms($user,$pass,$time_s,$time_e){
        $src = '<?xml version="1.0" encoding="utf-8"?>
	<request>
	<security>
	<login value="'.$user.'" />
    <password value="'.$pass.'" />
	</security>
	<time start="'.$time_s.'" end="'.$time_e.'" />
	</request>';
        $href = 'http://web.szk-info.ru/xml/incoming.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);

        $x=1;
        while ($vals[$x]['tag']=='SMS')
        {
            $smsget.=$vals[$x]['attributes']['ID_SMS']."\n".$vals[$x]['attributes']['DATE_RECEIVE']."\n".$vals[$x]['attributes']['ORIGINATOR']."\n".$vals[$x]['attributes']['PREFIX']."\n".$vals[$x]['attributes']['PHONE']."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['value'])."\n\n";
            $x++;
        }
        return array(
            "SmsGet" => $smsget
        );


    }
    function GetInfoNum($user,$pass,$phoneinfo){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<phones>'.$phoneinfo.'</phones>
	</request>';
        $href = 'http://web.szk-info.ru/xml/def.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $res=$data;
        $x=1;
        while ($vals[$x]['tag']=='PHONE')
        {
            $operator.=$vals[$x]['value']."\n".$vals[$x]['attributes']['OPERATOR']."\n".$vals[$x]['attributes']['REGION']."\n".$vals[$x]['attributes']['TIME_ZONE']."\n\n";
            $x++;
        }
        return array(
            "operator" => $operator,
            "clock"=> $vals[1]['attributes']['REGION']."(".$vals[1]['attributes']['TIME_ZONE'].")"
        );

    }
    function GetBaza($user,$pass){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	</request>';
        $href = 'http://web.szk-info.ru/xml/list_bases.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=1;
        while ($vals[$x]['tag']=='BASE')
        {
            $id_daza.=$vals[$x]['attributes']['ID_BASE']."\n".$vals[$x]['attributes']['NAME_BASE']."\n".$vals[$x]['attributes']['TIME_BIRTH']."\n".$vals[$x]['attributes']['LOCAL_TIME_BIRTH']."\n".$vals[$x]['attributes']['ORIGINATOR_BIRTH']."\n".$vals[$x]['attributes']['ON_BIRTH']."\n\n";
            $x++;
        }
        return array(
            "ID_BASE" => $id_daza
        );
    }
    function GetChangeParamBaza($user,$pass,$id_base,$name_base,$time_birth,$local_time_birth,$originator_birth,$on_birth,$number_base,$textbithd){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
 <request>
 <security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
 </security>
 <bases>
 <base id_base="'.$id_base.'" name_base="'.$name_base.'" time_birth="'.$time_birth.'" local_time_birth="'.$local_time_birth.'" originator_birth="'.$originator_birth.'" on_birth="'.$on_birth.'">'.$textbithd.'</base>
     </bases>
 </request>';
        $href = 'http://web.szk-info.ru/xml/test.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $GetChangeParamBaza=$vals[1]['value'];
        return array(
            "GetChangeParamBaza" => $GetChangeParamBaza
        );
    }
    function GetListPhoneBaza($user,$pass,$id_base,$page){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<base id_base="'.$id_base.'" page="'.$page.'"/>
	</request>';
        $href = 'http://web.szk-info.ru/xml/list_phones.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=2;

        while ($vals[$x]['tag']=='PHONE')
        {
            $ListPhoneBaza.=$vals[$x]['attributes']['PHONE']."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['REGION'])."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['OPERATOR'])."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['NAME'])."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['SURNAME'])."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['PATRONYMIC'])."\n".$vals[$x]['attributes']['DATE_BIRTH']."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['MALE'])."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['ADDITION_1'])."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['ADDITION_2'])."\n\n";
            $x++;
        }
        return array(
            "ListPhoneBaza" => $ListPhoneBaza
        );

    }
    function GetChangeAbonentBaza($user,$pass,$id_base,$phonebaze,$region,$operator,$name,$surname,$patronymic,$date_birth,$male,$addition_1,$addition_2){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<base id_base="'.$id_base.'">
       <phone phone="'.$phonebaze.'" region="'.$region.'" operator="'.$operator.'" name="'.$name.'" surname="'.$surname.'" patronymic="'.$patronymic.'" date_birth="'.$date_birth.'" male="'.$male.'" addition_1="'.$addition_1.'" addition_2="'.$addition_2.'" />
    </base>
	</request>';
        $href = 'http://web.szk-info.ru/xml/phones.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=2;
        while ($vals[$x]['tag']=='PHONE')
        {
            $GetChangeAbonentBaza.=$vals[$x]['attributes']['PHONE']."\n".$vals[$x]['attributes']['NUMBER_PHONE']."\n".$vals[$x]['value']."\n\n";
            $x++;
        }
        return array(
            "GetChangeAbonentBaza" => $GetChangeAbonentBaza
        );

    }
    function GetDeletePhonesBaza($user,$pass,$id_base,$phonedelph){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<base id_base="'.$id_base.'">
       <phone phone="'.$phonedelph.'" action="delete" />
    </base>
	</request>';
        $href = 'http://web.szk-info.ru/xml/phones.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $GetDeletePhonesBaza="-".$vals[2]['attributes']['PHONE'];
        return array(
            "GetDeletePhonesBaza" => $GetDeletePhonesBaza
        );
    }
    function GetStopList($user,$pass){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	</request>';
        $href = 'http://web.szk-info.ru/xml/list_stop.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=1;
        while ($vals[$x]['tag']=='PHONE')
        {
            $Stop.=$vals[$x]['value']."\n";
            $x++;
        }
        return array(
            "Stop" => $Stop
        );
    }
    function GetDeleteStopList($user,$pass,$phone_add,$phone_del){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<add_stop>
       <phone phone="'.$phone_add.'" />
    </add_stop>
	<delete_stop>
        <phone phone="'.$phone_del.'" />
	</delete_stop>
	</request>';
        $href = 'http://web.szk-info.ru/xml/stop.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=1;
        while ($vals[$x]['tag']=='PHONE')
        {
            $StopChage.=$vals[$x]['attributes']['PHONE']." - ".$vals[$x]['value']."\n";
            $x++;
        }
        return array(
            "StopChage" => $StopChage
        );
    }
    function GetPlanSms($user,$pass,$page){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<scheduled page="'.$page.'"/>
	</request>';
        $href = 'http://web.szk-info.ru/xml/list_scheduled.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);

        $x=2;
        while ($vals[$x]['tag']=='SCHEDULED')
        {
            $PlanSms.=$vals[$x]['attributes']['ID_SMS']."\n".$vals[$x]['attributes']['TIME_PUT_TURN']."\n".$vals[$x]['attributes']['ORIGINATOR']."\n".$vals[$x]['attributes']['PHONE']."\n".$vals[$x]['attributes']['TYPE_SMS']."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['TEXT_SMS'])."\n".$vals[$x]['attributes']['COUNT_SMS']."\n".iconv("UTF-8","WINDOWS-1251",$vals[$x]['attributes']['NAME_DELIVERY'])."\n".$vals[$x]['attributes']['TIME_SEND']."\n".$vals[$x]['attributes']['VALIDITY_PERIOD']."\n\n";
            $x++;
        }
        return array(
            "PlanSms" => $PlanSms
        );
    }
    function GetDeletePlanSms($user,$pass,$IDSMS){
        $src = '<?xml  version="1.0" encoding="utf-8" ?>
	<request>
	<security>
     <login value="'.$user.'" />
     <password value="'.$pass.'" />
	</security>
	<delete_schedule>
       <schedule id_sms="'.$IDSMS.'" />
    </delete_schedule>
	</request>';
        $href = 'http://web.szk-info.ru/xml/scheduled.php';
        $data = $this->SendToServer($src,$href);
        $res=$data;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $res, $vals);
        xml_parser_free($p);
        $x=1;
        while ($vals[$x]['tag']=='SCHEDULED')
        {
            $DeletePlanSms.=$vals[$x]['attributes']['ID_SMS']." - ".$vals[$x]['value']."\n";
            $x++;
        }
        return array(
            "DeletePlanSms" => $DeletePlanSms
        );
    }
}


function sendsms($phoneuser,$textsms){

    $stream = new STREAM();
    //Логин
    $user = 'stolnik';
    //Пароль
    $pass = 'Stolnik100';
    //Массив с номерами, на которые будет отправлено СМС.
    $da = array(
        '77777777777');
    $j=1;
    foreach ($da as $s)
    {
        $phone.='<abonent phone="'.$phoneuser.'" number_sms="'.$j.'" />';
        $j++;
    }
    //Текст сообщения
    $text = $textsms;
    //Имя отправителя
    $sender = 'Stolnik';
    $p=0;
    foreach ($da as $s)
    {
        $phoneinfo.='<phone>'.$phoneuser.'</phone>';
        $p++;
    }
    //Отправка смс
    $result = $stream->SendSms($phone,iconv("WINDOWS-1251","UTF-8",$text),$sender,$user,$pass);

}
?>