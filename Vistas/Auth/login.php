<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/styles.css">
    
   <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
</head>
<body>
    <div><img src="../../Public/Storage\124837.png" alt="" width="100" height="100"><h1>SisFiles</h1>
    </div>
    <div>
    <h1>Inicio de sesion</h1>
    <form id="loginForm">
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
    </form>

    <div id="alerta" class="mt-3"></div>
    <div class="link"><a href="Auth/registro.php">¿Usted no está registrado? Hágalo aquí</a></div>
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
