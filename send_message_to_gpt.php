<?php
// Получаем текст сообщения от клиента
$request_data = json_decode(file_get_contents('php://input'), true);
$message = $request_data['message'];

// Параметры для запроса к API GPT
$data = array(
    'prompt' => $message,
    'max_tokens' => 100, // Максимальное количество токенов в ответе GPT
    'temperature' => 0.7, // Параметр, определяющий разнообразие ответа (обычно от 0.1 до 1)
    // Другие параметры, такие как 'engine', 'stop', 'frequency_penalty', 'presence_penalty' и т.д.
);

// Формируем запрос к API GPT
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.openai.com/v1/completions",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: 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" // Замените YOUR_API_KEY на ваш API ключ
    ),
));

// Отправляем запрос к API GPT
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

// Выводим отладочную информацию
echo "Отладочная информация:<br>";
echo "Запрос к API GPT:<br>";
echo json_encode($data) . "<br><br>";
echo "Ответ от API GPT:<br>";
echo $response . "<br><br>";

// Если есть ошибки, выводим их
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // Получаем ответ от API GPT и отправляем его обратно клиенту
    $response_data = json_decode($response, true);
    $gpt_response = $response_data['choices'][0]['text'];
    $response_data = array('message' => $gpt_response);
    echo json_encode($response_data);
}
?>
