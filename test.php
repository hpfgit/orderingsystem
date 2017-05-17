<?php
$pdo = new PDO('mysql:host=localhost;dbname=ordermanagement','root','');
$pdo->query("SET NAMES UTF8");
$sql = "SELECT * FROM `menu` m INNER JOIN `order` o ON m.id IN (o.dishes)";
$stmt = $pdo->query($sql);
foreach ($stmt as $value) {
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}