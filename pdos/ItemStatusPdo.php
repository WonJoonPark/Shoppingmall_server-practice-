<?php

function insertbasket($UserId,$ProductId,$color,$size,$Quantity){
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO userproductstatus(UserId, ProductId, color, size,OrderStatus, Quantity)
               SELECT * from (SELECT ? AS UserId,?,?,?,100,? AS Quantity) as tem
               WHERE NOT EXISTS(SELECT * FROM userproductstatus
                   WHERE UserId=$UserId AND ProductId=$ProductId AND color=$color AND size=$size AND OrderStatus=100);";
    $st = $pdo->prepare($query);
    $st->execute([$UserId,$ProductId,$color,$size,$Quantity]);
    $st = null;
    $pdo = null;
}
function lookupbasket($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,userproductstatus.color,userproductstatus.size,userproductstatus.Quantity
     FROM product JOIN userproductstatus
     WHERE userproductstatus.UserId=? AND userproductstatus.OrderStatus=100 AND product.ProductId=userproductstatus.ProductId AND product.IsDeleted='N' AND userproductstatus.IsDeleted='N'
     order by userproductstatus.CreateAt desc;";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function deletebasket($UserId,$ProductId,$color,$size){
    $pdo = pdoSqlConnect();
    $query = "UPDATE userproductstatus SET IsDeleted='Y'
              WHERE UserId=? AND ProductId=? AND color=? AND size=? AND OrderStatus=100;";
    $st = $pdo->prepare($query);
    $st->execute([$UserId,$ProductId,$color,$size]);
    $st = null;
    $pdo = null;
}
function insertlikeitem($UserId,$ProductId) ##장바구니나  바로구매와 다르게 컬러, 사이즈 수량은 없음
{   $pdo=pdoSqlConnect();
    $query = "INSERT INTO userproductstatus(UserId, ProductId, color, size,OrderStatus, Quantity)
               SELECT * from (SELECT ? AS UserId,?,NULL AS color,NULL AS size,200,NULL AS Quantity) as tem
               WHERE NOT EXISTS(SELECT * FROM userproductstatus
                   WHERE UserId=$UserId AND ProductId=$ProductId AND OrderStatus=200);";
    $st = $pdo->prepare($query);
    $st->execute([$UserId,$ProductId]);
    $st = null;
    $pdo = null;
}
function deletelikeitem($UserId,$ProductId){
    $pdo=pdoSqlConnect();
    $query = "UPDATE userproductstatus SET IsDeleted='Y'
              WHERE UserId=? AND ProductId=? AND OrderStatus=200;";
    $st = $pdo->prepare($query);
    $st->execute([$UserId,$ProductId]);
    $st = null;
    $pdo = null;
}
function lookuplikeitem($UserId,$Shop){
    $pdo = pdoSqlConnect();
    $query = "SELECT product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo
              FROM product JOIN userproductstatus 
              WHERE userproductstatus.UserId=? AND userproductstatus.OrderStatus=200 AND product.ProductId=userproductstatus.ProductId AND product.IsDeleted='N' AND userproductstatus.IsDeleted='N'
                AND product.ProductShop LIKE '%$Shop%' order by userproductstatus.CreateAt desc; ";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function orderstatus($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,
                     userproductstatus.Quantity,
                     CASE 
                            WHEN userproductstatus.OrderStatus=300
                            THEN '입금대기'
                            WHEN userproductstatus.OrderStatus=310
                            THEN '입금확인'
                            WHEN userproductstatus.OrderStatus=320
                            THEN '배송준비중'
                            WHEN userproductstatus.OrderStatus=330
                            THEN '발송완료'
                            WHEN userproductstatus.OrderStatus=400
                            THEN '배송완료'
                            WHEN userproductstatus.OrderStatus=410
                            THEN '배송완료(리뷰작성완료)'
                            WHEN userproductstatus.OrderStatus=500
                            THEN '반품대기중'
                            WHEN userproductstatus.OrderStatus=510
                            THEN '반품배송중'
                            WHEN userproductstatus.OrderStatus=520
                            THEN '반품완료'
                            WHEN userproductstatus.OrderStatus=320
                            THEN '환불완료'
                        END AS orderstate
                        FROM product JOIN userproductstatus 
                        WHERE product.ProductId=userproductstatus.ProductId AND userproductstatus.UserId=? AND product.IsDeleted='N' AND userproductstatus.IsDeleted='N'
                        AND userproductstatus.OrderStatus between 300 AND 600";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
    function directbuy($UserId,$ProductId,$color,$size,$Quantity){
        $pdo = pdoSqlConnect();
        $query = "INSERT INTO userproductstatus(UserId, ProductId, color, size,OrderStatus, Quantity)
               VALUES(?,?,?,?,250,?);";
        $st = $pdo->prepare($query);
        $st->execute([$UserId,$ProductId,$color,$size,$Quantity]);
        $st = null;
        $pdo = null;
}