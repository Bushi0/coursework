<?php
// delete_record.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ваши данные для подключения к базе данных
    $host = 'localhost';
    $dbname = 'war';
    $user = 'postgres';
    $pass = '1212!@';

    // Получение данных из запроса
    $data = json_decode(file_get_contents("php://input"), true);
    $deleteId = $data['delete_id'];
    $tableName = $data['table']; // Получаем имя таблицы

    try {
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Определение соответствующего столбца и таблицы
        $idColumnName = '';
        switch ($tableName) {
            case 'audience':
                $idColumnName = 'number_audience';
                break;
            case 'your_table2':
                $idColumnName = 'your_id_column2';
                break;
            // Добавьте другие таблицы и их столбцы по мере необходимости
        }

        // Проверка, был ли найден соответствующий столбец
        if ($idColumnName) {
            // Используйте правильные имена столбца и таблицы для удаления
            $stmt = $db->prepare("DELETE FROM $tableName WHERE $idColumnName = :deleteId");
            $stmt->bindParam(':deleteId', $deleteId, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Запись успешно удалена']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Не удалось определить соответствующий столбец для удаления']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Ошибка при удалении записи: ' . $e->getMessage()]);
    }
}

?>
