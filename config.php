<?php
$host = 'localhost';
$port = '5432';
$user = 'postgres';
$password = '1212!@'; // замените на ваш пароль к БД
$dbname = 'war'; // замените на ваше название БД
$charset = 'utf8mb4';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
