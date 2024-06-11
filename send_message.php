<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $message = $_POST['message'];
    $sender = $_POST['sender']; // Получаем отправителя из скрытого поля формы
    $receiver = $_POST['receiver']; // Получаем получателя из скрытого поля формы

    // Подключение к базе данных
    $host = 'localhost';
    $dbname = 'war';
    $user = 'postgres';
    $pass = '1212!@';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Подготовка SQL запроса для вставки сообщения в базу данных
        $sql = "INSERT INTO messages (sender, receiver, message_text) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // Выполнение запроса с передачей параметров
        if ($stmt->execute([$sender, $receiver, $message])) {
            echo "Сообщение успешно отправлено";
        } else {
            echo "Ошибка при выполнении запроса: ";
            print_r($stmt->errorInfo());
        }

    } catch (PDOException $e) {
        echo "Ошибка при отправке сообщения: " . $e->getMessage();
    }
} else {
    echo "Доступ запрещен";
}
?>
