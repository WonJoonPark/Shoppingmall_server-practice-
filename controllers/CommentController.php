<?php
require 'function.php';


const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "inputcomment":{
            $comment=$req->Comment;
            $productid=$req->ProductId;
            $username=$req->UserName;
            $replynum=$req->ReplyNum; //대댓글의 경우에만
            if(isset($replynum)==TRUE){ //대댓글
                http_response_code(200);
                $tmpresult=getsetid($replynum);
                $setid=$tmpresult['SetId'];
                $ordernum=$tmpresult['OrderNum'];
                $replycount=$tmpresult['RereplyCount'];
                $replyuser=$tmpresult['UserName'];
                $newreplyordernum=$ordernum+$replycount+1;
                modifyordernum($newreplyordernum,$productid); //order를 한칸 씩 조정하기
                setcount($ordernum,$setid,$productid);
                $res->result=inputrereply($comment,$productid,$setid,$username,$replyuser,$newreplyordernum);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message ="대댓글이 입력되었습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            else{ //댓글
                $ordernum=countcomment($productid)+1;
                $setid=$ordernum;
                $res->result=inputreply($comment,$productid,$setid,$username,$ordernum);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message ="댓글이 입력되었습니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
        }
        case "getcomment":{
            $productid=$_GET['ProductId'];
            $res->result=getreply($productid);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message ="조회가 완료되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
        }
        case "paging":{
            $cursor=$_GET['lastcursor'];
            $datasize=$_GET['datasize'];
            $res->result=AllItems($cursor,$datasize);
            $res->lastcursor=$res->result[$datasize-1]['LastCursor'];
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message ="조회가 완료되었습니다.";
            echo json_encode($res, JSON_NUMERIC_CHECK);
        }



    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
