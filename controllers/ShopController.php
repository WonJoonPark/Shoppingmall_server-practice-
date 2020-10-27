<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "addshop":
            http_response_code(200);
            $res->result=addshop($req->ShopName,$req->ShopAddress,$req->CeoName,$req->CpoName,$req->Fax,$req->EmailAddress,$req->BusinessLicense,$req->MailOrderLicense,$req->ThemeFirst,$req->ThemeSecond,$req->TargetAge);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "추가되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deleteshop":
            http_response_code(200);
            $res->result=deleteshop($req->ShopName);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "삭제되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "lookupshop":
            $Category=$_GET['Category'];
            $TargetAge=$_GET['TargetAge'];
            $Style=$_GET['Style'];
            http_response_code(200);
            $res->result=lookupshop($Category,$TargetAge,$Style);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "addprefershop":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=addprefershop($req->ShopName,$UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "추가되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deleteprefershop":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=deleteprefershop($req->ShopName,$UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "삭제되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "lookupprefershop":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=lookupprefershop($UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}