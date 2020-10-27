<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "lookupreview":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=lookupreview($UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "itemreview":
            $ProductId=$_GET['ProductId'];
            http_response_code(200);
            $res->result=itemreview($ProductId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "satisfaction":
            $ProductId=$_GET['ProductId'];
            http_response_code(200);
            $res->result=satisfaction($ProductId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "delreview":
            http_response_code(200);
            $res->result=delreview($req->ReviewNum);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message ="삭제되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "insertreview":
            http_response_code(200);
            $res->result=insertreview($req->ProductId,$req->ReviewDetail,$req->UserId,$req->Color,$req->Size,$req->SizeSatisfaction
                                     ,$req->ColorSatisfaction,$req->QualitySatisfaction);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message ="리뷰가 등록되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "modifyreview":
            http_response_code(200);
            $res->result=modifyreview($req->ReviewDetail,$req->SizeSatisfaction,$req->ColorSatisfaction,$req->QualitySatisfaction,$req->ReviewNum);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message ="수정되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}