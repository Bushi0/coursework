<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'cadet') {
    header('Location: index.php'); // Если не авторизован или не администратор, перенаправляем на страницу входа
    exit;
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
    margin-top: 31px;
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
.loader {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            display: none; /* Начальное состояние - скрыт */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


    </style>
    <div class="loader" id="loader"></div>

    <head>
        
    </head>

    <body>
    <div class ="container_3" >
<div class="container_2">
<button class = submit-button onclick="redirectToMainPage()">Выйти</button>
<button class = submit-button onclick="redirectToMainPage()">Профиль</button>
<button class="submit-button" onclick="redirectToMessagesPage()">Сообщения</button>
<button class = submit-button onclick="redirectToMainPage()">Мероприятия</button>
</div>
<div class="container">
            <div class="title">
                <h1>Военный учебный центр ЛГТУ</h1>
                <img src="flag-ros.png" alt="Флаг России" class="flag_ros">
                
                

            </div>
           
            <div id="welcomeModal" class="modal">
    <div class="modal-content">
        <h2>Добро пожаловать!</h2>
        <p></p>
        <button onclick="closeWelcomeModal()">Продолжить</button>
    </div>
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

                    // Определение столбцов, которые нужно исключить для каждой таблицы
                    switch ($tableName) {
                        case 'estimates':
                            $excludeColumns = ['id_teachers'];  // Исключаем id_teachers из отображения
                            break;
                        case 'schedule':
                            $excludeColumns = ['id_schedule', 'id_point'];  // Исключаем id_schedule и id_point из отображения
                            break;
                        // Добавьте другие таблицы, если необходимо
                    }

                    // Определение запроса для каждой таблицы
                    $stmt = $db->query("SELECT * FROM $tableName");

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

                
                $tables = ['platoon', 'teachers', 'audience', 'cadets', 'it_has', 'schedule', 'estimates', 'disciplines'];

                
               

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
                var loader = document.getElementById("loader");
            var modal = document.getElementById("welcomeModal");

            // Показываем лоадер при загрузке страницы
            loader.style.display = "block";

            // По окончании загрузки страницы
            window.addEventListener("load", function() {
                // Скрываем лоадер
                loader.style.display = "none";
                
                // Открываем модальное окно (если необходимо)
                modal.style.display = "block";
            });
    var modal = document.getElementById("welcomeModal");
    modal.style.display = "block";
});

function closeWelcomeModal() {
    var modal = document.getElementById('welcomeModal');
    modal.style.display = 'none';
}
function redirectToMessagesPage() {
        window.location.href = "messages.php";
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
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Ошибка на сервере:', data.error);
            } else {
                tableContent.innerHTML = data.tableData;
                modal.style.display = 'block';
            }
        })
        .catch(error => {
    console.error('Ошибка:', error.message, error.stack);
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
