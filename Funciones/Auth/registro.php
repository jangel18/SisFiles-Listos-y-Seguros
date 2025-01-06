<?php

include('../../Config\db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql_check_usuario = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt_check_usuario = $conn->prepare($sql_check_usuario);
    $stmt_check_usuario->bind_param("s", $usuario);
    $stmt_check_usuario->execute();
    $result = $stmt_check_usuario->get_result();

    if ($result->num_rows > 0) {
        // Si el correo ya existe, mostrar un mensaje de error
        echo "El usario ya está registrado, vuelve a registrarte con un usario distnito.";
    } else {


        // Preparar la consulta de inserción
        $sql_insert = "INSERT INTO usuarios (usuario, password) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $usuario, $password);

        if ($stmt_insert->execute()) {

            // Redirigir a la página de login (opcional)
            header("Location: ../../Vistas/Compartidos/Auth/Login.html");
        } else {
            echo "Error al registrar el usuario: " . $stmt_insert->error;
        }

        // Cerrar la declaración
        $stmt_insert->close();
    }

    // Cerrar la conexión
    $stmt_check_email->close();
    $conn->close();
}

?>