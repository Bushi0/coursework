<?php
// Подключение к базе данных
try {
    $pdo = new PDO('pgsql:host=localhost;dbname=war', 'postgres', '1212!@');
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

// Запрос на получение пользователей
$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Возвращаем результат в формате JSON
echo json_encode($users);
?>
