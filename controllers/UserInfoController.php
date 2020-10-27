<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "inserteasyaccount":
            $UserId=$_GET['userid'];
            $res->result=accountcounting($UserId);
            if(count($res->result)>2){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "등록할 수 있는 계좌를 초과하였습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
            }
            else{
                $PurchaseAccount=$req->PurchaseAccount;
                $Bank=$req->Bank;
                $Name=$req->Name;
                $res->result=redundanyaccount($PurchaseAccount,$Bank,$Name,$UserId);
                if(count($res->result)==0){
                    http_response_code(200);
                    $res->result=insertaccount($PurchaseAccount,$Bank,$Name,$UserId);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    $res->message = "간편결제 계좌가 등록되었습니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                }
                else{
                    $res->isSuccess = FALSE;
                    $res->code = 200;
                    $res->message = "이미 등록된 계좌 입니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                }
            }
            break;
        case "lookupeasyaccount":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=lookupaccount($UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deleteeasyaccount":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=deleteaccount($req->PurchaseAccount,$req->Bank,$req->Name,$UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "간편결제 계좌가 삭제되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);

        case "insertrefundaccount":
            $UserId=$_GET['userid'];
            $res->result=refundaccountcounting($UserId);
            if(count($res->result)>2){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "등록할 수 있는 계좌를 초과하였습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
            }
            else{
                $PurchaseAccount=$req->PurchaseAccount;
                $Bank=$req->Bank;
                $Name=$req->Name;
                $res->result=refundredundanyaccount($PurchaseAccount,$Bank,$Name,$UserId);
                if(count($res->result)==0){
                    http_response_code(200);
                    $res->result=insertrefundaccount($PurchaseAccount,$Bank,$Name,$UserId);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    $res->message = "간편결제 계좌가 등록되었습니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                }
                else{
                    $res->isSuccess = FALSE;
                    $res->code = 200;
                    $res->message = "이미 등록된 계좌 입니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                }
            }
            break;
        case "lookuprefundaccount":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=lookuprefundaccount($UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "deleterefundaccount":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=deleterefundaccount($req->PurchaseAccount,$req->Bank,$req->Name,$UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "간편결제 계좌가 삭제되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "insertbodysize":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=insertbodysize($req->Weight,$req->Height,$req->TopSize,$req->BottomSize,$req->ShoesSize,$UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "저장되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        case "lookupbodysize":
            $UserId=$_GET['userid'];
            http_response_code(200);
            $res->result=lookupbodysize($UserId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}