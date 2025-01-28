<?php
include('../../Config/db.php');
include('../Archivos/Crear_carpeta_user.php');

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inicializar respuesta
    $response = [];

    // Verificar conexión a la base de datos
    if (!$conn) {
        $response['status'] = 'error';
        $response['message'] = 'Error de conexión a la base de datos.';
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    // Capturar datos del formulario
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Todos los campos son obligatorios.';
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

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
        // Hashear la contraseña
        $hashed_password = $password;

        // Insertar nuevo usuario
        $sql_insert = "INSERT INTO usuarios (usuario, password) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $usuario, $hashed_password);
        crear_carpeta_user($usuario);
        
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
    if (isset($stmt_insert)) {
        $stmt_insert->close();
    }
    $conn->close();

    // Enviar respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Respuesta para solicitudes no POST
$response = [
    'status' => 'error',
    'message' => 'Método no permitido.'
];
header('Content-Type: application/json');
echo json_encode($response);
exit();
