<?php
// Проверяем, была ли уже установлена сессия
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Проверяем, не авторизован ли пользователь
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Если сессия не содержит информацию о посещении, отображаем окно приветствия
    if (!isset($_SESSION['visited_welcome_modal'])) {
        echo "<div class='modal-content'>";
        echo "<h2>Добро пожаловать! преподаватель N</h2>";
        echo "<p></p>";
        echo "<button onclick='closeWelcomeModal()'>Продолжить</button>";
        echo "</div>";

        // Устанавливаем флаг посещения окна в сессии
        $_SESSION['visited_welcome_modal'] = true;
    }
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
.container_2 {
        max-width: 170px;
        
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 60px; /* Добавляем нижний отступ, равный высоте футера + дополнительный отступ */
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
           
            
    
    
    
    
    
            <?php
             

            // Ваша конфигурация для подключения к базе данных и начало сессии
            $host = 'localhost';
            $dbname = 'war';
            $user = 'postgres';
            $pass = '1212!@';

            


            try {
                $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if (isset($_POST['execute_procedure'])) {
                    $p_full_name_cadets = $_POST['p_full_name_cadets'];
                    $p_full_name_teachers = $_POST['p_full_name_teachers'];
                    $p_point = $_POST['p_point'];
                    $p_name_disciplines = $_POST['p_name_disciplines'];
            
                    $stmt = $db->prepare("CALL insertgradeafterexam_8(:p_full_name_cadets, :p_full_name_teachers, :p_point, :p_name_disciplines)");
                    $stmt->bindParam(':p_full_name_cadets', $p_full_name_cadets);
                    $stmt->bindParam(':p_full_name_teachers', $p_full_name_teachers);
                    $stmt->bindParam(':p_point', $p_point, PDO::PARAM_INT);
                    $stmt->bindParam(':p_name_disciplines', $p_name_disciplines);
                    $stmt->execute();
                    
                }
            
                echo "<h3>Введите данные для зачета</h3>";
                echo "<form method='post'>";
                echo "<label for='p_full_name_cadets'>Полное имя курсанта:</label>";
                echo "<input type='text' name='p_full_name_cadets' id='p_full_name_cadets' class='input-field'><br>";
                echo "<label for='p_full_name_teachers'>Полное имя преподавателя:</label>";
                echo "<input type='text' name='p_full_name_teachers' id='p_full_name_teachers' class='input-field'><br>";
                echo "<label for='p_point'>Балл:</label>";
                echo "<input type='number' name='p_point' id='p_point' class='input-field'><br>";
                echo "<label for='p_name_disciplines'>Название дисциплины:</label>";
                echo "<input type='text' name='p_name_disciplines' id='p_name_disciplines' class='input-field'><br>";
                echo "<input type='submit' name='execute_procedure' value='поставить зачёт' class = submit-button>";
                echo "</form>";
                
                // Добавление горизонтальной линии
                echo "<hr style='margin-top: 20px;'>";
                if (isset($_POST['execute_procedure'])) {
                    // Ваш код для выполнения процедуры и установки зачета
                
                    // Вывод модального окна после успешного выполнения
                    echo "<script>";
                    echo "alert('Зачёт успешно выставлен!');";
                    echo "</script>";
                }

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
                

                // Отображение кнопок для каждой таблицы
                $tables = ['platoon', 'teachers', 'audience', 'cadets', 'it_has', 'schedule', 'estimates', 'disciplines'];

                // Используйте JavaScript для вызова модального окна
               

                if (isset($_POST['show_table'])) {
                    $selectedTable = $_POST['selected_table'];
                    displayTableData($db, $selectedTable);
                }
            } catch (PDOException $e) {
                echo "Ошибка подключения: " . $e->getMessage();
            }
            ?>
                    <div class="button-container">
    <?php
    // Отображение кнопок для каждой таблицы
    foreach ($tables as $table) {
        echo "<button onclick='openModal(\"$table\")'>Показать таблицу $table</button>";
    }
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
                    fetch('fetch_table_data_cadets.php', {
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
                function redirectToMainPage() {
        window.location.href = 'index.php'; // Замените 'index.php' на ваш путь к главной странице
    }
            </script>
        </div>
        </div>
        <footer class="footer">
    
    <p>Все права защищены 2024 Ненахов Дмитрий Аркадьевич</p>
    <div class="social-icons">
        <a href="https://vk.com/bushi_kaze" target="_blank" rel="noopener noreferrer"><img src="vk_logo.png" alt="VK Icon"></a>
        <a href="https://telegram.org/" target="_blank" rel="noopener noreferrer"><img src="tg_logo.png" alt="Telegram Icon"></a>
        <img src="ЛГТУ.png" alt="ЛГТУ">
    </div>
    </footer>
    </body>

</html>
