<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Военный учебный центр ЛГТУ</title>
<style>
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
        

        body {
        /* ... ваш текущий код ... */
        background-image: url('fon_1.jpg'); /* Путь к вашему изображению фона */
        background-size: cover; /* Растягиваем изображение на весь экран */
        
         /* Центрируем изображение фона */
 }
        /* Обновленные стили для полей ввода */
        input[type="text"],
        input[type="password"] {
            width: 80%;                /* Уменьшаем ширину поля ввода */
            padding: 12px;             /* Внутренний отступ */
            margin-bottom: 20px;       /* Отступ снизу */
            border: 2px solid #ccc;    /* Граница поля ввода */
            border-radius: 6px;        /* Закругленные углы */
            font-size: 18px;           /* Размер шрифта */
            background-color: #f9f9f9; /* Цвет фона */
            transition: border-color 0.3s, background-color 0.3s; /* Плавные переходы */
        }

        /* Стили для полей ввода при фокусировке */
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;     /* Цвет границы при фокусировке */
            outline: none;             /* Убираем контур фокуса */
            background-color: #fff;    /* Изменяем фон при фокусировке */
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); /* Тень при фокусировке */
        }
        label {
            margin-bottom: 5px;        /* Небольшой отступ снизу для метки */
        }
        .dialogButton {
            padding: 10px 20px;      /* Одинаковый внутренний отступ для обеих кнопок */
            border: none;            /* Убираем границу */
            border-radius: 5px;      /* Закругляем углы */
            cursor: pointer;         /* Изменяем курсор при наведении на кнопку */
            transition: background-color 0.3s; /* Плавное изменение цвета фона при наведении */
        }

        /* Стили для кнопки "Закрыть" */
        .closeButton {
            
            color: black;              /* Цвет текста */
        }

        /* Стили для кнопки "Войти" */
        .submitButton {
            background-color: #007bff; /* Цвет фона */
            color: white;              /* Цвет текста */
        }

        /* При наведении на кнопки */
        .dialogButton:hover {
            opacity: 0.9;             /* Немного уменьшаем прозрачность для эффекта нажатия */
        }
         #loginModal {
        display: none; /* Сначала скрываем модальное окно */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Затемненный фон */
        z-index: 1000;
        opacity: 0; /* Начальная прозрачность */
        transition: opacity 0.3s ease; /* Плавная анимация */
    }
        #loginModal button[type="submit"] {
            padding: 12px 24px;
            background-color: #007bff; /* Синий цвет для кнопки */
            color: #fff; /* Белый текст на кнопке */
            border: none; /* Убираем границу */
            border-radius: 5px; /* Закругляем углы */
            cursor: pointer; /* Курсор в виде указателя при наведении */
            transition: background-color 0.3s; /* Плавная анимация при наведении */
            font-size: 16px; /* Размер текста кнопки */
            
            /* Перемещаем кнопку вправо */
            float: right; /* Используем свойство float */
            margin-left: 10px; /* Добавляем небольшой отступ слева для разделения от других элементов */
        }

        #loginModal button[type="submit"]:hover {
            background-color: #0056b3; /* Темнее синий цвет при наведении */}

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
            background-color: #f4f4f4;
        }
        .container {
        max-width: 800px;
        margin-left: 235px;
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 60px; /* Добавляем нижний отступ, равный высоте футера + дополнительный отступ */
    }
        
        .title {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc; /* Добавляем тонкую линию снизу заголовка */
            padding-bottom: 10px; /* Отступ снизу, чтобы создать пространство между заголовком и линией */
 }
        .flag {
            width: 75px;
            height: auto;
            margin-left: auto;
        }
        .flag_ros{
            width: 115px;
            height: auto;
            margin-left: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #loginButtonContainer {
        display: flex;            /* Используем flexbox */
        justify-content: flex-end; /* Выравниваем содержимое контейнера по правому краю */
        margin-top: 20px;         /* Добавляем небольшой верхний отступ для разделения от других элементов */
    }
    #buttonContainer {
    display: flex;           /* Располагаем элементы в строку */
    justify-content: center; /* Выравнивание по центру по горизонтали */
    align-items: center;     /* Выравнивание по центру по вертикали */
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




</style>
</head>
<body>
<div class="container">
    <div class="title">
        <h1>Военный учебный центр ЛГТУ</h1>
        <img src="flag-ros.png" alt="Флаг России" class="flag_ros">
        
        
    </div>
    

    
    <!-- Добавьте кнопку для отображения окна авторизации -->
    <button onclick="showLoginModal()">Войти в систему</button>
    <button onclick="showAboutModal()">О нас</button>
    <button onclick="redirectToLGUTSite()">Сайт ЛГТУ</button>

    
    
    
    <!-- Модальное окно авторизации -->
    <div id="loginModal">
        <div class="modal-content">
            
            <span class="closeButton" onclick="hideLoginModal()" style="position: absolute; top: 10px; right: 10px; font-size: 24px; cursor: pointer;">✖</span>
            
            <h2>Авторизация</h2>
            
            <form method="post">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username"><br><br>
                
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password"><br><br>
                
                <div id="loginButtonContainer">
                    <button class="dialogButton submitButton" type="submit">Войти</button>
                </div>
                <div id="errorMessage" style="color: red; margin-top: 10px; display: none;">Неправильный логин или пароль!</div>

            </form>
      </div>
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
    
    <!-- Остальной HTML-код ... -->


    <script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    var errorMessage = document.getElementById('errorMessage');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Предотвращаем отправку формы

        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        // Отправка AJAX-запроса на сервер для проверки логина и пароля
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'check_login.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Успешная авторизация
                    redirectToRolePage(response.role);
                } else {
                    // Неправильный логин или пароль
                    errorMessage.style.display = 'block';
                }
            }
        };
        xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password));
    });
});

// Функция для перенаправления на страницу в зависимости от роли
function redirectToRolePage(role) {
    var rolePages = {
        'admin': 'database_page_admin.php',
        'cadet': 'database_page.php',
        'admin_lsty': 'admin_lsty_page.php',
        'teachers': 'teachers_page.php'
    };

    var page = rolePages[role];
    if (page) {
        window.location.href = page;
    }
}

// Функция для плавного отображения модального окна
function showLoginModal() {
    var modal = document.getElementById('loginModal');
    modal.style.display = 'block';
    setTimeout(function() {
        modal.style.opacity = '1';
    }, 50);
}

// Функция для скрытия модального окна
function hideLoginModal() {
    var modal = document.getElementById('loginModal');
    modal.style.opacity = '0';
    setTimeout(function() {
        modal.style.display = 'none';
    }, 300);
}

// Функция для перенаправления на страницу "О нас"
function redirectToAboutPage() {
    window.location.href = 'about_us_page.php';
}

// Функция для перенаправления на сайт ЛГТУ
function redirectToLGUTSite() {
    window.location.href = 'https://www.stu.lipetsk.ru/';
}
</script>

    
    
    
    

</body>

</html>
