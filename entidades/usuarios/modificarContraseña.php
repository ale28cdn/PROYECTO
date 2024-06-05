<?php
session_start();
require 'Usuarios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = isset($_POST['dni']) ? limpiarDatos($_POST['dni']) : "";
    $correo = isset($_POST['correo']) ? limpiarDatos($_POST['correo']) : "";

    $usuario = new Usuarios();
    $usuarioEncontrado = $usuario->verificarDniYCorreo($dni, $correo);

    if ($usuarioEncontrado) {
        $_SESSION['id_usuario'] = $usuarioEncontrado['id_usuario'];
        header("Location: password.php");
        exit();
    } else {
        $error = "Usuario no encontrado. Verifique sus datos.";
    }
}

function limpiarDatos($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Verificar Usuario</h2>
    <form method="post" class="mt-4">
        <div class="form-group">
            <label for="dni">DNI</label>
            <input type="text" name="dni" class="form-control" id="dni" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" name="correo" class="form-control" id="correo" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar Usuario</button>
        <a href="./index.php" class="btn btn-primary">Cancelar</a>
    </form>
    <?php if (isset($error)) { echo "<div class='alert alert-danger mt-4'>$error</div>"; } ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
