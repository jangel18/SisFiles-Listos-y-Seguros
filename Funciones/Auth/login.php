<?php

include('../../Config\db.php');
// Iniciar sesión
session_start();

// Comprobar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos por el correo electrónico
    $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña (usa password_hash en producción)
        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_usuario'] = $user['usuario'];
            

            // Redirigir a la página principal
            header("Location: ../../Vistas/Compartidos/PaginaVentas/Inicio.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">La contraseña es incorrecta.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">El usuario no está registrado.</div>';
    }

    $stmt->close();
    $conn->close();
}