<?php

// ATTENTION: NE PAS UTILISER CE CODE EN PRODUCTION
// N'EST PAS SECURISE CONTRE LES INJECTIONS SQL

$pdo = new PDO('mysql:dbname=studi_checkit;host=localhost;charset=utf8mb4', 'root', '');
$id = $_GET['id'];
var_dump($id);
$query = $pdo->query("SELECT * FROM user WHERE id = $id");
$result = $query->fetch(PDO::FETCH_ASSOC);

var_dump($result);
?>
