<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Проверяем, авторизован ли пользователь
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
        header('Location: index.php'); // Если не авторизован или не администратор, перенаправляем на страницу входа
        exit;
    }

    // Функция для обновления записи в таблице
    function updateRecord($db, $tableName, $idColumnName, $editId)
    {
        $columns = getTableColumns($db, $tableName);
        $setClauses = array_map(fn($column) => "$column = :$column", $columns);
        $setClausesStr = implode(', ', $setClauses);

        try {
            $stmt = $db->prepare("UPDATE $tableName SET $setClausesStr WHERE $idColumnName = :editId");
            $stmt->bindParam(':editId', $editId, PDO::PARAM_INT);
            
            foreach ($columns as $column) {
                $stmt->bindParam(":$column", $_POST[$column]);
            }

            $stmt->execute();
            echo "success";
        } catch (PDOException $e) {
            echo "error";
        }
    }

    // Получаем данные из POST-запроса
    if (isset($_POST['update_record'])) {
        $tableName = $_POST['table_name'];
        $editId = $_POST['edit_id'];
        $idColumnName = getIdColumnName($tableName);
        updateRecord($db, $tableName, $idColumnName, $editId);
    }

} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

function getIdColumnName($tableName)
{
    switch ($tableName) {
        case 'cadets':
            return 'id_cadets';
        case 'disciplines':
            return 'name_disciplines';
        case 'teachers':
            return 'id_teachers';
        case 'audience':
            return 'number_audience';
        case 'it_has':
            return 'id_platoon';
        case 'schedule':
            return 'id_schedule';
        case 'estimates':
            return 'id_point';
        default:
            return ''; // Вернуть пустую строку или другое значение по умолчанию
    }
}

function getTableColumns($db, $tableName)
{
    $stmt = $db->query("SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName'");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
