<?php

session_start();
require 'vendor/autoload.php'; // Подключаем автозагрузчик Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin_lsty') {
    header('Location: index.php'); // Если не авторизован или не администратор, перенаправляем на страницу входа
    exit;
}

$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["download_format"])) {
            $format = $_POST["download_format"];
            $table = $_POST["table"];
            $platoon = isset($_POST["platoon"]) ? (int)$_POST["platoon"] : null;

            if ($format === 'excel') {
                generateExcelReport($db, $table, $platoon);
            } elseif ($format === 'pdf') {
                generatePdfReport($db, $table, $platoon);
            }
        }
    }

} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

function generateExcelReport($db, $tableName, $platoon) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $excludeColumns = ["id_$tableName", "id_teachers"];

    // Define the column header mappings
    $columnMappings = [
        'full_platoon_name' => 'Название взвода',
        'inventory' => 'инвентарь',
        'rank' => 'звание',
        'semester' => 'семестр',
        'number_audience' => 'номер аудитории',
        'time' => 'время',
        'day_of_the_week' => 'День недели',
        'id_platoon' => 'номер взвода',
        'type' => 'тип',
        'point' => 'Баллы',
        'full_name_cadets' => 'ФИО курсантов',
        'full_name_teachers' => 'ФИО преподавателей',
        'name_disciplines' => 'Название дисциплин',
        'date' => 'Дата',
    ];

    $query = getQuery($db, $tableName, $excludeColumns, $platoon);

    if (!$query) {
        echo 'Нет данных для экспорта в Excel.';
        exit;
    }

    $stmt = $db->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$data) {
        echo 'Нет данных для экспорта в Excel.';
        exit;
    }

    $headerRow = array_keys($data[0]);
    $columnIndex = 'A';

    foreach ($headerRow as $header) {
        $headerInRussian = $columnMappings[$header] ?? $header; // Use Russian header if available
        $sheet->setCellValue($columnIndex . '1', $headerInRussian);
        $columnIndex++;
    }

    $rowIndex = 2;
    foreach ($data as $rowData) {
        $columnIndex = 'A';
        foreach ($rowData as $key => $value) {
            if (strpos($key, "id_$tableName") !== false || $key === 'id_teachers') continue; // Skip columns like id_tableName
            $sheet->setCellValue($columnIndex . $rowIndex, $value);
            $columnIndex++;
        }
        $rowIndex++;
    }

    $filename = "report_$tableName.xlsx";

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

function generatePdfReport($db, $tableName, $platoon) {
    $mpdf = new Mpdf();
    $excludeColumns = ["id_$tableName", "id_teachers"];

    // Define the column header mappings
    $columnMappings = [
        'full_platoon_name' => 'Название взвода',
        'inventory' => 'инвентарь',
        'rank' => 'звание',
        'semester' => 'семестр',
        'number_audience' => 'номер аудитории',
        'time' => 'время',
        'day_of_the_week' => 'День недели',
        'id_platoon' => 'номер взвода',
        'type' => 'тип',
        'point' => 'Баллы',
        'full_name_cadets' => 'ФИО курсантов',
        'full_name_teachers' => 'ФИО преподавателей',
        'name_disciplines' => 'Название дисциплин',
        'date' => 'Дата',
    ];

    $query = getQuery($db, $tableName, $excludeColumns, $platoon);

    if (!$query) {
        echo 'Нет данных для экспорта в PDF.';
        exit;
    }

    $stmt = $db->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$data) {
        echo 'Нет данных для экспорта в PDF.';
        exit;
    }

    $html = '
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; font-size: 24px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
    <h1>Отчет</h1>
    <table>
        <thead>
            <tr>';

    foreach (array_keys($data[0]) as $header) {
        $headerInRussian = $columnMappings[$header] ?? $header;
        $html .= "<th>$headerInRussian</th>";
    }

    $html .= '
            </tr>
        </thead>
        <tbody>';

    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $key => $value) {
            if (strpos($key, "id_$tableName") !== false || $key === 'id_teachers') continue; // Skip columns like id_tableName
            $html .= "<td>$value</td>";
        }
        $html .= '</tr>';
    }

    $html .= '
        </tbody>
    </table>';

    $mpdf->WriteHTML($html);
    $filename = "report_$tableName.pdf";
    $mpdf->Output($filename, 'D');
    exit;
}

function getQuery($db, $tableName, $excludeColumns, $platoon) {
    // Отладочное сообщение
    echo "Проверка входного параметра 'platoon': " . htmlspecialchars($platoon) . "<br>";

    $platoonCondition = "";
    if ($platoon !== 0 && $platoon !== "0" && in_array("id_platoon", getColumnNames($db, $tableName))) {
        $platoonCondition = "WHERE $tableName.id_platoon = $platoon";
    }

    // Отладочное сообщение
    echo "Проверка условия 'platoonCondition': " . htmlspecialchars($platoonCondition) . "<br>";

    if ($tableName === 'estimates') {
        $query = "SELECT 
            estimates.point,
            cadets.full_name_cadets,
            teachers.full_name_teachers, 
            estimates.name_disciplines, 
            estimates.date
            FROM estimates 
            JOIN teachers ON estimates.id_teachers = teachers.id_teachers
            JOIN cadets ON estimates.id_cadets = cadets.id_cadets
            $platoonCondition";

        // Отладочное сообщение
        echo "Сформированный запрос для 'estimates': " . htmlspecialchars($query) . "<br>";

        return $query;
    } elseif ($tableName === 'schedule') {
        $query = "SELECT 
            schedule.day_of_the_week,
            schedule.time,
            schedule.semester,
            schedule.name_disciplines,
            schedule.number_audience,
            schedule.id_platoon,
            teachers.full_name_teachers 
            FROM schedule 
            JOIN teachers ON schedule.id_teachers = teachers.id_teachers
            $platoonCondition";

        // Отладочное сообщение
        echo "Сформированный запрос для 'schedule': " . htmlspecialchars($query) . "<br>";

        return $query;
    } else {
        $baseQuery = "SELECT * FROM $tableName $platoonCondition";
        
        // Отладочное сообщение
        echo "Базовый запрос: " . htmlspecialchars($baseQuery) . "<br>";

        $stmt = $db->query($baseQuery);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$data) {
            echo "Нет данных для экспорта в PDF.<br>";
            return null;
        }

        $query = "SELECT " . implode(', ', array_diff(array_keys($data[0] ?? []), $excludeColumns)) . " FROM $tableName $platoonCondition";
        
        // Отладочное сообщение
        echo "Окончательный запрос: " . htmlspecialchars($query) . "<br>";

        return $query;
    }
}


function getColumnNames($db, $tableName) {
    $stmt = $db->query("SELECT column_name FROM information_schema.columns WHERE table_name = '$tableName'");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}




?>

<!DOCTYPE html>
<html lang="ru">
    <style>
        .container_2 {
        max-width: 170px;
        
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 60px; /* Добавляем нижний отступ, равный высоте футера + дополнительный отступ */
    }
        .container_3{
    display: flex;
        align-items: flex-start; 
}
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
            background-color: #f4f4f4;
        }

        body {
            background-image: url('fon_1.jpg');
            background-size: cover;
        }

        .title {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .flag_ros {
            width: 115px;
            height: auto;
            margin-left: auto;
        }

        .container {
        max-width: 800px;
        margin-left: 25px;
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 60px; /* Добавляем нижний отступ, равный высоте футера + дополнительный отступ */
    }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
        }

        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            
            max-width: 800px;
        }

        .flag_ros {
            width: 115px;
            height: auto;
            margin-left: auto;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .title {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .footer {
    display: flex;            /* Используем flexbox */
    justify-content: center;  /* Центрируем содержимое по горизонтали */
    align-items: center;      /* Центрируем содержимое по вертикали */
    padding: 10px 20px;       /* Небольшие отступы вокруг содержимого */
}

/* Стили для социальных иконок внутри футера */
.social-icons {
    display: flex;           /* Используем flexbox для расположения иконок в строку */
    align-items: center;     /* Выравниваем иконки по вертикали */
}

.social-icons a {
    margin: 0 10px;          /* Отступы между иконками */
}

.social-icons img {
    width: 24px;             /* Устанавливаем желаемую ширину иконок */
    height: auto;            /* Автоматический расчет высоты для сохранения пропорций */
    vertical-align: middle;  /* Выравнивание по вертикали */
}
.footer {
            background-color: rgba(0, 0, 0, 0.5); /* Полупрозрачный черный фон */
            color: white; /* Белый цвет текста */
            text-align: center; /* Выравнивание текста по центру */
            padding: 10px 0; /* Внутренний отступ сверху и снизу */
            position: fixed; /* Фиксированное положение */
            bottom: 0; /* Прижимаем к нижней части страницы */
            width: 100%; /* Ширина 100% */
            z-index: 999; /* Устанавливаем z-index, чтобы footer был поверх других элементов */
        }
    /* Стили для кнопок */
/* Стили для кнопок */
.button-container {
    display: flex;
    flex-wrap: wrap;  /* Разрешаем перенос кнопок на новую строку, если не помещаются в одну строку */
    justify-content: space-around;  /* Равномерное распределение пространства между кнопками */
    margin-top: 20px;  /* Добавляем отступ сверху для разделения кнопок и таблицы */
}
.submit-button {
    margin-left: 6px;
    width: 150px;
    background-color: #007bff;
    color: white;
    padding: 10px 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
  }


.button-container button {
    width: 150px;  /* Задаем фиксированную ширину для кнопок */
    background-color: #007bff;
    color: white;
    padding: 10px 0;  /* Изменяем вертикальные отступы, чтобы кнопки выглядели центрированными */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-bottom: 10px;  /* Добавляем отступ между кнопками */
}

.button-container button:hover {
    background-color: #0056b3;
}
.modal-content button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.modal-content button:hover {
    background-color: #0056b3;
}

        
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        select, input, button {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }

    </style>

    <head>
        
    </head>

    <body>
    <div class ="container_3" >
<div class="container_2">
<button class = submit-button onclick="redirectToMainPage()">Выйти</button>
</div>
<div class="container">
            <div class="title">
                <h1>Военный учебный центр ЛГТУ</h1>
                <img src="flag-ros.png" alt="Флаг России" class="flag_ros">
                
                

            </div>
           
            <div id="welcomeModal" class="modal">
    <div class="modal-content">
        <h2>Добро пожаловать!</h2>
        <p>Мы рады видеть вас на нашем сайте. Нажмите "Продолжить", чтобы перейти к основному контенту.</p>
        <button onclick="closeWelcomeModal()">Продолжить</button>
    </div>
</div>

<div class="container">
        <h1>Скачать отчет</h1>
        <form method="post" action="">
            <label for="table">Выберите таблицу:</label>
            <select name="table" id="table">
                <option value="cadets">Курсанты</option>
                <option value="schedule">Расписание</option>
                <option value="estimates">Оценки</option>
                <option value="teachers">Преподаватели</option>
                <option value="audience">Аудитория</option>
                <option value="disciplines">Дисциплины</option>
                <option value="platoon">Взвод</option>
            </select>
            <label for="download_format">Формат отчета:</label>
            <select name="download_format" id="download_format">
                <option value="excel">Excel</option>
                <option value="pdf">PDF</option>
            </select>
            <form method="post" action="your_export_script.php">
    <label for="platoon">Номер взвода (опционально):</label>
    <select id="platoon" name="platoon">
        <option value="all">Все</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <!-- Добавьте остальные взводы по мере необходимости -->
    </select>
    <input type="submit" value="Скачать отчет">

    
    </div>



    
    
    
    
            <?php
             

            // Ваша конфигурация для подключения к базе данных и начало сессии
            $host = 'localhost';
            $dbname = 'war';
            $user = 'postgres';
            $pass = '1212!@';

            


            try {
                $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Определение функции displayTableData() здесь
                function displayTableData($db, $tableName)
                {
                    $excludeColumns = [];  // Пустой массив для исключения столбцов по умолчанию

                    // Обновление запроса для таблицы estimates
                    if ($tableName === 'estimates') {
                        $stmt = $db->query("SELECT estimates.*, teachers.full_name_teachers 
                                FROM estimates 
                                JOIN teachers ON estimates.id_teachers = teachers.id_teachers");
                        $excludeColumns = ['id_teachers'];  // Исключаем id_teachers из отображения
                    }
                    // Обновление запроса для таблицы schedule
                    elseif ($tableName === 'schedule') {
                        $stmt = $db->query("SELECT schedule.*, teachers.full_name_teachers 
                                FROM schedule 
                                JOIN teachers ON schedule.id_teachers = teachers.id_teachers");
                        $excludeColumns = ['id_schedule', 'id_point'];  // Исключаем id_schedule и id_point из отображения
                    }
                    // Обычный запрос для других таблиц
                    else {
                        $stmt = $db->query("SELECT * FROM $tableName");
                    }

                    echo "<h2>Таблица $tableName</h2>";
                    echo "<table border='1'>";
                    $headerPrinted = false;
                    if ($stmt !== false) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if (!$headerPrinted) {
                                echo "<tr>";
                                foreach ($row as $key => $value) {
                                    if (!in_array($key, $excludeColumns)) {  // Исключаем указанные колонки
                                        echo "<th>$key</th>";
                                    }
                                }
                                echo "</tr>";
                                $headerPrinted = true;
                            }
                            echo "<tr>";
                            foreach ($row as $key => $value) {
                                if (!in_array($key, $excludeColumns)) {  // Исключаем указанные колонки
                                    echo "<td>$value</td>";
                                }
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='100%'>Таблица пуста</td></tr>";
                    }
                    echo "</table>";
                }
                

                
                // Используйте JavaScript для вызова модального окна
               

                
            } catch (PDOException $e) {
                echo "Ошибка подключения: " . $e->getMessage();
            }
            ?>
                    <div class="button-container">
    <?php
    
    ?>
</div>
            <div class="modal" id="tableModal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <div id="tableContent"></div> <!-- Сюда будет загружаться содержимое таблицы -->
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("welcomeModal");
            modal.style.display = "block";
        });
                function closeWelcomeModal() {
        var modal = document.getElementById('welcomeModal');
        modal.style.display = 'none';
    }
                function openModal(tableName) {
                    var modal = document.getElementById('tableModal');
                    var tableContent = document.getElementById('tableContent');

                    // Выполнение AJAX-запроса
                    fetch('fetch_table_data.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                table: tableName
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            tableContent.innerHTML = data.tableData; // Предполагается, что сервер возвращает HTML для таблицы
                            modal.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                        });
                }

                function closeModal() {
                    var modal = document.getElementById('tableModal');
                    modal.style.display = 'none';
                }
            </script>
        </div>
        
    <script>
    function redirectToMainPage() {
        window.location.href = 'index.php'; // Замените 'index.php' на ваш путь к главной странице
    }
</script>
    </body>

</html>
