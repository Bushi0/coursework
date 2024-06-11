<?php
// add_record.php
// Замените 'your_table_name' на фактическое имя вашей таблицы
$tableName = 'audience';

// Получение данных из запроса
$data = json_decode(file_get_contents("php://input"), true);
$inventory = $_POST['inventory'];
$numder_audience = $_POST['numder_audience'];
$name_disciplines = $_POST['name_disciplines'];

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Подготовка SQL-запроса с указанием столбцов
    $stmt = $db->prepare("INSERT INTO $tableName (inventory, numder_audience, name_disciplines) VALUES (:inventory, :numder_audience, :name_disciplines)");
    // Привязка параметров
    $stmt->bindParam(':inventory', $inventory, PDO::PARAM_STR);
    $stmt->bindParam(':numder_audience', $numder_audience, PDO::PARAM_INT);
    $stmt->bindParam(':name_disciplines', $name_disciplines, PDO::PARAM_STR);

    // Выполнение запроса
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Запись успешно добавлена']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Ошибка при добавлении записи: ' . $e->getMessage()]);
}

?>