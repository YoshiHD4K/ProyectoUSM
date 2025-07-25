<?php 
    session_start(); 
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="icon" href="css/icono.png" type="image/png"> -->
    <link rel="icon" href="css/logounihubblanco.png" type="image/png">
    <link rel="stylesheet" href="css\style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">

    <title>Inicio de Sesión - UniHub</title>
</head>

<body class="body1">
    <div class="container">
        <div class="container-form">
            <form class="sign-in" id="sign-in" action="Ingreso.php" method="post">
                <div class="logos">
                    <!-- <img src="https://usm.edu.ve/wp-content/uploads/2020/08/usmlgoretina-1.png" class="logo-uni1">
                    <div class="barravertical"></div> -->
                    <img src="css/logounihubazul.png" class="logo-uni1">
                </div>
                <h2>Iniciar Sesión</h2>
                <span>Usa tu usuario y contraseña</span>
                <div class="container-input">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="usuario" placeholder="Usuario" maxlength="50" required>
                </div>
                <div class="container-input">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="Password1" placeholder="Contraseña" maxlength="50" id="pass" required>
                    <i class='bx bx-show'></i>
                </div>
                <span class="errorcontraseña"></span>
                <a href="forgotPassword.php" class="olvido">¿Olvidaste tu contraseña?</a>
                <button type="submit" class="button">Iniciar Sesión</button>

            </form>
        </div>
        <div class="container-form">
            <form class="sign-up" id="sign-up" action="Registro.php" method="post">
                <div class="logos">
                    <!-- <img src="https://usm.edu.ve/wp-content/uploads/2020/08/usmlgoretina-1.png" class="logo-uni1">
                    <div class="barravertical"></div> -->
                    <img src="css/logounihubazul.png" class="logo-uni1">
                </div>
                <h2>Registrarse</h2>
                <span>Ingrese su nombre, correo y contraseña para Registrarse</span>
                <div class="container-input">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="nombre" placeholder="Nombre de Usuario" maxlength="50" required>
                </div>
                <div class="container-input">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="mail" placeholder="Email" maxlength="50" required>
                </div>
                <div class="container-input" id="container-pass">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="Password"  placeholder="Contraseña" id="passs" maxlength="50" required>
                    <div id="tooltip" class="tooltip">La contraseña debe contener al menos una letra minúscula, mayúscula, un numero y un carácter especial.</div>
                    <i class='bx bx-show' id="icons"></i>
                </div>
                <span id="spancontraseña"></span>
                <button type="submit" id="boton" class="button">Registrarse</button>
            </form>
        </div>

        <div class="container-welcome">
            <div class="welcome-sign-up welcome">
                <h3>¡Bienvenido!</h3>
                <p>Ingrese los datos para continuar</p>
                <button class="button2" id="btn-sign-up">Registrarse</button>
            </div>
            <div class="welcome-sign-in welcome">
                <h3>¡Hola!</h3>
                <p>Registrese con sus datos para continuar</p>
                <button class="button2" id="btn-sign-in">Iniciar Sesión</button>
            </div>
        </div>
    </div>
    <div class="contenedorentrante1">
        <img src="css\logo.png">
    </div>

    <script src="js\script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['mensaje'])): ?>
                alert(<?php echo json_encode($_SESSION['mensaje']); ?>);
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>