<?php
require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM estudiantes");
    $estudiantes = $stmt->fetchAll();

    echo "<pre>";
    print_r($estudiantes);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}