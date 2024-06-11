<?php
session_start();

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=war', 'postgres', '1212!@');

    $stmt = $pdo->prepare('SELECT password, role FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['password'] === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = $result['role'];
        $response = ['success' => true, 'role' => $result['role']];
    } else {
        $response['message'] = 'Incorrect username or password';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
