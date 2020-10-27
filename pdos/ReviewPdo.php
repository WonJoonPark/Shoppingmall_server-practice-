<?php
function lookupreview($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT reviewt.Num,product.ProductId,product.ProductName,product.ProductShop,reviewt.Color,reviewt.size,
                    reviewt.ReviewDetail,reviewt.CreateAt FROM product
                JOIN reviewt
                WHERE reviewt.ProductId=product.ProductId AND reviewt.UserId=? AND product.IsDeleted='N' AND reviewt.IsDeleted='N' ;";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function itemreview($ProductId){
    $pdo = pdoSqlConnect();
    $query = "SELECT reviewt.Num,reviewt.UserId,reviewt.Size,reviewt.Color,membership.Height,membership.Weight,
       membership.TopsSize,membership.BottomSize,membership.ShoesSize,reviewt.ReviewDetail,
       reviewt.CreateAt FROM membership
        JOIN reviewt
        WHERE reviewt.ProductId=? AND reviewt.UserId=membership.UserId AND membership.IsDeleted='N' AND reviewt.IsDeleted='N'
        order by CreateAt desc;";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function satisfaction($ProductId){
    $pdo = pdoSqlConnect();
    $query = "SELECT AVG(reviewt.SizeSatisfaction) as SizeSatisfaction ,AVG(reviewt.ColorSatisfaction)as ColorSatisfaction ,AVG(reviewt.QualitySatisfaction) as QualitySatisfaction
                FROM reviewt WHERE ProductId=? AND reviewt.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function delreview($reviewNum){
    $pdo = pdoSqlConnect();
    $query = "UPDATE reviewt SET reviewt.IsDeleted='Y' WHERE reviewt.Num=?;";
    $st = $pdo->prepare($query);
    $st->execute([$reviewNum]);
    $st = null;
    $pdo = null;
}
function insertreview($ProductId,$ReviewDetail,$UserId,$Color,$Size,$SizeSatisfaction,$ColorSatisfaction,$QualitySatisfaction){
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO reviewt(ProductId,ReviewDetail,UserId,Color,Size,SizeSatisfaction,ColorSatisfaction,QualitySatisfaction) values(?,?,?,?,?,?,?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId,$ReviewDetail,$UserId,$Color,$Size,$SizeSatisfaction,$ColorSatisfaction,$QualitySatisfaction]);
    $st = null;
    $pdo = null;   
}
function modifyreview($ReviewDetail,$SizeSatisfaction,$ColorSatisfaction,$QualitySatisfaction,$ReviewNum){
    $pdo = pdoSqlConnect();
    $query = "UPDATE reviewt SET ReviewDetail=?, SizeSatisfaction=?,ColorSatisfaction=?,QualitySatisfaction=?
               WHERE Num=?;";
    $st = $pdo->prepare($query);
    $st->execute([$ReviewDetail,$SizeSatisfaction,$ColorSatisfaction,$QualitySatisfaction,$ReviewNum]);
    $st = null;
    $pdo = null;
}