<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="css/icono.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principaladministracion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Noto+Sans+KR:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Inicio - USM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            --background-color: #d4d4d4;
            --bg-container: #f9f9f9;
            color: #333;
        }

        body.dark-mode {
            --background-color: #1a1a1a;
            --bg-container: rgb(47, 47, 47);
            color: white;
        }

        .container {
            max-width: 1000px;
            /* Ajustar el ancho del contenedor */
            margin: auto;
            background-color: var(--bg-container);
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            /* Añadir transición a los cambios */
            display: flex;
            flex-direction: column;
            align-items: center;
            align-content: center;
            height: auto;
            animation: fadeIn 1s ease-in-out;
        }

        /* Animación de desvanecimiento */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        h1 {
            text-align: center;
            font-family: 'Lobster', cursive;
            font-size: 60px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        /* Estilos para los elementos del formulario */
        select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 300px;
        }

        .btn-modificar {
            padding: 10px;
            border-radius: 20px;
            padding: 8px 16px;
            border: 1px solid #ccc;
            transition: background-color 0.3s ease, transform 0.3s ease;
            background-color: rgb(69, 160, 160);
            color: white;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            max-width: 300px;
        }

        .btn-modificar:hover {
            background-color: rgb(69, 160, 160);
            transform: scale(1.05);
        }

        .btn-modificar:active {
            transform: scale(0.95);
        }

        .btn-container {
            display: flex;
            justify-content: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--bg-container);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        th {
            background-color: rgb(69, 160, 160);
            color: white;
        }

        body.dark-mode th {
            background-color: rgb(45, 120, 120);
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        body.dark-mode td {
            border-bottom: 1px solid #555;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        body.dark-mode tr:nth-child(even) {
            background-color: #333;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        body.dark-mode tr:hover {
            background-color: #444;
        }
    </style>
</head>

<body>

    <div class="cabecera">

        <button type="button" id="logoButton">
            <img src="css/logoazul.png" alt="Logo">
        </button>
        <div class="logoempresa">
            <img src="css/logounihubblanco.png" alt="Logo" class="logounihub">
            <p>UniHub</p>
        </div>

    </div>

    <div class="menu" id="menu">
        <div class="menuopc">
            <button class="boton" id="boton-izquierdo">
                <svg width="11px" height="20px" viewBox="0 0 11 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>arrow_back_ios</title>
                    <desc>Created with Sketch.</desc>
                    <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Rounded" transform="translate(-548.000000, -3434.000000)">
                            <g id="Navigation" transform="translate(100.000000, 3378.000000)">
                                <g id="-Round-/-Navigation-/-arrow_back_ios" transform="translate(442.000000, 54.000000)">
                                    <g>
                                        <polygon id="Path" opacity="0.87" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M16.62,2.99 C16.13,2.5 15.34,2.5 14.85,2.99 L6.54,11.3 C6.15,11.69 6.15,12.32 6.54,12.71 L14.85,21.02 C15.34,21.51 16.13,21.51 16.62,21.02 C17.11,20.53 17.11,19.74 16.62,19.25 L9.38,12 L16.63,4.75 C17.11,4.27 17.11,3.47 16.62,2.99 Z" id="馃敼-Icon-Color" fill="#1D1D1D"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </button>
            <div class="menuopciones" id="contenedor">
                <div class="opción">
                    <div class="intopcion" id="inicio">
                        <img src="css\home.png">
                        <p>Inicio</p>
                    </div>
                </div>
                <div class="opción">
                    <div class="intopcion" id="datos">
                        <img src="css\person.png">
                        <p>Datos</p>
                    </div>
                </div>
                <div class="opción">
                    <div class="intopcion" id="profesor">
                        <img src="css/profesor.png">
                        <p>Profesores</p>
                    </div>
                </div>
                <div class="opción">
                    <div class="intopcion" id="alumno">
                        <img src="css/alumno.png">
                        <p>Alumnos</p>
                    </div>
                </div>
                <div class="opción">
                    <div class="intopcion" id="materias">
                        <img src="css/horario.png">
                        <p>Materias</p>
                    </div>
                </div>
            </div>
            <button class="boton" id="boton-derecho">
                <svg width="11px" height="20px" viewBox="0 0 11 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>arrow_forward_ios</title>
                    <desc>Created with Sketch.</desc>
                    <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Rounded" transform="translate(-345.000000, -3434.000000)">
                            <g id="Navigation" transform="translate(100.000000, 3378.000000)">
                                <g id="-Round-/-Navigation-/-arrow_forward_ios" transform="translate(238.000000, 54.000000)">
                                    <g>
                                        <polygon id="Path" opacity="0.87" points="24 24 0 24 0 0 24 0"></polygon>
                                        <path d="M7.38,21.01 C7.87,21.5 8.66,21.5 9.15,21.01 L17.46,12.7 C17.85,12.31 17.85,11.68 17.46,11.29 L9.15,2.98 C8.66,2.49 7.87,2.49 7.38,2.98 C6.89,3.47 6.89,4.26 7.38,4.75 L14.62,12 L7.37,19.25 C6.89,19.73 6.89,20.53 7.38,21.01 Z" id="馃敼-Icon-Color" fill="#1D1D1D"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </button>
        </div>
        <div class="inferior">
            <form action="logout.php" method="POST">
                <div class="logout">
                    <button class="Btn">

                        <div class="sign"><svg viewBox="0 0 512 512">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                            </svg></div>

                        <div class="text">Salir</div>
                    </button>
                </div>
            </form>
            <div class="themeswitcher">
                <label class="theme-switch">
                    <input type="checkbox" class="theme-switch__checkbox" id="switchtema">
                    <div class="theme-switch__container">
                        <div class="theme-switch__clouds"></div>
                        <div class="theme-switch__stars-container">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144 55" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M135.831 3.00688C135.055 3.85027 134.111 4.29946 133 4.35447C134.111 4.40947 135.055 4.85867 135.831 5.71123C136.607 6.55462 136.996 7.56303 136.996 8.72727C136.996 7.95722 137.172 7.25134 137.525 6.59129C137.886 5.93124 138.372 5.39954 138.98 5.00535C139.598 4.60199 140.268 4.39114 141 4.35447C139.88 4.2903 138.936 3.85027 138.16 3.00688C137.384 2.16348 136.996 1.16425 136.996 0C136.996 1.16425 136.607 2.16348 135.831 3.00688ZM31 23.3545C32.1114 23.2995 33.0551 22.8503 33.8313 22.0069C34.6075 21.1635 34.9956 20.1642 34.9956 19C34.9956 20.1642 35.3837 21.1635 36.1599 22.0069C36.9361 22.8503 37.8798 23.2903 39 23.3545C38.2679 23.3911 37.5976 23.602 36.9802 24.0053C36.3716 24.3995 35.8864 24.9312 35.5248 25.5913C35.172 26.2513 34.9956 26.9572 34.9956 27.7273C34.9956 26.563 34.6075 25.5546 33.8313 24.7112C33.0551 23.8587 32.1114 23.4095 31 23.3545ZM0 36.3545C1.11136 36.2995 2.05513 35.8503 2.83131 35.0069C3.6075 34.1635 3.99559 33.1642 3.99559 32C3.99559 33.1642 4.38368 34.1635 5.15987 35.0069C5.93605 35.8503 6.87982 36.2903 8 36.3545C7.26792 36.3911 6.59757 36.602 5.98015 37.0053C5.37155 37.3995 4.88644 37.9312 4.52481 38.5913C4.172 39.2513 3.99559 39.9572 3.99559 40.7273C3.99559 39.563 3.6075 38.5546 2.83131 37.7112C2.05513 36.8587 1.11136 36.4095 0 36.3545ZM56.8313 24.0069C56.0551 24.8503 55.1114 25.2995 54 25.3545C55.1114 25.4095 56.0551 25.8587 56.8313 26.7112C57.6075 27.5546 57.9956 28.563 57.9956 29.7273C57.9956 28.9572 58.172 28.2513 58.5248 27.5913C58.8864 26.9312 59.3716 26.3995 59.9802 26.0053C60.5976 25.602 61.2679 25.3911 62 25.3545C60.8798 25.2903 59.9361 24.8503 59.1599 24.0069C58.3837 23.1635 57.9956 22.1642 57.9956 21C57.9956 22.1642 57.6075 23.1635 56.8313 24.0069ZM81 25.3545C82.1114 25.2995 83.0551 24.8503 83.8313 24.0069C84.6075 23.1635 84.9956 22.1642 84.9956 21C84.9956 22.1642 85.3837 23.1635 86.1599 24.0069C86.9361 24.8503 87.8798 25.2903 89 25.3545C88.2679 25.3911 87.5976 25.602 86.9802 26.0053C86.3716 26.3995 85.8864 26.9312 85.5248 27.5913C85.172 28.2513 84.9956 28.9572 84.9956 29.7273C84.9956 28.563 84.6075 27.5546 83.8313 26.7112C83.0551 25.8587 82.1114 25.4095 81 25.3545ZM136 36.3545C137.111 36.2995 138.055 35.8503 138.831 35.0069C139.607 34.1635 139.996 33.1642 139.996 32C139.996 33.1642 140.384 34.1635 141.16 35.0069C141.936 35.8503 142.88 36.2903 144 36.3545C143.268 36.3911 142.598 36.602 141.98 37.0053C141.372 37.3995 140.886 37.9312 140.525 38.5913C140.172 39.2513 139.996 39.9572 139.996 40.7273C139.996 39.563 139.607 38.5546 138.831 37.7112C138.055 36.8587 137.111 36.4095 136 36.3545ZM101.831 49.0069C101.055 49.8503 100.111 50.2995 99 50.3545C100.111 50.4095 101.055 50.8587 101.831 51.7112C102.607 52.5546 102.996 53.563 102.996 54.7273C102.996 53.9572 103.172 53.2513 103.525 52.5913C103.886 51.9312 104.372 51.3995 104.98 51.0053C105.598 50.602 106.268 50.3911 107 50.3545C105.88 50.2903 104.936 49.8503 104.16 49.0069C103.384 48.1635 102.996 47.1642 102.996 46C102.996 47.1642 102.607 48.1635 101.831 49.0069Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="theme-switch__circle-container">
                            <div class="theme-switch__sun-moon-container">
                                <div class="theme-switch__moon">
                                    <div class="theme-switch__spot"></div>
                                    <div class="theme-switch__spot"></div>
                                    <div class="theme-switch__spot"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>Modificar Sección</h1>
        <?php
        require 'conexion.php';

        if (isset($_GET['id_estudiante'])) {
            $cedula_estudiante = htmlspecialchars($_GET['id_estudiante']);
            echo "<p>Cédula del Estudiante: $cedula_estudiante</p>";

            // Verificar la existencia del estudiante en datos_usuario
            $sql_verificar = "SELECT * FROM datos_usuario WHERE cedula = ?";
            if ($stmt_verificar = $conn->prepare($sql_verificar)) {
                $stmt_verificar->bind_param("s", $cedula_estudiante);
                $stmt_verificar->execute();
                $result_verificar = $stmt_verificar->get_result();

                if ($result_verificar->num_rows > 0) {

                    // Consulta principal para obtener las materias inscritas y sus secciones
                    $sql = "
                        SELECT
                            du.nombres, du.apellidos, m.nombre AS materia, m.id AS id_materia, m.seccion AS seccion_actual
                        FROM
                            inscripciones i
                        JOIN
                            datos_usuario du ON i.id_estudiante = du.usuario_id
                        JOIN
                            estudiantes e ON du.usuario_id = e.id_usuario
                        JOIN
                            materias m ON i.id_materia = m.id
                        WHERE
                            du.cedula = ?
                    ";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("s", $cedula_estudiante);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo "<p>Materias Inscritas:</p>";
                            echo "<table>
                                    <tr>
                                        <th>Materia</th>
                                        <th>Sección Actual</th>
                                        <th>Nueva Sección</th>
                                    </tr>";

                            while ($row = $result->fetch_assoc()) {
                                $id_materia = htmlspecialchars($row['id_materia']);
                                $materia = htmlspecialchars($row['materia']);
                                $seccion_actual = htmlspecialchars($row['seccion_actual']);

                                // Consulta para obtener todas las secciones disponibles de la materia actual
                                $sql_secciones = "
                                    SELECT seccion
                                    FROM materias
                                    WHERE nombre = ?
                                ";
                                if ($stmt_secciones = $conn->prepare($sql_secciones)) {
                                    $stmt_secciones->bind_param("s", $materia);
                                    $stmt_secciones->execute();
                                    $result_secciones = $stmt_secciones->get_result();

                                    echo "<tr>
                                            <td>$materia</td>
                                            <td>$seccion_actual</td>
                                            <td>
                                                <form action='modificar_seccion_procesar.php' method='post'>
                                                    <input type='hidden' name='id_estudiante' value='$cedula_estudiante'>
                                                    <input type='hidden' name='id_materia' value='$id_materia'>
                                                    <input type='hidden' name='materia_nombre' value='$materia'> <!-- Añadido -->
                                                    <select name='nueva_seccion'>";
                                    while ($row_seccion = $result_secciones->fetch_assoc()) {
                                        $seccion = htmlspecialchars($row_seccion['seccion']);
                                        echo "<option value='$seccion'>$seccion</option>";
                                    }
                                    echo "</select>
                                                    <button type='submit' class='btn-modificar'>Modificar</button>
                                                </form>
                                            </td>
                                        </tr>";
                                    $stmt_secciones->close();
                                } else {
                                    echo "<p>Error al preparar la consulta de secciones: " . $conn->error . "</p>";
                                }
                            }

                            echo "</table>";
                        } else {
                            echo "<p>No se encontró el estudiante en la consulta principal.</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Error al preparar la consulta principal: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p>Estudiante no encontrado en datos_usuario.</p>";
                }

                $stmt_verificar->close();
            } else {
                echo "<p>Error al preparar la consulta de verificación: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Cédula de estudiante no proporcionada.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
        const contenedor = document.getElementById('contenedor');
        const botonIzquierdo = document.getElementById('boton-izquierdo');
        const botonDerecho = document.getElementById('boton-derecho');
        botonIzquierdo.addEventListener('click', () => {
            contenedor.scrollBy({
                left: -94,
                behavior: 'smooth'
            });
        });
        botonDerecho.addEventListener('click', () => {
            contenedor.scrollBy({
                left: 94,
                behavior: 'smooth'
            });
        });

        document.getElementById('logoButton').addEventListener("click", () => {
            document.getElementById('menu').classList.toggle('toggle');
            event.stopPropagation();
        });
        document.addEventListener('click', function(event) {
            if (!container.contains(event.target) && container.classList.contains('toggle')) {
                container.classList.remove('toggle');
            }
        });
        document.addEventListener('click', function(event) {
            var div = document.getElementById('menu');
            if (!div.contains(event.target)) {
                div.classList.remove('toggle');
            }
        });
        document.getElementById('switchtema').addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
        });

        // Aplicar la preferencia guardada del usuario al cargar la p谩gina
        window.addEventListener('load', function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('switchtema').checked = true;
            }
        });

        function redirigir(url) {
            window.location.href = url;;
            // Cambia esta URL a la página de destino 
        }
        window.onload = function() {
            document.getElementById('inicio').addEventListener('click', function() {
                redirigir('pagina_administracion.php');
            });
            document.getElementById('datos').addEventListener('click', function() {
                redirigir('buscar_datos_admin.html');
            });
            document.getElementById('profesor').addEventListener('click', function() {
                redirigir('admin_profesores.php');
            });
            document.getElementById('alumno').addEventListener('click', function() {
                redirigir('admin_alumnos.php');
            });
            document.getElementById('materias').addEventListener('click', function() {
                redirigir('admin_materias.php');
            });
        }
    </script>

</body>

</html>