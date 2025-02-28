<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
   <!-- <link rel="stylesheet" href="../styles/styles.css"> No se usa gracias a bootstrap -->
</head>

<body>
    <?php include('../header/header.php')?>
    
    
    <div class="container mt-5 w-50">
        <h1 class="text-center">Registro</h1>
        <form id="registroForm" class="p-4 border rounded bg-light">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>
        <div id="responseMessage" class="mt-3"></div>
        <div class="text-center mt-2">
            <a href="../index.php">¿Ya está registrado? Inicie sesión aquí</a>
        </div>
    </div>
    
    <script>
        function redirigirPagina(url) {
            setTimeout(function() {
                window.location.href = url;
            }, 1500);
        }
        
        $(document).ready(function() {
            $('#registroForm').on('submit', function(event) {
                event.preventDefault();
                
                var formData = {
                    usuario: $('#usuario').val(),
                    password: $('#password').val()
                };
                
                $.ajax({
                    url: '../../Funciones/Auth/registrofun.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#registroForm')[0].reset();
                            redirigirPagina("../index.php");
                        } else {
                            $('#responseMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", status, error);
                        $('#responseMessage').html('<div class="alert alert-danger">Error al procesar la solicitud.</div>');
                    }
                });
            });
        });
    </script>
</body>

</html>
