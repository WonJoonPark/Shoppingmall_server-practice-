<?php
function countcomment($productid){
    $pdo = pdoSqlConnect();
    $query = "SELECT *  FROM reply
                WHERE ProductId=?;";
    $st = $pdo->prepare($query);
    $st->execute([$productid]);
    $row = $st->rowCount();
    $st=NULL;
    $pdo=NULL;
    return $row;
}
function inputreply($comment,$productid,$setid,$username,$ordernum){
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO reply(Reply,ProductId,SetId,UserName,OrderNum) VALUES (?,?,?,?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$comment,$productid,$setid,$username,$ordernum]);
    $st = null;
    $pdo = null;
}
function inputrereply($comment,$productid,$setid,$username,$replyuser,$newreplyordernum){
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO reply(Reply,ProductId,SetId,UserName,ReplyUser,OrderNum) VALUES (?,?,?,?,?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$comment,$productid,$setid,$username,$replyuser,$newreplyordernum]);
    $st = null;
    $pdo = null;
}

function getsetid($replynum){
    $pdo = pdoSqlConnect();
    $query = "SELECT OrderNum,SetId,RereplyCount,UserName FROM reply
                    WHERE reply.ReplyNum=?;";
    $st = $pdo->prepare($query);
    $st->execute([$replynum]);
    while($res=$st->fetch(PDO::FETCH_ASSOC)){
        $st = null;
        $pdo = null;
        return $res;
    }
}
function modifyordernum($newreplyordernum,$productid){
    $pdo = pdoSqlConnect();
    $query = "UPDATE reply set OrderNum=OrderNum+1
                WHERE OrderNum>=? AND ProductId=?;";
    $st = $pdo->prepare($query);
    $st->execute([$newreplyordernum,$productid]);
    $st = null;
    $pdo = null;
}
function setcount($ordernum,$setid,$productid){
    $pdo = pdoSqlConnect();
    $query = "UPDATE reply set RereplyCount=RereplyCount+1
                WHERE OrderNum<=? AND SetId=? AND ProductId=?;";
    $st = $pdo->prepare($query);
    $st->execute([$ordernum,$setid,$productid]);
    $st = null;
    $pdo = null;
}
function getreply($productid){
    $pdo = pdoSqlConnect();
    $query = "SELECT ReplyNum,Reply,SetId,UserName,ReplyUser,OrderNum,RereplyCount FROM reply
                WHERE ProductId=? order by OrderNum asc;";
    $st = $pdo->prepare($query);
    $st->execute([$productid]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function AllItems($cursor,$datasize){
    // Price + ProductId -> Cursor
    // (Price을 기준으로 정렬을 하고 싶다)
    // ProductId - PK  8자리
    // Price - 5자리 (최대)
    if(ISSET($cursor)){
    $pdo = pdoSqlConnect();
    $query = "SELECT ProductId,CreateAt,CONCAT(LPAD(Price,5,'0'),LPAD(ProductId,8,'0')) as LastCursor FROM product
                WHERE CONCAT(LPAD(Price,5,'0'),LPAD(ProductId,8,'0')) > ?
                order by Price asc,ProductId asc LIMIT $datasize;";
    $st = $pdo->prepare($query);
    $st->execute([$cursor]); //왜 여기다 넣으면 오류가 ??
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;}
    else{
        $pdo = pdoSqlConnect();
        $query = "SELECT ProductId,CreateAt,CONCAT(LPAD(Price,5,'0'),LPAD(ProductId,8,'0')) as LastCursor FROM product
                order by Price asc,ProductId asc LIMIT $datasize;";
        $st = $pdo->prepare($query);
        $st->execute([]);
        $st->setFetchMode(PDO::FETCH_ASSOC);
        $res = $st->fetchAll();
        $st = null;
        $pdo = null;
        return $res;
    }
}