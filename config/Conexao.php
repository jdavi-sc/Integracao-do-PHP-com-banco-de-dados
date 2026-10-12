<?php

$dsn = "pgsql:host=" . ($_ENV['DB_HOST'] ?? 'localhost') . 
       ";port=" . ($_ENV['DB_PORT'] ?? 5432) . 
       ";dbname=" . ($_ENV['DB_NAME'] ?? '');

$user = $_ENV['DB_USER'] ?? 'postgres';
$pass = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

} catch (PDOException $e) {
    error_log("Erro de conexão com o banco: " . $e->getMessage());
    die("Desculpe, ocorreu um problema ao conectar com o banco de dados.");
}