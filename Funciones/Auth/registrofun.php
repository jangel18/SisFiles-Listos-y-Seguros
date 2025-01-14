<?php

include('../../Config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Respuesta JSON inicial
    $response = [];

    // Verificar si el usuario ya existe
    $sql_check = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $usuario);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'El usuario ya está registrado.';
    } else {
        // Hashear la contraseña antes de guardarla
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $sql_insert = "INSERT INTO usuarios (usuario, password) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $usuario, $hashed_password);

        if ($stmt_insert->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Usuario registrado exitosamente.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al registrar el usuario.';
        }
    }

    // Cerrar las conexiones
    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();

    // Enviar respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
