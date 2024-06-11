<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <style>
        /* Общие стили */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Стили для основного контейнера */
        .container {
            display: flex;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Прячем содержимое, которое не помещается */
        }

        /* Стили для левой панели выбора получателя */
        .sidebar {
            flex: 1;
            padding: 20px;
            background-color: #f2f2f2;
            border-right: 1px solid #ddd;
            overflow-y: auto; /* Добавляем вертикальную прокрутку, если контент не помещается */
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .user-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .user-list li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .user-list li:last-child {
            border-bottom: none;
        }

        /* Стили для окна чата */
        .chat-window {
            flex: 3;
            padding: 20px;
            overflow-y: auto; /* Добавляем вертикальную прокрутку, если контент не помещается */
        }

        .message {
            margin-bottom: 20px;
        }

        .message .sender {
            font-weight: bold;
            color: #007bff; /* Цвет отправителя */
        }

        .message .timestamp {
            font-size: 0.8em;
            color: #888; /* Цвет времени отправки */
        }

        .message .text {
            margin-top: 5px;
        }

        /* Стили для формы ввода сообщения */
        .message-form {
            margin-top: 20px;
        }

        .message-form textarea {
            width: calc(100% - 40px); /* Ширина поля ввода сообщения */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none; /* Запрещаем изменение размера поля ввода */
        }

        .message-form button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .message-form button:hover {
            background-color: #0056b3; /* Изменение цвета кнопки при наведении */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Левая панель с выбором получателя -->
        <div class="sidebar">
            <h2>Выберите получателя</h2>
            <ul class="user-list" id="user-list">
                <!-- Пользователи будут добавлены динамически с помощью JavaScript -->
                <li onclick="startGPTChat()">Чат с GPT</li>
            </ul>
        </div>

        <!-- Окно чата -->
        <div class="chat-window">
        </div>
    </div>
    <script>
        // Функция для начала чата с GPT
        function startGPTChat() {
            var chatWindow = document.querySelector('.chat-window');
            chatWindow.innerHTML = ''; // Очищаем содержимое окна чата перед открытием чата с GPT

            // Добавляем сообщение с приветствием в окно чата
            var message = document.createElement('div');
            message.className = 'message';
            message.innerHTML = '<span class="sender">GPT</span><span class="timestamp">' + getCurrentTime() + '</span><p class="text">Привет! Я GPT, чем могу помочь?</p>';
            chatWindow.appendChild(message);

            // Добавляем форму для ввода сообщений в окно чата
            var messageForm = document.createElement('form');
            messageForm.className = 'message-form';

            var textarea = document.createElement('textarea');
            textarea.name = 'message';
            textarea.placeholder = 'Введите ваше сообщение...';

            var button = document.createElement('button');
            button.type = 'submit';
            button.textContent = 'Отправить';

            // Добавляем обработчик события для отправки сообщения
            messageForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Предотвращаем отправку формы по умолчанию

                // Получаем текст сообщения из поля ввода
                var messageText = textarea.value.trim();

                // Добавляем сообщение пользователя в окно чата
                var userMessage = document.createElement('div');
                userMessage.className = 'message';
                userMessage.innerHTML = '<span class="sender">Вы</span><span class="timestamp">' + getCurrentTime() + '</span><p class="text">' + messageText + '</p>';
                chatWindow.appendChild(userMessage);

                // Очищаем поле ввода сообщения после отправки
                textarea.value = '';

                // Отправляем сообщение GPT и получаем ответ
                sendToGPT(messageText);
            });

            // Добавляем элементы формы в окно чата
            messageForm.appendChild(textarea);
            messageForm.appendChild(button);
            chatWindow.appendChild(messageForm);
        }

        // Функция для отправки сообщения GPT
        function sendToGPT(messageText) {
            // Делаем AJAX-запрос к серверу с сообщением пользователя
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_message_to_gpt.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    // Добавляем ответ GPT в окно чата
                    addGPTResponse(response.message);
                }
            };
            xhr.send(JSON.stringify({ message: messageText }));
        }

        // Функция для добавления ответа GPT в окно чата
        function addGPTResponse(responseText) {
            var chatWindow = document.querySelector('.chat-window');
            var gptMessage = document.createElement('div');
            gptMessage.className = 'message';
            gptMessage.innerHTML = '<span class="sender">GPT</span><span class="timestamp">' + getCurrentTime() + '</span><p class="text">' + responseText + '</p>';
            chatWindow.appendChild(gptMessage);
        }

        // Функция для получения текущего времени в формате HH:MM
        function getCurrentTime() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            return hours + ':' + minutes;
        }
    </script>
</body>
</html>
