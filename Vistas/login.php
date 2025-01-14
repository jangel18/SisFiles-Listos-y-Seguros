<?php



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!--  a -->
    <form action="../Funciones/Auth/loginfun.php" method="POST">
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="usuario" class="form-control" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Iniciar sesion</button>

    </form>
    <a href="registro.html">¿Usted no esta registrado?,Hagalo aqui</a>
</body>
</html>