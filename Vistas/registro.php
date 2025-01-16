<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!--  a -->
    <form action="../Funciones/Auth/registrofun.php" method="POST" id="registroForm">
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="usuario" class="form-control" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>

    </form>
    <div id="responseMessage"></div>
    <script>
          function redirigirPagina(url) {
            setTimeout(function() {
            window.location.href = url;
            }, 1500); // 3000 milisegundos = 3 segundos
            }
          $(document).ready(function() {
            $('#registroForm').on('submit', function(event) {
                event.preventDefault(); // Evitar recarga de página

                // Capturar los datos del formulario
                var formData = {
                    usuario: $('#usuario').val(),
                    password: $('#password').val()
                };

                // Enviar los datos al servidor
                $.ajax({
                url: '../Funciones/Auth/registrofun.php', // Ajusta la ruta si es necesario
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#responseMessage').html('<div style="color: green;">' + response.message + '</div>');
                        $('#registroForm')[0].reset(); // Limpiar el formulario
                        redirigirPagina("login.php");
                    } else {
                        $('#responseMessage').html('<div style="color: red;">' + response.message + '</div>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", status, error);
                    $('#responseMessage').html('<div style="color: red;">Error al procesar la solicitud.</div>');
                }
            });
        });
    });
    </script>
    <a href="login.php">¿Usted ya esta registrado?,Inicie sesion aqui</a>
</body>
</html>