<?php
$str = $_POST["str"];
$pdo = new PDO('mysql:host=localhost;dbname=ordermanagement','root','');
$pdo->query("SET NAMES UTF8");
$sql = "SELECT `id` FROM `order` WHERE `state`=0";
$stmt = $pdo->query($sql);
if ($stmt) {
    $sql = "UPDATE `order` SET `state`=1 WHERE `id` IN ({$str})";
//    $stmt = $pdo->prepare($sql);
//    $stmt->execute(array($str));
//    $row = $stmt->rowCount();
    $stmt = $pdo->query($sql);
    if ($stmt) {
        echo '{"status":"success"}';
    } else {
        echo '{"status":"error"}';
    }
}