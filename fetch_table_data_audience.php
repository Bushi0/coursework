<?php
// fetch_table_data_audience.php

// Ваша конфигурация для подключения к базе данных
$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

// Получение имени таблицы из запроса
$data = json_decode(file_get_contents("php://input"), true);
$tableName = $data['table'];

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ваш код для выполнения запроса к базе данных
    // Здесь просто пример, как можно получить данные
    $stmt = $db->query("SELECT * FROM $tableName");
    $tableData = "<h2>Таблица $tableName</h2><table border='1'>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tableData .= "<tr>";
        foreach ($row as $value) {
            $tableData .= "<td>$value</td>";
        }
        $tableData .= "</tr>";
    }
    $tableData .= "</table>";

    // Отправка данных обратно в JavaScript в формате JSON
    echo json_encode(['tableData' => $tableData]);

} catch (PDOException $e) {
    // Отправка сообщения об ошибке в формате JSON
    echo json_encode(['error' => 'Ошибка: ' . $e->getMessage()]);
}
?>
