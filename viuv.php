<?php
require 'confih.php';

try {
    $table = 'cadets';
    $stmt = $pdo->query("SELECT * FROM $table");
    
    echo '<h2>View Cadets</h2>';
    echo '<table border="1">
            <tr>';
    
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $col = $stmt->getColumnMeta($i);
        echo '<th>' . $col['name'] . '</th>';
    }
    echo '</tr>';
    
    while ($row = $stmt->fetch()) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . htmlspecialchars($cell) . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
