<?php
require_once 'AuthGuard.php';
$auth = AuthGuard::getInstance();
$auth->checkAccess(AuthGuard::NIVEL_USUARIO);

include 'comprobar_sesion.php';
actualizar_actividad();
require 'conexion.php';


// 🔐 Validación de sesión
if (!isset($_SESSION['idusuario'])) {
    header("Location: inicio.php");
    exit();
}

$advertencia = "";

// Obtener el nombre y sección de la materia
$id_materia = $_SESSION['idmateria']; // Usar el id de materia de la sesión
$stmt = $conn->prepare("SELECT nombre, seccion FROM materias WHERE id = ?");
$stmt->bind_param("i", $id_materia);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $_SESSION['nombre_materia'] = $row['nombre'];
    $_SESSION['seccion_materia'] = $row['seccion'];
} else {
    $_SESSION['nombre_materia'] = "Materia no encontrada";
    $_SESSION['seccion_materia'] = "";
}
$stmt->close();

// 📨 Enviar mensaje de texto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {

    // Actualizar actividad del usuario
    actualizar_actividad();

    $user_id = $_SESSION['idusuario'];
    $group_id = $_SESSION['idmateria'];
    $reply_to = isset($_POST['reply_to']) ? (int) $_POST['reply_to'] : 0;
    $message = trim($_POST['message']);

    if (strlen($message) > 0 && strlen($message) <= 250) {
        // Permitir letras, números, espacios, puntuación básica y emojis
        if (preg_match('/^[\p{L}\p{N}\s\.,!?;:()@#$%*+\-=_<>\/\\\\]+$/u', $message)) {
            // Mensaje válido, puedes procesarlo con confianza

            $stmt = $conn->prepare("INSERT INTO messages (user_id, message, group_id, tipo, reply_to) VALUES (?, ?, ?, 'texto', ?)");
            $stmt->bind_param("isii", $user_id, $message, $group_id, $reply_to);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error al guardar el mensaje']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'El mensaje contiene caracteres no permitidos']);
        }
    } else {
        echo json_encode(['error' => 'El mensaje debe tener entre 1 y 1000 caracteres']);
    }
    exit();
}

// 🖼️ Enviar imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Actualizar actividad del usuario
    actualizar_actividad();

    $image = $_FILES['image'];
    $user_id = $_SESSION['idusuario'];
    $group_id = $_SESSION['idmateria'];
    $reply_to = isset($_POST['reply_to']) ? (int) $_POST['reply_to'] : 0;

    // ✅ Validación de imagen
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($image['type'], $allowed_types)) {
        echo json_encode(['error' => 'Tipo de imagen no permitido']);
        exit();
    }

    if ($image['size'] > $max_size) {
        echo json_encode(['error' => 'La imagen es demasiado grande (máximo 5MB)']);
        exit();
    }

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // ✅ Sanitizar nombre de archivo
    $file_extension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO messages (user_id, message, group_id, tipo, reply_to) VALUES (?, ?, ?, 'imagen', ?)");
        $stmt->bind_param("isii", $user_id, $target_file, $group_id, $reply_to);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'file' => $target_file]);
        } else {
            echo json_encode(['error' => 'Error al guardar la imagen']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al subir la imagen']);
    }
    exit();
}

// 📁 Enviar archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    // Actualizar actividad del usuario
    actualizar_actividad();

    $file = $_FILES['file'];
    $user_id = $_SESSION['idusuario'];
    $group_id = $_SESSION['idmateria'];
    $reply_to = isset($_POST['reply_to']) ? (int) $_POST['reply_to'] : 0;

    // ✅ Validación de archivo
    $allowed_types = [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/pdf'
    ];
    $max_size = 10 * 1024 * 1024; // 10MB

    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['error' => 'Tipo de archivo no permitido']);
        exit();
    }

    if ($file['size'] > $max_size) {
        echo json_encode(['error' => 'El archivo es demasiado grande (máximo 10MB)']);
        exit();
    }

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // ✅ Sanitizar nombre de archivo
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO messages (user_id, message, group_id, tipo, reply_to) VALUES (?, ?, ?, 'archivo', ?)");
        $stmt->bind_param("isii", $user_id, $target_file, $group_id, $reply_to);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'file' => $target_file]);
        } else {
            echo json_encode(['error' => 'Error al guardar el archivo']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error al subir el archivo']);
    }
    exit();
}

// 💬 Mostrar historial de mensajes
$idgrupo = $_SESSION['idmateria'];

$stmt = $conn->prepare("
    SELECT 
        messages.id, 
        messages.message, 
        messages.created_at, 
        messages.tipo, 
        messages.reply_to,
        usuarios.id AS user_id, 
        usuarios.nombre_usuario, 
        usuarios.nivel_usuario,
        foto
    FROM messages
    JOIN usuarios ON messages.user_id = usuarios.id
    LEFT JOIN fotousuario ON usuarios.id = id_usuario
    WHERE messages.group_id = ?
    ORDER BY messages.created_at ASC
");

$stmt->bind_param("i", $idgrupo);
$stmt->execute();
$result = $stmt->get_result();

$last_date = null;
$last_user_id = null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="css/icono.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principalalumnostyle.css">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="css/chat_actions.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Noto+Sans+KR:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* SOLO rediseño el área central del chat y barra de entrada, sin tocar header ni menú */
        .chat-dashboard-area {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: flex-start;
            width: 100vw;
            height: calc(100vh - 120px);
            background: #f4f8fb;
            transition: background 0.3s ease;
        }

        body.dark-mode .chat-dashboard-area {
            background: #1a1a1a;
        }

        .sidebar-materias {
            width: 270px;
            height: 100%;
            background: #fff;
            border-radius: 18px 0 0 18px;
            box-shadow: 0 8px 32px rgba(33, 53, 85, 0.10);
            margin: 32px 0 0 32px;
            padding: 24px 0 24px 0;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            position: relative;
            margin-right: 24px;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        body.dark-mode .sidebar-materias {
            background: #2d2d2d;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .sidebar-materias h2 {
            text-align: center;
            color: #213555;
            font-size: 1.2rem;
            margin-bottom: 18px;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        body.dark-mode .sidebar-materias h2 {
            color: #ffffff;
        }

        .lista-materias {
            flex: 1;
            overflow-y: auto;
            padding: 0 18px;
        }

        .materia-item {
            background: #f7fafc;
            border-radius: 10px;
            margin-bottom: 12px;
            padding: 12px 16px;
            color: #213555;
            font-weight: 500;
            cursor: pointer;
            border: 2px solid transparent;
            transition: background 0.2s, border 0.2s, color 0.2s;
        }

        body.dark-mode .materia-item {
            background: #3a3a3a;
            color: #e0e0e0;
        }

        .materia-item.selected,
        .materia-item:hover {
            background: #174388;
            border: 2px solid #0e3470;
            color: white;
        }

        .chat-dashboard-main {
            background: #fff;
            width: 1400px;
            height: 100%;
            margin: 32px 32px 32px 0;
            border-radius: 0 18px 18px 0;
            box-shadow: 0 8px 32px rgba(33, 53, 85, 0.10);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        body.dark-mode .chat-dashboard-main {
            background: #2d2d2d;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 1500px) {
            .chat-dashboard-main {
                width: 1100px;
            }
        }

        @media (max-width: 1200px) {
            .chat-dashboard-main {
                width: 900px;
            }
        }

        @media (max-width: 950px) {

            .chat-dashboard-main,
            .sidebar-materias {
                width: 100vw;
                min-width: 0;
                border-radius: 0;
                margin: 0;
            }

            .chat-dashboard-area {
                flex-direction: column;
            }
        }

        .chat-dashboard-messages {
            flex: 1;
            overflow-y: auto;
            padding: 32px 40px 24px 40px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            background: #f7fafc;
            border-radius: 18px 18px 0 0;
            min-height: 0;
            transition: background 0.3s ease;
        }

        body.dark-mode .chat-dashboard-messages {
            background: #1e1e1e;
        }

        .chat-dashboard-entry {
            width: 100%;
            background: #fff;
            border-radius: 0 0 18px 18px;
            box-shadow: 0 -2px 12px rgba(33, 53, 85, 0.04);
            padding: 18px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-top: 1px solid #e6e6e6;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        body.dark-mode .chat-dashboard-entry {
            background: #2d2d2d;
            border-top: 1px solid #404040;
        }

        .chat-dashboard-entry input[type="text"] {
            border-radius: 24px;
            border: 1px solid #e0e0e0;
            padding: 12px 18px;
            font-size: 1.1rem;
            background: #f7f7f7;
            color: #333;
            transition: border 0.2s, background 0.2s, color 0.2s;
            flex: 1;
        }

        .chat-dashboard-entry input[type="text"]:focus {
            border: 1.5px solid #ffd166;
            background: #fffbe6;
        }

        body.dark-mode .chat-dashboard-entry input[type="text"] {
            background: #404040;
            border: 1px solid #555;
            color: #ffffff;
        }

        body.dark-mode .chat-dashboard-entry input[type="text"]:focus {
            border: 1.5px solid #ffd166;
            background: #4a4a4a;
        }

        .chat-dashboard-entry .button {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.1s;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #174388;
            border: none;
        }

        .chat-dashboard-entry .button:active {
            transform: scale(0.95);
        }

        .chat-dashboard-entry .button img {
            width: 28px;
            height: 28px;
        }

        .chat-dashboard-reply {
            background: #f1f1f1;
            border-left: 4px solid #007bff;
            border-radius: 10px;
            padding: 8px 12px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.98rem;
            width: 100%;
            transition: background 0.3s ease;
        }

        body.dark-mode .chat-dashboard-reply {
            background: #404040;
        }

        .chat-dashboard-reply #reply-to-user {
            color: #2196f3;
            font-weight: 600;
        }

        .chat-dashboard-reply #cancel-reply {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="contenedorentrante3">
        <img src="css/logo.png">
    </div>
    <div class="cabecera cabecera-chat">
        <button type="button" id="logoButton">
            <img src="css/logo.png" alt="Logo">
        </button>
        <div class="nombremateria">
            <h1><?php echo htmlspecialchars($_SESSION['nombremateria'] ?? 'Chat') ?></h1>
        </div>
        <div class="logoempresa">
            <img src="css/logounihubblanco.png" alt="Logo" class="logounihub">
            <p>UH</p>
        </div>
    </div>
    <?php include 'menu_alumno.php'; ?>
    <div class="chat-dashboard-area">
        <?php
        // Sidebar de materias
        require 'conexion.php';
        $id_usuario = $_SESSION['idusuario'];
        $materias = [];
        $materia_actual = isset($_SESSION['idmateria']) ? $_SESSION['idmateria'] : null;
        $sql = "SELECT m.id, m.nombre, m.seccion FROM inscripciones i JOIN materias m ON i.id_materia = m.id WHERE i.id_estudiante = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
        $stmt->close();
        ?>
        <div class="sidebar-materias">
            <h2>Mis Materias</h2>
            <div class="lista-materias">
                <?php foreach ($materias as $mat): ?>
                    <div class="materia-item<?php if ($materia_actual == $mat['id'])
                        echo ' selected'; ?>"
                        onclick="window.location.href='dirigirchat.php?valor=<?php echo $mat['id']; ?>'">
                        <?php echo htmlspecialchars($mat['nombre']) . ' (' . htmlspecialchars($mat['seccion']) . ')'; ?>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($materias)): ?>
                    <div style="color:#888; text-align:center; margin-top:30px;">No tienes materias inscritas.</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="chat-dashboard-main">
            <div class="chat-dashboard-messages" id="chat-box">
                <!-- Los mensajes se cargan aquí dinámicamente -->
            </div>

            <div class="chat-entry-wrapper">
                <div class="chat-dashboard-entry">
                    <div id="reply-preview" class="chat-dashboard-reply" style="display: none;">
                        <div id="reply-to-user"></div>
                        <div id="reply-message"></div>
                        <button id="cancel-reply" class="buttoncancel">Cancelar</button>
                    </div>
                    <button id="upload-button" class="button" title="Subir archivo o imagen">
                        <img src="css/plus-pequeno.png" alt="Upload">
                    </button>
                    <input type="text" id="message" placeholder="Escribe un mensaje..." maxlength="1000" />
                    <button id="send-button" class="button" title="Enviar mensaje">
                        <img src="css/enviar-mensaje.png" alt="Send">
                    </button>
                    <input type="file" id="imageInput" accept="image/*" style="display: none;">
                    <input type="file" id="fileInput" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf"
                        style="display: none;">
                    <button id="call-button" class="button" title="Llamada">
                        <img src="css/llamada_alumno.png" alt="Call">
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="upload-menu" style="display: none;">
        <div class="upload-option" id="upload-image">Subir Imagen</div>
        <div class="upload-option" id="upload-file">Subir Archivo</div>
    </div>
    <?php if ($advertencia) { ?>
        <div class="advertencia-flotante"
            style="position: fixed; top: 30px; right: 30px; z-index: 9999; background: #ffdddd; color: #a94442; border: 1px solid #a94442; border-radius: 8px; padding: 16px 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); font-weight: bold;">
            <p style="margin:0;"><?php echo htmlspecialchars($advertencia); ?></p>
        </div>
        <script>
            setTimeout(function () {
                var adv = document.querySelector('.advertencia-flotante');
                if (adv) adv.style.display = 'none';
            }, 3500);
        </script>
    <?php } ?>

    <script>
        // 🔧 Configuración global
        const CONFIG = {
            maxMessageLength: 1000,
            maxImageSize: 5 * 1024 * 1024, // 5MB
            maxFileSize: 10 * 1024 * 1024, // 10MB
            allowedImageTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            allowedFileTypes: [
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/pdf'
            ]
        };

        // 🎨 Gestión de tema
        function initTheme() {
            const theme = localStorage.getItem('theme') || 'light';
            const switchElement = document.getElementById('switchtema');

            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
                switchElement.checked = true;
            } else {
                document.body.classList.remove('dark-mode');
                switchElement.checked = false;
            }

            document.cookie = "theme=" + theme + "; path=/";
        }

        function setTheme(theme) {
            localStorage.setItem('theme', theme);
            document.cookie = "theme=" + theme + "; path=/";

            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }

            // Enviar al backend
            fetch('set_theme.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'theme=' + theme
            }).catch(error => console.error('Error setting theme:', error));
        }

        // 📱 Navegación
        function goBack() {
            window.history.back();
        }

        function redirigir(url) {
            window.location.href = url;
        }

        // 🎯 Event Listeners principales
        document.addEventListener('DOMContentLoaded', function () {
            initTheme();
            loadMessages();
            setupEventListeners();
            setupNavigation();
        });

        // 🔗 Configurar navegación
        function setupNavigation() {
            const navItems = {
                'inicio': 'pagina_principal.php',
                'datos': 'datos.php',
                'inscripcion': 'inscripcion.php',
                'horario': 'horario.php',
                'chat': 'seleccionarmateria.php',
                'foto': 'foto.php',
                'desempeño': 'Seleccion_de_materias_tareas.php'
            };

            Object.keys(navItems).forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('click', () => redirigir(navItems[id]));
                }
            });
        }

        // 🎛️ Configurar event listeners
        function setupEventListeners() {

            // Tema
            const themeSwitch = document.getElementById('switchtema');
            if (themeSwitch) {
                themeSwitch.addEventListener('change', function () {
                    setTheme(this.checked ? 'dark' : 'light');
                });
            }

            // Scroll del menú
            const contenedor = document.getElementById('contenedor');
            const botonIzquierdo = document.getElementById('boton-izquierdo');
            const botonDerecho = document.getElementById('boton-derecho');

            botonIzquierdo.addEventListener('click', () => {
                contenedor.scrollBy({ left: -94, behavior: 'smooth' });
            });

            botonDerecho.addEventListener('click', () => {
                contenedor.scrollBy({ left: 94, behavior: 'smooth' });
            });

            // Cerrar menú al hacer clic fuera
            document.addEventListener('click', function (event) {
                var div = document.getElementById('menu');
                if (!div.contains(event.target)) {
                    div.classList.remove('toggle');
                }
            });

            // Mensajes
            setupMessageHandlers();
            setupFileHandlers();


        }

        // 💬 Configurar manejo de mensajes
        function setupMessageHandlers() {
            const sendButton = document.getElementById('send-button');
            const messageInput = document.getElementById('message');
            const cancelReplyButton = document.getElementById('cancel-reply');

            sendButton.addEventListener('click', sendMessage);

            messageInput.addEventListener('keypress', function (e) {
                if (e.which === 13) {
                    sendMessage();
                    return false;
                }
            });

            cancelReplyButton.addEventListener('click', function () {
                hideReplyPreview();
            });

            // Respuestas
            $(document).on('click', '.reply-button', function () {
                const messageId = $(this).data('message-id');
                const userName = $(this).data('username');
                const messageContent = $('#message-text-' + messageId).text();
                showReplyPreview(userName, messageContent, messageId);
            });
        }

        // 📁 Configurar manejo de archivos
        function setupFileHandlers() {
            const uploadButton = document.getElementById('upload-button');
            const uploadMenu = document.getElementById('upload-menu');
            const uploadImage = document.getElementById('upload-image');
            const uploadFile = document.getElementById('upload-file');
            const imageInput = document.getElementById('imageInput');
            const fileInput = document.getElementById('fileInput');

            uploadButton.addEventListener('click', function (event) {
                uploadMenu.style.display = uploadMenu.style.display === 'block' ? 'none' : 'block';
                event.stopPropagation();
            });

            document.addEventListener('click', function (event) {
                if (!uploadMenu.contains(event.target) && !uploadButton.contains(event.target)) {
                    uploadMenu.style.display = 'none';
                }
            });

            uploadImage.addEventListener('click', () => imageInput.click());
            uploadFile.addEventListener('click', () => fileInput.click());

            imageInput.addEventListener('change', handleImageUpload);
            fileInput.addEventListener('change', handleFileUpload);
        }

        // 📤 Enviar mensaje
        function sendMessage() {
            const message = $('#message').val().trim();
            const replyTo = $('#reply-preview').data('reply-to') || 0;

            if (message.length === 0) {
                showError('El mensaje no puede estar vacío');
                return;
            }

            if (message.length > CONFIG.maxMessageLength) {
                showError('El mensaje es demasiado largo');
                return;
            }

            $.post('chat.php', {
                message: message,
                reply_to: replyTo
            })
                .done(function (data) {
                    try {
                        const response = JSON.parse(data);
                        if (response.success) {
                            $('#message').val('');
                            hideReplyPreview();
                            loadMessages();
                            // Forzar scroll al final después de enviar
                            setTimeout(() => {
                                forceScrollToBottom();
                            }, 100);
                        } else {
                            showError(response.error || 'Error al enviar el mensaje');
                        }
                    } catch (e) {
                        showError('Error al procesar la respuesta del servidor');
                    }
                })
                .fail(function (xhr, status, error) {
                    showError('Error de conexión: ' + error);
                });
        }

        // 🖼️ Manejar subida de imagen
        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!CONFIG.allowedImageTypes.includes(file.type)) {
                showError('Tipo de imagen no permitido');
                return;
            }

            if (file.size > CONFIG.maxImageSize) {
                showError('La imagen es demasiado grande (máximo 5MB)');
                return;
            }

            uploadFile(file, 'image');
        }

        // 📄 Manejar subida de archivo
        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!CONFIG.allowedFileTypes.includes(file.type)) {
                showError('Tipo de archivo no permitido');
                return;
            }

            if (file.size > CONFIG.maxFileSize) {
                showError('El archivo es demasiado grande (máximo 10MB)');
                return;
            }

            uploadFile(file, 'file');
        }

        // 📤 Subir archivo genérico
        function uploadFile(file, type) {
            const formData = new FormData();
            formData.append(type, file);
            formData.append('reply_to', $('#reply-preview').data('reply-to') || 0);

            fetch('chat.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    try {
                        const response = JSON.parse(data);
                        if (response.success) {
                            hideReplyPreview();
                            loadMessages();
                            document.getElementById('upload-menu').style.display = 'none';
                            // Forzar scroll al final después de subir archivo
                            setTimeout(() => {
                                forceScrollToBottom();
                            }, 100);
                        } else {
                            showError(response.error || 'Error al subir el archivo');
                        }
                    } catch (e) {
                        showError('Error al procesar la respuesta del servidor');
                    }
                })
                .catch(error => {
                    showError('Error de conexión: ' + error);
                });
        }

        // 🔄 Cargar mensajes
        function loadMessages() {
            $.get('load_messages.php')
                .done(function (data) {
                    $('#chat-box').html(data);
                    autoScroll();
                })
                .fail(function (xhr, status, error) {
                    console.error('Error loading messages:', error);
                });
        }



        // 🗑️ Eliminar mensaje
        function deleteMessage(messageId) {
            if (confirm('¿Estás seguro de que quieres eliminar este mensaje? Esta acción no se puede deshacer.')) {
                $.post('delete_message.php', {
                    message_id: messageId
                })
                    .done(function (data) {
                        try {
                            const response = JSON.parse(data);
                            if (response.success) {
                                loadMessages(); // Recargar mensajes para mostrar el cambio
                            } else {
                                showError(response.error || 'Error al eliminar el mensaje');
                            }
                        } catch (e) {
                            showError('Error al procesar la respuesta del servidor');
                        }
                    })
                    .fail(function (xhr, status, error) {
                        showError('Error de conexión: ' + error);
                    });
            }
        }

        // 📍 Auto-scroll
        let isUserScrolling = false;
        let userScrolledUp = false;

        $('#chat-box').on('scroll', function () {
            isUserScrolling = true;
            if ($(this).scrollTop() < $(this)[0].scrollHeight - $(this).innerHeight()) {
                userScrolledUp = true;
            } else {
                userScrolledUp = false;
            }
        });

        function autoScroll() {
            if (!isUserScrolling && !userScrolledUp) {
                $('#chat-box').animate({
                    scrollTop: $('#chat-box')[0].scrollHeight
                }, 'normal');
            }
        }

        // 📍 Forzar scroll al final (sin condiciones)
        function forceScrollToBottom() {
            $('.chat-dashboard-messages').animate({
                scrollTop: $('.chat-dashboard-messages')[0].scrollHeight
            }, 'fast');
        }

        // 🔄 Actualizar mensajes cada 2 segundos
        setInterval(loadMessages, 2000);

        // 🎯 Funciones auxiliares
        function showReplyPreview(userName, messageContent, messageId) {
            $('#reply-to-user').text('Respondiendo a: ' + userName);
            $('#reply-message').html(messageContent);
            $('#reply-preview').show().data('reply-to', messageId);
            $('#message').focus();
        }

        function hideReplyPreview() {
            $('#reply-preview').hide().data('reply-to', null);
        }

        function showError(message) {
            alert(message); // Mejorar con una notificación más elegante
        }
    </script>


</body>

</html>