<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "insertbasket":
            http_response_code(200);
            $res->result=insertbasket($req->UserId,$req->ProductId,$req->color,$req->size,$req->Quantity);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "lookupbasket": ## orderstatus=100 //장바구니상품
            http_response_code(200);
            $userid=$_GET['userid'];
            $res->result=lookupbasket($userid);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deletebasket":
            http_response_code(200);
            $res->result=deletebasket($req->UserId,$req->ProductId,$req->color,$req->size);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "insertlikeitem":
            http_response_code(200);
            $res->result=insertlikeitem($req->UserId,$req->ProductId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "찜한 아이템에 추가했어요";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deletelikeitem":
            http_response_code(200);
            $res->result=deletelikeitem($req->UserId,$req->ProductId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "삭제되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "lookuplikeitem":
            $UserId=$_GET['userid'];
            $Shop=$_GET['shop'];
            http_response_code(200);
            $res->result=lookuplikeitem($UserId,$Shop);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "orderstatus":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=orderstatus($UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "directbuy" :
            http_response_code(200);
            $res->result=directbuy($req->UserId,$req->ProductId,$req->color,$req->size,$req->Quantity);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}