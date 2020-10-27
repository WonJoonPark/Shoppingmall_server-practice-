<?php
function addshop($ShopName,$ShopAddress,$CeoName,$CpoName,$Fax,$EmailAddress,$BusinessLicense,$MailOrderLicense,$ThemeFirst,$ThemeSecond,$TargetAge){
if(empty($CpoName)==TRUE){
    $pdo=pdoSqlConnect();
    $query = "INSERT INTO shopinfo(ShopName,ShopAddress,CeoName,CpoName,Fax,EmailAddress,BusinessLicense,MailOrderLicense,ThemeFirst,ThemeSecond,TargetAge)
              VALUES (?,?,?,NULL,?,?,?,?,?,?,?) ;";
    $st = $pdo->prepare($query);
    $st->execute([$ShopName,$ShopAddress,$CeoName,$Fax,$EmailAddress,$BusinessLicense,$MailOrderLicense,$ThemeFirst,$ThemeSecond,$TargetAge]);
    $st = null;
    $pdo = null;
}
else{
    $pdo=pdoSqlConnect();
    $query = "INSERT INTO shopinfo(ShopName,ShopAddress,CeoName,CpoName,Fax,EmailAddress,BusinessLicense,MailOrderLicense,ThemeFirst,ThemeSecond,TargetAge)
              VALUES (?,?,?,?,?,?,?,?,?,?,?) ;";
    $st = $pdo->prepare($query);
    $st->execute([$ShopName,$ShopAddress,$CeoName,$CpoName,$Fax,$EmailAddress,$BusinessLicense,$MailOrderLicense,$ThemeFirst,$ThemeSecond,$TargetAge]);
    $st = null;
    $pdo = null;
}
}
function deleteshop($ShopName){
    $pdo=pdoSqlConnect();
    $query = "UPDATE shopinfo SET IsDeleted='Y'
              WHERE ShopName=?;";
    $st = $pdo->prepare($query);
    $st->execute([$ShopName]);
    $st = null;
    $pdo = null;
}
function lookupshop($Category,$TargetAge,$Style){
    if($Category=="의류"){
         $pdo = pdoSqlConnect();
         $query = "SELECT shopinfo.ShopName,shopinfo.TargetAge,shopinfo.ThemeFirst,shopinfo.ThemeSecond FROM shopinfo
               JOIN (SELECT ProductShop,sum(DailySale) as sum FROM product
                    WHERE product.IsDeleted='N'
                    group by ProductShop) as SE
                WHERE SE.ProductShop=shopinfo.ShopName AND shopinfo.IsDeleted='N' AND  
                      CONCAT(shopinfo.ThemeFirst,shopinfo.ThemeSecond) LIKE '%$Style%'
                      AND shopinfo.TargetAge=? order by SE.sum desc;";
         $st = $pdo->prepare($query);
         $st->execute([$TargetAge]);
         $st->setFetchMode(PDO::FETCH_ASSOC);
         $res = $st->fetchAll();
         $st = null;
         $pdo = null;
         return $res;
    }
    else{
        $pdo = pdoSqlConnect();
        $query = "SELECT shopinfo.ShopName,shopinfo.TargetAge,shopinfo.ThemeFirst,shopinfo.ThemeSecond FROM shopinfo
               JOIN product
                WHERE product.ProductShop=shopinfo.ShopName AND
                      product.ClothClassification=? AND shopinfo.IsDeleted='N';";
        //페이징 -> 아이템 2개 한페이지 에 띄운다고 가정.
        $st = $pdo->prepare($query);
        $st->execute([$Category]);
        $st->setFetchMode(PDO::FETCH_ASSOC);
        $res = $st->fetchAll();
        $st = null;
        $pdo = null;
        return $res;}
    }
    function addprefershop($ShopName,$UserId){
        $pdo=pdoSqlConnect();
        $query = "INSERT INTO userprefershop(UserId,ShopName)
              VALUES (?,?);";
        $st = $pdo->prepare($query);
        $st->execute([$UserId,$ShopName]);
        $st = null;
        $pdo = null;
    }
    function deleteprefershop($ShopName,$UserId){
        $pdo=pdoSqlConnect();
        $query = "UPDATE userprefershop SET IsDeleted='Y'
              WHERE ShopName=? AND UserId=?;";
        $st = $pdo->prepare($query);
        $st->execute([$ShopName,$UserId]);
        $st = null;
        $pdo = null;
    }
    function lookupprefershop($UserId){
        $pdo = pdoSqlConnect();
        $query = "SELECT shopinfo.ShopName,shopinfo.TargetAge,shopinfo.ThemeFirst,shopinfo.ThemeSecond FROM shopinfo
                  JOIN userprefershop
                  WHERE userprefershop.UserId=? AND userprefershop.ShopName=shopinfo.ShopName AND shopinfo.IsDeleted='N' AND userprefershop.IsDeleted='N'
                  order by userprefershop.CreateAt desc;";
        $st = $pdo->prepare($query);
        $st->execute([$UserId]);
        $st->setFetchMode(PDO::FETCH_ASSOC);
        $res = $st->fetchAll();
        $st = null;
        $pdo = null;
        return $res;
    }