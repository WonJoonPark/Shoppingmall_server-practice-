<?php
function lookupsize($ProductId){
    $pdo = pdoSqlConnect();
    $query = "SELECT ProductId,Size FROM size
                WHERE ProductId=? AND size.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function insertsize($ProductId,$Size){
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO size(ProductId,Size) VALUES (?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId,$Size]);
    $st = null;
    $pdo = null;
}
function deletesize($ProductId,$Size){
    $pdo = pdoSqlConnect();
    $query = "UPDATE size SET IsDeleted='Y'
              WHERE ProductId=? AND Size=?;";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId,$Size]);
    $st = null;
    $pdo = null;
}
function lookupcolor($ProductId){
    $pdo = pdoSqlConnect();
    $query = "SELECT ProductId,Color FROM color
                WHERE ProductId=? AND color.IsDeleted='N';";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}
function insertcolor($ProductId,$Color){
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO color(ProductId,Color) VALUES (?,?);";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId,$Color]);
    $st = null;
    $pdo = null;
}
function deletecolor($ProductId,$Color){
    $pdo = pdoSqlConnect();
    $query = "UPDATE color SET IsDeleted='Y'
              WHERE ProductId=? AND Color=?;";
    $st = $pdo->prepare($query);
    $st->execute([$ProductId,$Color]);
    $st = null;
    $pdo = null;
}