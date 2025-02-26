<?php
include('../../Config/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['usuario'];
            $_SESSION['estado'] = 'Autenticado';

            echo json_encode([
                "success" => true,
                "redirect" => "../../Vistas/index.php"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "La contraseña es incorrecta."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "El usuario no está registrado."
        ]);
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
    exit();
}
