<?php
function insertaccount($PurchaseAccount,$Bank,$Name,$UserId){
    $pdo=pdoSqlConnect();
    $query = "INSERT INTO easyaccount(PurchaseAccount,Bank,Name,UserId)
              VALUES (?,?,?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$PurchaseAccount,$Bank,$Name,$UserId]);
    $st = null;
    $pdo = null;
}
function accountcounting($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT * from easyaccount
                WHERE UserId=? AND easyaccount.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function redundanyaccount($PurchaseAccount,$Bank,$Name,$UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT * from easyaccount
                WHERE PurchaseAccount=? AND Bank=? AND Name=? AND UserId=? AND easyaccount.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$PurchaseAccount,$Bank,$Name,$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function lookupaccount($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT Num,CreateAt,UserId,PurchaseAccount,Bank,Name from easyaccount
                WHERE UserId=? AND easyaccount.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function deleteaccount($PurchaseAccount,$Bank,$Name,$UserId){
    $pdo=pdoSqlConnect();
    $query = "UPDATE easyaccount SET IsDeleted='Y'
                WHERE PurchaseAccount=? AND Bank=? AND Name=? AND UserId=?;";
    $st = $pdo->prepare($query);
    $st->execute([$PurchaseAccount,$Bank,$Name,$UserId]);
    $st = null;
    $pdo = null;
}

function insertrefundaccount($PurchaseAccount,$Bank,$Name,$UserId){
    $pdo=pdoSqlConnect();
    $query = "INSERT INTO refundaccount(PurchaseAccount,Bank,Name,UserId)
              VALUES (?,?,?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$PurchaseAccount,$Bank,$Name,$UserId]);
    $st = null;
    $pdo = null;
}
function refundaccountcounting($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT * from refundaccount
                WHERE UserId=? AND refundaccount.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function refundredundanyaccount($PurchaseAccount,$Bank,$Name,$UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT * from refundaccount
                WHERE PurchaseAccount=? AND Bank=? AND Name=? AND UserId=? AND refundaccount.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$PurchaseAccount,$Bank,$Name,$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function lookuprefundaccount($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT Num,CreateAt,UserId,PurchaseAccount,Bank,Name from refundaccount
                WHERE UserId=? AND refundaccount.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function deleterefundaccount($PurchaseAccount,$Bank,$Name,$UserId){
    $pdo=pdoSqlConnect();
    $query = "UPDATE refundaccount SET IsDeleted='Y'
                WHERE PurchaseAccount=? AND Bank=? AND Name=? AND UserId=?;";
    $st = $pdo->prepare($query);
    $st->execute([$PurchaseAccount,$Bank,$Name,$UserId]);
    $st = null;
    $pdo = null;
}
function insertbodysize($Weight,$Height,$TopSize,$BottomSize,$ShoesSize,$UserId){
    $pdo=pdoSqlConnect();
    $query = "UPDATE membership SET Weight=?,Height=?,TopsSize=?,BottomSize=?,ShoesSize=?
                WHERE  UserId=? AND membership.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$Weight,$Height,$TopSize,$BottomSize,$ShoesSize,$UserId]);
    $st = null;
    $pdo = null;
}
function lookupbodysize($UserId){
    $pdo = pdoSqlConnect();
    $query = "SELECT Weight,Height,TopsSize,BottomSize,ShoesSize from membership
                WHERE UserId=? AND membership.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$UserId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}