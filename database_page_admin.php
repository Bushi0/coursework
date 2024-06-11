
<?php
session_start();

// Проверяем, авторизован ли пользователь
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
        header('Location: index.php'); // Если не авторизован или не администратор, перенаправляем на страницу входа
        exit;
    }

?>
<!DOCTYPE html>
<html lang="ru">

<style>
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
    .container_2 {
        max-width: 170px;
        
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
            width: 80%;
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
             /* Фиксированное положение */
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
.table-container {
        max-height: 400px; /* Установите желаемую максимальную высоту */
        overflow-y: auto;
    }

    .table-container table {
        width: 100%; /* Ширина таблицы равна 100% ширины контейнера */
        white-space: nowrap; /* Запрет переноса строк в ячейках таблицы */
    }
/* Стили для кнопок */
.button-container {
    display: flex;
    flex-wrap: wrap;  /* Разрешаем перенос кнопок на новую строку, если не помещаются в одну строку */
    justify-content: space-around;  /* Равномерное распределение пространства между кнопками */
    margin-top: 20px;  /* Добавляем отступ сверху для разделения кнопок и таблицы */
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
.submit-button {
    margin-left: 6px;
    width: 180px;
    background-color: #007bff;
    color: white;
    padding: 10px 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
  }

  .submit-button:hover {
    background-color: #0056b3;
  }
  
.input-field {
  width: 100%;
  padding: 8px;
 margin-bottom: 10px;
  box-sizing: border-box;
}
.container_3{
    display: flex;
        align-items: flex-start; 
}
    </style>
    
       
<body>
<script>
    function showAlert(message) {
        alert(message);
    }
    function openEditModal(event, editId) {
        event.preventDefault();
        document.getElementById('edit_id').value = editId;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    function redirectToMainPage() {
        window.location.href = 'index.php'; // Замените 'index.php' на ваш путь к главной странице
    }
</script>

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

        <?php
// Проверяем, активирована ли уже сессия
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
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

    function displayTableData($db, $tableName)
 {
 
    echo "<div class='table-container'>";
    echo "<table border='1'>";
    $idColumnName = getIdColumnName($tableName);

    if (isset($_POST['delete_record']) && $_POST['table_name'] === $tableName) {
        $deleteId = $_POST['delete_id'];
        deleteRecord($db, $tableName, $idColumnName, $deleteId);
    }

    $stmt = $db->query("SELECT * FROM $tableName");
    echo "<table border='1'>";
    $headerPrinted = false;
    $rowCount = 0;
if ($stmt !== false) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!$headerPrinted) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<th>$key</th>";
            }
            echo "<th>Действия</th>"; 
            echo "</tr>";
            $headerPrinted = true;
        }

        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }

        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='table_name' value='$tableName'>";
        echo "<input type='hidden' name='edit_id' value='" . $row[$idColumnName] . "'>";
        echo "<input type='submit' name='edit_record' value='Редактировать запись'>";
        echo "</form>";

        echo "<form method='post'>";
        echo "<input type='hidden' name='table_name' value='$tableName'>";
        echo "<input type='hidden' name='delete_id' value='" . $row[$idColumnName] . "'>";
        echo "<input type='submit' name='delete_record' value='Удалить запись'>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
        $rowCount++;
    }
}


    
  else {
        echo "<tr><td colspan='100%'>Таблица пуста</td></tr>";
    }
   

echo "</table>";
echo "</div>";

echo "<h3>Добавить запись:</h3>";
echo "<form method='post' class='add-record-form'>";

$columns = getTableColumns($db, $tableName);

foreach ($columns as $column) {
    echo "<div class='form-field'>";
    echo "<label for='$column'>$column:</label>";
    $value = isset($_POST[$column]) ? $_POST[$column] : '';
    echo "<input type='text' name='$column' id='$column' value='$value' placeholder='$column' class='input-field'><br>";
    echo "</div>";
}

echo "<input type='hidden' name='table_name' value='$tableName' class='input-field'>";
echo "<input type='submit' name='add_record' value='Добавить запись' class='submit-button'>";
echo "</form>";

        
    


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
                return '';
            case 'platoon':
                return 'id_platoon';
    }
    }

    function getTableColumns($db, $tableName)
    {
        $stmt = $db->query("SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName'");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    

    function deleteRecord($db, $tableName, $idColumnName, $idValue)
{
    try {
        $stmt = $db->prepare("DELETE FROM $tableName WHERE $idColumnName = :idValue");
        $stmt->bindParam(':idValue', $idValue, PDO::PARAM_INT);
        $stmt->execute();

        $deletedRows = $stmt->rowCount();
        if ($deletedRows > 0) {
            echo "<hr style='margin-top: 20px;'>";
            echo "<p>Запись успешно удалена из таблицы $tableName.</p>";
        } else {
            echo "<p>Нет записи для удаления в таблице $tableName.</p>";
        }

        return "success";
    } catch (PDOException $e) {
        echo "Ошибка удаления: " . $e->getMessage();
        return "error";
    }
}




    function editRecord($db, $tableName, $idColumnName, $idValue)
 {
   
    $stmt = $db->prepare("SELECT * FROM $tableName WHERE $idColumnName = :idValue");
    $stmt->bindParam(':idValue', $idValue, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h3>Редактировать запись:</h3>";
    echo "<form method='post' class='edit-record-form'>";
    
    foreach ($record as $key => $value) {
        echo "<div class='form-field'>";
        echo "<label for='$key'>$key:</label>";
        echo "<input type='text' name='$key' id='$key' value='$value' class='input-field'><br>";
        echo "</div>";
    }
    
    echo "<input type='hidden' name='table_name' value='$tableName' class='input-field'>";
    echo "<input type='hidden' name='edit_id' value='$idValue' class='input-field'>";
    echo "<input type='submit' name='update_record' value='Сохранить изменения' class='submit-button'>";
    echo "</form>";
    
 }
 function updateRecord($db, $tableName)
{
    $idColumnName = getIdColumnName($tableName);
    $editId = $_POST['edit_id'];

    $columns = getTableColumns($db, $tableName);
    $updateValues = array();
    foreach ($columns as $key) {
        $updateValues[] = "$key = :$key";
    }
    $updateValues = implode(', ', $updateValues);

    $sql = "UPDATE $tableName SET $updateValues WHERE $idColumnName = :idValue";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idValue', $editId, PDO::PARAM_INT);
    foreach ($columns as $key) {
        $stmt->bindParam(":$key", $_POST[$key]);
    }

    try {
        $stmt->execute();
        echo "<hr style='margin-top: 20px;'>";
        echo "<p>Запись успешно обновлена в таблице $tableName.</p>";
    } catch (PDOException $e) {
        echo "Ошибка обновления: " . $e->getMessage();
    }
}

   
    $tables = array('cadets', 'disciplines', 'teachers', 'audience', 'it_has', 'schedule', 'estimates', 'platoon');

   
    echo "<h3>Выберите таблицу для редактирования</h3>";

    echo "<div class='button-container'>";
    foreach ($tables as $table) {
        echo "<form method='post'>";
        echo "<input type='hidden' name='table_name' value='$table'>";
        echo "<input type='submit' name='show_table' value='Показать таблицу $table' class = 'submit-button'>";
        echo "</form>";
    }
    echo "</div>";
    if (isset($_POST['add_record'])) {
        $tableName = $_POST['table_name'];
        $columns = getTableColumns($db, $tableName);
        $placeholders = ':' . implode(', :', $columns);
        $sql = "INSERT INTO $tableName (" . implode(', ', $columns) . ") VALUES (" . $placeholders . ")";
        $stmt = $db->prepare($sql);
        foreach ($columns as $key) {
            $stmt->bindParam(":$key", $_POST[$key]);
        }
        $stmt->execute();
        echo "<hr style='margin-top: 20px;'>";
        echo "<p>Запись успешно добавлена в таблицу $tableName.</p>";
    }
    if (isset($_POST['edit_record'])) {
        $tableName = $_POST['table_name'];
        $editId = $_POST['edit_id'];
        $idColumnName = getIdColumnName($tableName);
        editRecord($db, $tableName, $idColumnName, $editId);
    }
    
    if (isset($_POST['update_record'])) {
        $tableName = $_POST['table_name'];
        updateRecord($db, $tableName);
    }
    

    if (isset($_POST['show_table'])) {
        $tableName = $_POST['table_name'];
        echo "<h2>Таблица $tableName</h2>";
        displayTableData($db, $tableName);
    
        
    }

    

    if (isset($_POST['delete_record'])) {
        $deleteId = $_POST['delete_id'];
        $tableName = $_POST['table_name'];
        $idColumnName = getIdColumnName($tableName);
        deleteRecord($db, $tableName, $idColumnName, $deleteId);
    }

    
    
    
}


 catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}

file_put_contents('post_data.log', print_r($_POST, true), FILE_APPEND);

?>


</div>
</div>

</body>

