<?php
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

    $stmt = null;

    if ($tableName === 'estimates') {
        // Если выбрана таблица 'estimates', добавляем столбцы full_name_cadets и full_name_teachers
        $stmt = $db->prepare("SELECT estimates.*, 
                                    cadets.full_name_cadets AS Полное_Имя_Курсанта,
                                    teachers.full_name_teachers AS Полное_Имя_Преподавателя
                             FROM estimates 
                             LEFT JOIN cadets ON estimates.id_cadets = cadets.id_cadets
                             LEFT JOIN teachers ON estimates.id_teachers = teachers.id_teachers");
    } elseif ($tableName === 'schedule') {
        // Если выбрана таблица 'schedule', добавляем столбец full_name_teachers и исключаем столбец id_schedule
        $stmt = $db->prepare("SELECT schedule.*, 
                                    teachers.full_name_teachers AS Полное_Имя_Преподавателя
                             FROM schedule 
                             LEFT JOIN teachers ON schedule.id_teachers = teachers.id_teachers");
    } else {
        // Для других таблиц выбираем все столбцы без изменений
        $stmt = $db->prepare("SELECT * FROM $tableName");
    }
    
    $stmt->execute();
    
    $tableData = "<table border='1'><tr>";
    
    // Получение заголовков столбцов
    $columns = [];
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $col = $stmt->getColumnMeta($i);
        // Исключаем столбец id_point из заголовка($col['name'] !== 'id_schedule')
        if ($col['name'] !== 'id_schedule' && $col['name'] !== 'id_point' && $col['name'] !== 'id_cadets' && $col['name'] !== 'id_teachers') {
            // Заменяем английские названия столбцов на соответствующие русские
            switch ($col['name']) {

                case 'date':
                    $columns[] = 'Дата';
                    break;
                case 'full_name_cadets':
                    $columns[] = 'ФИО курсанта';
                    break;
                case 'full_platoon_name':
                    $columns[] = 'Название_взвода';
                    break;
                case 'rank':
                    $columns[] = 'Звание';
                    break;
                case 'inventory':
                    $columns[] = 'Инвентарь';
                    break;
                case 'number_audience':
                    $columns[] = 'Номер_аудитории';
                    break;
                case 'name_disciplines':
                    $columns[] = 'Дисциплина';
                    break;
                case 'id_platoon':
                    $columns[] = 'Номер_взвода';
                    break;
                case 'day_of_the_week':
                    $columns[] = 'Дата';
                    break;
                case 'time':
                    $columns[] = 'Время';
                    break;
                case 'semester':
                    $columns[] = 'Семестр';
                    break;
                case 'point':
                    $columns[] = 'Балл';
                    break;
                case 'type':
                    $columns[] = 'Тип';
                    break;
                default:
                    $columns[] = $col['name'];
            }
            $tableData .= "<th>{$columns[count($columns) - 1]}</th>";
        }
    }
    $tableData .= "</tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tableData .= "<tr>";
        foreach ($row as $key => $value) {
            // Исключаем столбец id_schedule, id_point, id_cadets и id_teachers из данных
            if ($key !== 'id_schedule' && $key !== 'id_point' && $key !== 'id_cadets' && $key !== 'id_teachers') {
                $tableData .= "<td>$value</td>";
            }
        }
        $tableData .= "</tr>";
    }
    
    $tableData .= "</table>";
    
    // Отправка данных обратно в JavaScript
    header('Content-Type: application/json'); // Добавлен заголовок для указания типа контента
    echo json_encode(['tableData' => $tableData, 'columns' => $columns]);
    

} catch (PDOException $e) {
    header('Content-Type: application/json'); // Добавлен заголовок для указания типа контента
    echo json_encode(['error' => "Ошибка: " . $e->getMessage()]);
}
?>
