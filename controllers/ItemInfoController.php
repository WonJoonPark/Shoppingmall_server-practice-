<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case"lookupsize":
            $ProductId=$_GET['ProductId'];
            http_response_code(200);
            $res->result=lookupsize($ProductId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case"insertsize":
            http_response_code(200);
            $res->result=insertsize($req->ProductId,$req->Size);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message="추가 되었습니다";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deletesize":
            http_response_code(200);
            $res->result=deletesize($req->ProductId,$req->Size);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message="삭제 되었습니다";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case"lookupcolor":
            $ProductId=$_GET['ProductId'];
            http_response_code(200);
            $res->result=lookupcolor($ProductId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case"insertcolor":
            http_response_code(200);
            $res->result=insertcolor($req->ProductId,$req->Color);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message="추가 되었습니다";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deletecolor":
            http_response_code(200);
            $res->result=deletecolor($req->ProductId,$req->Color);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message="삭제 되었습니다";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}