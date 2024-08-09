<?php
$dsn = 'mysql:host=db;dbname=serverside;charset=utf8';
$username = 'serveruser';
$password = 'gorgonzola7!';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>