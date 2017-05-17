<?php
echo header("content-type:text/html;charset=utf-8");
$username = "郝鹏飞";
$dishes = $_POST['dishes'];
$total = $_POST['total'];
$num = $_POST['num'];
$pdo = new PDO('mysql:host=localhost;dbname=ordermanagement','root','');
$pdo->query("SET NAMES UTF8");
$sql = "SELECT `id` FROM `userordering` WHERE `username`=? AND `dishes`=?";
$stmt = $pdo->prepare($sql);
$stmt->execute(array($username,$dishes));
$row = $stmt->rowCount();
if ($row) {
    $sql = "UPDATE `userordering` SET `number`=number+1 WHERE `username`=? AND `dishes`=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($username,$dishes));
    $row = $stmt->rowCount();
    if ($row) {
        echo '{"status":"successu"}';
    } else {
        echo '{"status":"error"}';
    }
} else {
    $sql = "INSERT INTO `userordering` (`username`,`dishes`,`number`,`total`) VALUES  (?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($username,$dishes,$num,$total));
    $row  = $stmt->rowCount();
    if ($row) {
        echo '{"status":"successi"}';
    } else {
        echo '{"status":"error"}';
    }
}
