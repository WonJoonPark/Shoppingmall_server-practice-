<?php
require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "gettoken":{
            $granttype="authorization_code";
            $returncode=$req->code;
            $restapikey="7b685e05df491820abc2b9ee509ba521";
            $callbackuri="http://13.125.53.4/kakao_login_callback";
            $url="https://kauth.kakao.com/oauth/token?grant_type=".$granttype."&client_id="
            .$restapikey."&redirect_uri=".$callbackuri."&code=".$returncode;
            $isPost = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $isPost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $loginresponse=curl_exec($ch);
            $status_code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
            curl_close($ch);
            echo $loginresponse;
            break;
        }
        case "getmembership":{
            $accesstoken = $_SERVER["HTTP_X_ACCESS_TOKEN"];
            $url="https://kapi.kakao.com/v2/user/me";

            $isPost = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            //curl_setopt($ch, CURLOPT_POST, $isPost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch,CURLINFO_CONTENT_TYPE,"application/x-www-form-urlencoded;charset=utf-8");
            curl_setopt($ch,CURLOPT_HTTPHEADER,array( "Authorization: Bearer ".$accesstoken));
            $result=json_decode(curl_exec($ch),true);
            curl_close($ch);

            if(!isset($result['id'])){
                $res['isSuccess']=FALSE;
                $res['code']=200;
                $res['message']="토큰 오류 입니다.";
                echo json_encode($res,JSON_NUMERIC_CHECK);
                return;
            }
            if(isalreadykakao($result['kakao_account']['email'])){ //이미 있다면
                $jwt=getJWTokenkakao($result['id'],JWT_SECRET_KEY); // 토큰발급
                //            $res->result->jwt = $jwt;
                $res->result->jwt=$jwt;
                $res->isSuccess=TRUE;
                $res->code=100;
                $res->message="로그인 되었습니다";
                echo json_encode($res,JSON_NUMERIC_CHECK);
                return;
            }
            insertkakaouser($result['id'],$result['kakao_account']['email'],$result['properties']['nickname']);
            $jwt=getJWTokenkakao($result['id'],JWT_SECRET_KEY); // 토큰발급
            $res->result->jwt=$jwt;
            $res->isSuccess=TRUE;
            $res->code=100;
            $res->message="로그인 되었습니다";
            echo json_encode($res,JSON_NUMERIC_CHECK);
            return;
        }
    }
}
catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}