<?php

function item($word,$freeship,$maxprice,$minprice,$color,$category,$order,$userid){
    $pdo = pdoSqlConnect();
    if(empty($color)==TRUE){
        switch ($order){
            case 'Week':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.WeeklySale desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'Day':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.DailySale desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'review':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo FROM product
                    JOIN membership, shopinfo, ((SELECT product.ProductId, COUNT(reviewt.ProductId) as c from product
                        LEFT JOIN reviewt ON reviewt.ProductId=product.ProductId AND product.IsDeleted='N'
                        group by product.ProductId) as A)
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$category%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND A.ProductId=product.ProductId AND product.IsDeleted='N'
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=?
                    AND product.ClothClassification LIKE '%$category%'
                    order by A.c desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'new':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.CreateAt desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'highprice':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.Price desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'lowprice':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.Price asc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
        }
    }
    else{
        switch ($order){
            case 'Week':
                        case 'Week':
                            $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo, color
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=?
                    AND color.Color=? AND product.ProductId=color.ProductId AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.WeeklySale desc ;";
                            $st = $pdo->prepare($query);
                            $st->execute([$minprice,$maxprice,$userid,$color]);
                            $st->setFetchMode(PDO::FETCH_ASSOC);
                            $res = $st->fetchAll();
                            $st = null;
                            $pdo = null;
                            return $res;
            case 'Day':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo, color
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=?
                    AND color.Color=? AND product.ProductId=color.ProductId AND product.IsDeleted='N'
                    AND product.ClothClassification LIKE '%$category%' order by product.DailySale desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid,$color]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'review':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo FROM product
                    JOIN membership, shopinfo, color ((SELECT product.ProductId, COUNT(reviewt.ProductId) as c from product
                        LEFT JOIN reviewt ON reviewt.ProductId=product.ProductId AND product.IsDeleted='N' AND reviewt.IsDeleted='N'
                        group by product.ProductId) as A)
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$category%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND A.ProductId=product.ProductId AND product.IsDeleted='N'
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=?
                    AND color.Color=? AND product.ProductId=color.ProductId
                    AND product.ClothClassification LIKE '%$category%'
                    order by A.c desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid,$color]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'new':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo,color
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND color.Color=? AND product.ProductId=color.ProductId
                    AND product.ClothClassification LIKE '%$category%' order by product.CreateAt desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid,$color]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'highprice':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo,color
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND color.Color=? AND product.ProductId=color.ProductId
                    AND product.ClothClassification LIKE '%$category%' order by product.Price desc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid,$color]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
            case 'lowprice':
                $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
                    JOIN membership, shopinfo,color
                    WHERE CONCAT(ProductName,EmplanationInfo,ProductShop,ClothSeason,ClothClassification,Fabric)
                    LIKE '%$word%' AND product.ShipFree LIKE '%$freeship%' AND product.Price between  ? AND ?
                    AND membership.AgeScope=shopinfo.TargetAge AND product.ProductShop=shopinfo.ShopName AND membership.UserId=? AND product.IsDeleted='N'
                    AND color.Color=? AND product.ProductId=color.ProductId
                    AND product.ClothClassification LIKE '%$category%' order by product.Price asc ;";
                $st = $pdo->prepare($query);
                $st->execute([$minprice,$maxprice,$userid,$color]);
                $st->setFetchMode(PDO::FETCH_ASSOC);
                $res = $st->fetchAll();
                $st = null;
                $pdo = null;
                return $res;
        }
    }
}
function storeitem($store)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT product.ProductId ,product.ProductName,product.Price,product.ProductShop,product.EmplanationInfo,product.ShipFree FROM product
              WHERE product.ProductShop=? order by product.UpdateAt desc;";
    $st = $pdo->prepare($query);
    $st->execute([$store]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}



// CREATE
//    function addMaintenance($message){
//        $pdo = pdoSqlConnect();
//        $query = "INSERT INTO MAINTENANCE (MESSAGE) VALUES (?);";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message]);
//
//        $st = null;
//        $pdo = null;
//
//    }


// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }