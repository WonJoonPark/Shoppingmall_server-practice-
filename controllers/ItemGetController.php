<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "item":
            $keyword=$_GET['keyword'];
            $userid=$_GET['userid'];
            $word='';
            $freeship='';
            $minprice=100;
            $maxprice=999999;
            $color='';
            $category='';
            $order='Day';
            switch($keyword){
                case "search":
                    $word=$_GET['word'];
                    $freeship=$_GET['freeship'];
                    $minprice=$_GET['minprice'];
                    $maxprice=$_GET['maxprice'];
                    $color=$_GET['color'];
                    $category=$_GET['category'];
                    $res->result=item($word,$freeship,$maxprice,$minprice,$color,$category,$order,$userid);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                case "home":
                    $res->result=item($word,$freeship,$maxprice,$minprice,$color,$category,$order,$userid);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                case "best" :
                    $category=$_GET['category'];
                    $order=$_GET['order'];
                    $res->result=item($word,$freeship,$maxprice,$minprice,$color,$category,$order,$userid);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                case "classification":
                    $order=$_GET['order'];
                    $freeship=$_GET['freeship'];
                    $minprice=$_GET['minprice'];
                    $maxprice=$_GET['maxprice'];
                    $color=$_GET['color'];
                    $category=$_GET['category'];
                    $res->result=item($word,$freeship,$maxprice,$minprice,$color,$category,$order,$userid);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                case "store":
                    $store=$_GET['store'];
                    http_response_code(200);
                    $res->result = storeitem($store);
                    $res->isSuccess = TRUE;
                    $res->code = 100;
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
            }
            break;

        /*
         * API No. 0
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
