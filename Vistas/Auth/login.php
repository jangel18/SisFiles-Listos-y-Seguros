<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--<link rel="stylesheet" href="styles/styles.css"> No se usa gracias a bootstrap   -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include('header/header.php') ?>
    
    <div  class="container mt-5 w-50">
        <h1 class="text-center">Inicio de sesión</h1>
        <form id="loginForm" class="p-4 border rounded bg-light">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>

        <div id="alerta" class="mt-3"></div>
        <div class="text-center mt-2"><a href="Auth/registro.php">¿Usted no está registrado? Hágalo aquí</a></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Evita que el formulario se envíe por defecto

                $.ajax({
                    url: '../../Funciones/Auth/loginfun.php', // URL del archivo PHP
                    type: 'POST',
                    data: $(this).serialize(), // Serializa los datos del formulario
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect; // Redirigir si es exitoso
                        } else {
                            $('#alerta').html(`
                                <div class="alert alert-danger" role="alert" style="color: red;">
                                    ${response.message}
                                </div>
                            `);
                        }
                    },
                    error: function() {
                        $('#alerta').html(`
                            <div class="alert alert-danger" role="alert">
                                Ocurrió un error en el servidor. Inténtelo de nuevo más tarde.
                            </div>
                        `);
                    }
                });
            });
        });
    </script>
</body>

</html>