<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/29
 * Time: 16:52
 */
$pdo = new PDO('mysql:host=localhost;dbname=ordermanagement','root','');
$pdo->query("SET NAMES UTF8");
$username = $_POST['username'];
$dishes = $_POST['dishes'];
$sql = "SELECT `id` FROM `userordering` WHERE `username`=? AND `dishes`=?";
$stmt = $pdo->prepare($sql);
$stmt->execute(array($username,$dishes));
$row = $stmt->rowCount();
if ($row) {
    $sql = "DELETE FROM `userordering` WHERE `username`=? AND `dishes`=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($username,$dishes));
    $row = $stmt->rowCount();
    if ($row) {
        echo '{"status":"successd"}';
    } else {
        echo '{"status":"errord"}';
    }
}