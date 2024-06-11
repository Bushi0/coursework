<?php
// Ваша конфигурация для подключения к базе данных
$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

// Создание объекта PDO
try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение данных из POST-запроса
    $fullNameCadets = $_POST['fullNameCadets'];
    $fullNameTeachers = $_POST['fullNameTeachers'];
    $point = $_POST['point'];
    $nameDisciplines = $_POST['nameDisciplines'];

    // Выполнение вашей хранимой процедуры
    $stmt = $db->prepare("CALL insertgradeafterexam_8(:p_full_name_cadets, :p_full_name_teachers, :p_point, :p_name_disciplines)");
    $stmt->bindParam(':p_full_name_cadets', $fullNameCadets);
    $stmt->bindParam(':p_full_name_teachers', $fullNameTeachers);
    $stmt->bindParam(':p_point', $point, PDO::PARAM_INT);
    $stmt->bindParam(':p_name_disciplines', $nameDisciplines);

    try {
        $stmt->execute();
        header('Content-Type: application/json'); // Установка заголовка для JSON
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        header('Content-Type: application/json'); // Установка заголовка для JSON
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json'); // Установка заголовка для JSON
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
