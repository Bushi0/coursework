<?php
// update_audience_inventory.php

// Ваша конфигурация для подключения к базе данных
$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

// Получение данных из запроса
$data = json_decode(file_get_contents("php://input"), true);

// Проверяем, есть ли необходимые данные в запросе
if (isset($data['number_audience']) && isset($data['new_inventory'])) {
    $number_audience = $data['number_audience'];
    $new_inventory = $data['new_inventory'];

    try {
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ваш код для выполнения запроса к базе данных для обновления инвентаря
        $stmt = $db->prepare("UPDATE audience SET inventory = :new_inventory WHERE number_audience = :number_audience");
        $stmt->bindParam(':new_inventory', $new_inventory);
        $stmt->bindParam(':number_audience', $number_audience);
        $stmt->execute();

        // Отправка успешного ответа в JavaScript
        echo json_encode(['success' => true, 'message' => 'Данные успешно обновлены']);

    } catch (PDOException $e) {
        // Отправка сообщения об ошибке в JavaScript
        echo json_encode(['success' => false, 'error' => 'Ошибка при обновлении данных: ' . $e->getMessage()]);
    }
} else {
    // Если не хватает данных, отправляем сообщение об ошибке в JavaScript
    echo json_encode(['success' => false, 'error' => 'Отсутствуют необходимые данные для обновления']);
}
?>
