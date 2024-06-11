<?php
// generate_pdf.php
require_once('vendor/autoload.php');

use setasign\Fpdf\Fpdf;

// Function to generate PDF with table data
function generatePDF($tableName, $db)
{
    $pdf = new Fpdf('L');
    
    // Add the font
    $fontPath = 'font/arial.php'; // Замените на фактический путь к вашему конвертированному шрифту

    if (file_exists($fontPath)) {
        $pdf->AddFont('ArialMT', '', $fontPath);
    } else {
        die('Font file not found.');
    }

    // Add a page
    $pdf->AddPage();

    // Set font for the text
    $pdf->SetFont('ArialMT', '', 12);

    // Fetch table data
    $stmt = $db->query("SELECT * FROM $tableName");
    $headerPrinted = false;

    if ($stmt !== false) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!$headerPrinted) {
                foreach ($row as $key => $value) {
                    $pdf->Cell(30, 10, $key, 1);
                }
                $pdf->Ln();
                $headerPrinted = true;
            }

            foreach ($row as $value) {
                $pdf->Cell(30, 10, $value, 1);
            }
            $pdf->Ln();
        }
    }

    // Output the PDF to browser
    $pdf->Output('table_report.pdf', 'D');
}

// Your database configuration
$host = 'localhost';
$dbname = 'war';
$user = 'postgres';
$pass = '1212!@';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if the 'tableName' parameter is set
    if (isset($_GET['tableName'])) {
        $tableName = $_GET['tableName'];
        generatePDF($tableName, $db);
    } else {
        echo "Table name not provided.";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
