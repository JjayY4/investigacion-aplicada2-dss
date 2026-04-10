<?php
header('Content-Type: application/json; charset=utf-8');

require_once 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

function response(bool $success, string $message, $data = null): void
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    switch ($action) {

        case 'students':
            $stmt = $pdo->query("SELECT id, nombre FROM estudiantes ORDER BY nombre ASC");
            $students = $stmt->fetchAll();

            response(true, 'Estudiantes obtenidos correctamente', $students);
            break;

        case 'create':
            $estudiante_id = isset($_POST['estudiante_id']) ? (int) $_POST['estudiante_id'] : 0;
            $asignatura = trim($_POST['asignatura'] ?? '');
            $nota = $_POST['nota'] ?? '';

            if ($estudiante_id <= 0 || $asignatura === '' || $nota === '') {
                response(false, 'Todos los campos son obligatorios');
            }

            if (!is_numeric($nota)) {
                response(false, 'La nota debe ser numérica');
            }

            $nota = (float) $nota;

            if ($nota < 0 || $nota > 10) {
                response(false, 'La nota debe estar entre 0 y 10');
            }

            $checkStudent = $pdo->prepare("SELECT id FROM estudiantes WHERE id = ?");
            $checkStudent->execute([$estudiante_id]);

            if (!$checkStudent->fetch()) {
                response(false, 'El estudiante seleccionado no existe');
            }

            $stmt = $pdo->prepare("
                INSERT INTO notas (estudiante_id, asignatura, nota)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$estudiante_id, $asignatura, $nota]);

            response(true, 'Nota registrada correctamente');
            break;

        case 'list':
            $stmt = $pdo->query("
                SELECT 
                    n.id,
                    n.estudiante_id,
                    e.nombre AS estudiante,
                    n.asignatura,
                    n.nota
                FROM notas n
                INNER JOIN estudiantes e ON e.id = n.estudiante_id
                ORDER BY n.id DESC
            ");

            $notas = $stmt->fetchAll();

            response(true, 'Notas obtenidas correctamente', $notas);
            break;

        case 'average':
            $stmt = $pdo->query("
                SELECT ROUND(AVG(nota), 2) AS promedio
                FROM notas
            ");
            $result = $stmt->fetch();

            response(true, 'Promedio obtenido correctamente', [
                'promedio' => $result['promedio'] ?? 0
            ]);
            break;

        case 'get':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

            if ($id <= 0) {
                response(false, 'ID inválido');
            }

            $stmt = $pdo->prepare("
                SELECT id, estudiante_id, asignatura, nota
                FROM notas
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            $nota = $stmt->fetch();

            if (!$nota) {
                response(false, 'La nota no existe');
            }

            response(true, 'Nota obtenida correctamente', $nota);
            break;

        case 'update':
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            $estudiante_id = isset($_POST['estudiante_id']) ? (int) $_POST['estudiante_id'] : 0;
            $asignatura = trim($_POST['asignatura'] ?? '');
            $nota = $_POST['nota'] ?? '';

            if ($id <= 0 || $estudiante_id <= 0 || $asignatura === '' || $nota === '') {
                response(false, 'Todos los campos son obligatorios');
            }

            if (!is_numeric($nota)) {
                response(false, 'La nota debe ser numérica');
            }

            $nota = (float) $nota;

            if ($nota < 1 || $nota > 10) {
                response(false, 'La nota debe estar entre 1 y 10');
            }

            $checkNote = $pdo->prepare("SELECT id FROM notas WHERE id = ?");
            $checkNote->execute([$id]);

            if (!$checkNote->fetch()) {
                response(false, 'La nota a actualizar no existe');
            }

            $checkStudent = $pdo->prepare("SELECT id FROM estudiantes WHERE id = ?");
            $checkStudent->execute([$estudiante_id]);

            if (!$checkStudent->fetch()) {
                response(false, 'El estudiante seleccionado no existe');
            }

            $stmt = $pdo->prepare("
                UPDATE notas
                SET estudiante_id = ?, asignatura = ?, nota = ?
                WHERE id = ?
            ");
            $stmt->execute([$estudiante_id, $asignatura, $nota, $id]);

            response(true, 'Nota actualizada correctamente');
            break;
        case 'delete':
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

            if ($id <= 0) {
                response(false, 'ID inválido');
            }

            $checkNote = $pdo->prepare("SELECT id FROM notas WHERE id = ?");
            $checkNote->execute([$id]);

            if (!$checkNote->fetch()) {
                response(false, 'La nota no existe');
            }

            $stmt = $pdo->prepare("DELETE FROM notas WHERE id = ?");
            $stmt->execute([$id]);

            response(true, 'Nota eliminada correctamente');
            break;

        default:
            response(false, 'Acción no válida');
    }
} catch (PDOException $e) {
    response(false, 'Error de base de datos: ' . $e->getMessage());
} catch (Exception $e) {
    response(false, 'Error general: ' . $e->getMessage());
}