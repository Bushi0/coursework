<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include your database configuration here
$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

try {
    // Create a PDO connection
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get values from the AJAX request
    $fullNameCadets = $_POST['fullNameCadets'];
    $fullNameTeachers = $_POST['fullNameTeachers'];
    $point = $_POST['point'];
    $nameDisciplines = $_POST['nameDisciplines'];

    // Prepare and execute the stored procedure
    $stmt = $db->prepare("CALL insertgradeafterexam_8(:fullNameCadets, :fullNameTeachers, :point, :nameDisciplines)");
    $stmt->bindParam(':fullNameCadets', $fullNameCadets);
    $stmt->bindParam(':fullNameTeachers', $fullNameTeachers);
    $stmt->bindParam(':point', $point, PDO::PARAM_INT);
    $stmt->bindParam(':nameDisciplines', $nameDisciplines);

    $stmt->execute();

    // Send a success response
    $response = array('success' => true);
    echo json_encode($response);
} catch (PDOException $e) {
    // Send an error response
    $response = array('success' => false, 'error' => $e->getMessage());
    echo json_encode($response);
}
?>
