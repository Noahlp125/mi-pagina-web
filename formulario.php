<?php
// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para limpiar datos de entrada
function limpiarDato($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Variables para mensajes
$mensaje_error = '';
$mensaje_exito = '';

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y limpiar datos del formulario
    $nombre = isset($_POST['name']) ? limpiarDato($_POST['name']) : '';
    $email = isset($_POST['email']) ? limpiarDato($_POST['email']) : '';
    $mensaje = isset($_POST['message']) ? limpiarDato($_POST['message']) : '';

    // Validar datos
    if (empty($nombre)) {
        $mensaje_error = "El nombre es requerido";
    } elseif (empty($email)) {
        $mensaje_error = "El email es requerido";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje_error = "Email no válido";
    } elseif (empty($mensaje)) {
        $mensaje_error = "El mensaje es requerido";
    } else {
        // Configurar el email
        $para = "hola123@gmail.com"; // ¡Cambia esto por tu email real!
        $asunto = "Nuevo mensaje de contacto de VS Marketing";
        
        // Crear el cuerpo del email
        $cuerpo_email = "Has recibido un nuevo mensaje desde el formulario de contacto.\n\n";
        $cuerpo_email .= "Nombre: $nombre\n";
        $cuerpo_email .= "Email: $email\n";
        $cuerpo_email .= "Mensaje:\n$mensaje\n";

        // Cabeceras del email
        $cabeceras = "From: $email\r\n";
        $cabeceras .= "Reply-To: $email\r\n";
        $cabeceras .= "X-Mailer: PHP/" . phpversion();

        // Intentar enviar el email
        if (mail($para, $asunto, $cuerpo_email, $cabeceras)) {
            $mensaje_exito = "¡Mensaje enviado con éxito!";
        } else {
            $mensaje_error = "Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje Enviado - VS Marketing</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        /* Aquí va todo el CSS que teníamos antes en el HTML */
        /* ... (mantener los mismos estilos que en la versión anterior) ... */
        
        .error-message {
            color: #e74c3c;
            background-color: #ffd7d7;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .success-message {
            color: #27ae60;
            background-color: #d4ffda;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="principal.html" class="logo">VS Marketing</a>
            <div class="nav-links">
                <a href="principal.html">Inicio</a>
                <a href="principal.html#servicios">Servicios</a>
                <a href="principal.html#contacto">Contacto</a>
            </div>
        </nav>
    </header>

    <form action="procesar-formulario.html" method="POST">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>
    
    <label for="email">Correo electrónico:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="mensaje">Mensaje:</label><br>
    <textarea id="mensaje" name="mensaje" required></textarea><br><br>
    
    <input type="submit" value="Enviar">
</form>

    <div class="confirmation-container">
        <div class="confirmation-box">
            <?php if (!empty($mensaje_error)): ?>
                <i class="fas fa-exclamation-circle confirmation-icon" style="color: #e74c3c;"></i>
                <h1 class="confirmation-title">Error en el Envío</h1>
                <div class="error-message"><?php echo $mensaje_error; ?></div>
                <a href="javascript:history.back()" class="back-button">Volver al Formulario</a>
            <?php elseif (!empty($mensaje_exito)): ?>
                <i class="fas fa-check-circle confirmation-icon" style="color: #2ecc71;"></i>
                <h1 class="confirmation-title">¡Mensaje Enviado!</h1>
                <div class="success-message"><?php echo $mensaje_exito; ?></div>
                <div class="details-box">
                    <h3>Datos enviados:</h3>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Mensaje:</strong> <?php echo nl2br(htmlspecialchars($mensaje)); ?></p>
                </div>
                <a href="principal.html" class="back-button">Volver al Inicio</a>
            <?php else: ?>
                <i class="fas fa-exclamation-circle confirmation-icon" style="color: #f39c12;"></i>
                <h1 class="confirmation-title">Acceso Directo No Permitido</h1>
                <p class="confirmation-text">Por favor, utiliza el formulario de contacto para enviar mensajes.</p>
                <a href="principal.html#contacto" class="back-button">Ir al Formulario</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>