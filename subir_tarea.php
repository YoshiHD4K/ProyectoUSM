<?php
include 'comprobar_sesion.php';
include 'conexion.php';
actualizar_actividad();
header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    actualizar_actividad();
    $id_tarea = $_POST['id_tarea'];
    $id_alumno = $_SESSION['idusuario'];

    $link_tarea = isset($_POST['link_tarea']) ? trim($_POST['link_tarea']) : '';
    $archivo_subido = isset($_FILES['archivo_tarea']) && $_FILES['archivo_tarea']['error'] === UPLOAD_ERR_OK;

    $directorio_subida = 'uploads/';
    $ruta_archivo = '';
    // Validaciones antes de mover el archivo
    $max_file_size = 25 * 1024 * 1024; // 25 MB
    $allowed_extensions = ['pdf', 'docx', 'zip', 'jpg', 'jpeg', 'png'];

    if ($archivo_subido) {
        $file_size = $_FILES['archivo_tarea']['size'];
        $file_ext = strtolower(pathinfo($_FILES['archivo_tarea']['name'], PATHINFO_EXTENSION));

        if ($file_size > $max_file_size) {
            $response['success'] = false;
            $response['error'] = "El archivo es demasiado grande. El tamaño máximo permitido es 25 MB.";
            echo json_encode($response);
            exit();
        }

        if (!in_array($file_ext, $allowed_extensions)) {
            $response['success'] = false;
            $response['error'] = "Tipo de archivo no permitido. Solo se permiten: PDF, DOCX, ZIP, JPG, JPEG, PNG.";
            echo json_encode($response);
            exit();
        }
    }

    if (!$archivo_subido && $link_tarea !== '') {
        // Validar que el link sea una URL válida
        if (!filter_var($link_tarea, FILTER_VALIDATE_URL)) {
            $response['success'] = false;
            $response['error'] = "El enlace ingresado no es una URL válida.";
            echo json_encode($response);
            exit();
        }
    }

    if ($archivo_subido && move_uploaded_file($_FILES['archivo_tarea']['tmp_name'], $ruta_archivo)) {
        // Subida de archivo
    } elseif (!$archivo_subido && $link_tarea !== '') {
        // Subida de link (sin archivo), $ruta_archivo ya contiene el link
    } else {
        $response['success'] = false;
        $response['error'] = "Debes subir un archivo o ingresar un link válido.";
        echo json_encode($response);
        exit();
    }

    // Verificar si ya existe una entrega previa para esta tarea y alumno
    $sql_check = "SELECT id_entrega, archivo FROM entregas_tareas WHERE id_tarea = ? AND id_alumno = ? ORDER BY id_entrega DESC LIMIT 1";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $id_tarea, $id_alumno);
    $stmt_check->execute();
    $stmt_check->store_result();
    if ($stmt_check->num_rows > 0) {
        $stmt_check->bind_result($id_entrega_existente, $archivo_antiguo);
        $stmt_check->fetch();
        // Eliminar archivo anterior si existe y se sube uno nuevo (no borrar si es link)
        if ($archivo_subido && $archivo_antiguo && file_exists($archivo_antiguo)) {
            @unlink($archivo_antiguo);
        }
        // Actualizar la entrega existente con el nuevo archivo o link y fecha
        $sql_update = "UPDATE entregas_tareas SET archivo = ?, fecha_entrega = NOW() WHERE id_entrega = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $ruta_archivo, $id_entrega_existente);
        if ($stmt_update->execute()) {
            $response['success'] = true;
            $response['message'] = "Tarea actualizada con éxito.";
        } else {
            $response['success'] = false;
            $response['error'] = "Error al actualizar la entrega: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        // No existe entrega previa, insertar nueva
        $sql = "INSERT INTO entregas_tareas (id_tarea, id_alumno, archivo, fecha_entrega) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $response['success'] = false;
            $response['error'] = "Error al preparar la consulta: " . $conn->error;
            echo json_encode($response);
            exit();
        }
        $stmt->bind_param("iis", $id_tarea, $id_alumno, $ruta_archivo);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Tarea entregada con éxito.";
        } else {
            $response['success'] = false;
            $response['error'] = "Error al registrar la entrega en la base de datos: " . $stmt->error;
        }
        $stmt->close();
    }
    $stmt_check->close();
} else {
    $response['success'] = false;
    $response['error'] = "Solicitud no válida.";
}
actualizar_actividad();
$conn->close();
echo json_encode($response);
exit();
?>