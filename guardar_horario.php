<?php
require 'conexion.php';
header('Content-Type: application/json');

// Validaciones de seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Sanitizar y validar datos de entrada
$materia_id = filter_var($_POST['materia_id'] ?? null, FILTER_VALIDATE_INT);
$dia = trim(htmlspecialchars(strip_tags($_POST['dia'] ?? ''), ENT_QUOTES, 'UTF-8'));
$hora_inicio = trim(htmlspecialchars(strip_tags($_POST['hora_inicio'] ?? ''), ENT_QUOTES, 'UTF-8'));
$hora_fin = trim(htmlspecialchars(strip_tags($_POST['hora_fin'] ?? ''), ENT_QUOTES, 'UTF-8'));

// Validaciones
if (!$materia_id || !$dia || !$hora_inicio || !$hora_fin) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
    exit();
}

// Validar formato de día
$diasPermitidos = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
if (!in_array($dia, $diasPermitidos)) {
    echo json_encode(['success' => false, 'message' => 'Día no válido']);
    exit();
}

// Validar formato de hora (HH:MM)
if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $hora_inicio) || 
    !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $hora_fin)) {
    echo json_encode(['success' => false, 'message' => 'Formato de hora no válido']);
    exit();
}

// Validar que la materia existe
$sql_materia = "SELECT id FROM materias WHERE id = ?";
$stmt_materia = $conn->prepare($sql_materia);
$stmt_materia->bind_param("i", $materia_id);
$stmt_materia->execute();
$result_materia = $stmt_materia->get_result();

if ($result_materia->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'La materia no existe']);
    exit();
}

// Validar que la hora de fin sea mayor que la hora de inicio
if ($hora_fin <= $hora_inicio) {
    echo json_encode(['success' => false, 'message' => 'La hora de fin debe ser mayor que la hora de inicio']);
    exit();
}

// Verificar si ya existe un horario para este día y materia
$sql_check = "SELECT id FROM horariosmateria WHERE id_materia = ? AND dia = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("is", $materia_id, $dia);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Ya existe un horario para este día']);
    exit();
}

// Insertar el nuevo horario
$sql_insert = "INSERT INTO horariosmateria (id_materia, dia, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("isss", $materia_id, $dia, $hora_inicio, $hora_fin);

if ($stmt_insert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Horario guardado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el horario: ' . $conn->error]);
}
$conn->close();
?> 