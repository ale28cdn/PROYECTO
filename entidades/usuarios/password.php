<?php
session_start();
require 'Usuarios.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: verificar_usuario.php");
    exit();
}

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id_usuario'];
    $nueva_contrasena = isset($_POST['nueva_contrasena']) ? limpiarDatos($_POST['nueva_contrasena']) : "";
    $confirmar_contrasena = isset($_POST['confirmar_contrasena']) ? limpiarDatos($_POST['confirmar_contrasena']) : "";

    if (empty($nueva_contrasena) || empty($confirmar_contrasena)) {
        $error[] = "Todos los campos son obligatorios.";
    }

    if ($nueva_contrasena !== $confirmar_contrasena) {
        $error[] = "Las nuevas contraseñas no coinciden.";
    }

    if (empty($error)) {
        $usuario = new Usuarios();
        $hashed_contrasena = ($nueva_contrasena);

        if ($usuario->cambiarContrasena($id_usuario, $hashed_contrasena)) {
            session_destroy();
            header("Location: index.php");
            exit();
        } else {
            $error[] = "Error al cambiar la contraseña. Por favor, intente nuevamente.";
        }
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
    <title>Cambiar Contraseña</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Cambiar Contraseña</h2>
    <form method="post" class="mt-4">
        <div class="form-group">
            <label for="nueva_contrasena">Nueva Contraseña</label>
            <input type="password" name="nueva_contrasena" class="form-control" id="nueva_contrasena" required>
        </div>
        <div class="form-group">
            <label for="confirmar_contrasena">Confirmar Nueva Contraseña</label>
            <input type="password" name="confirmar_contrasena" class="form-control" id="confirmar_contrasena" required>
        </div>
        <button type="submit" class="btn btn-primary">Modificar Contraseña</button>
    </form>
    <?php
    if (!empty($error)) {
        foreach ($error as $err) {
            echo "<div class='alert alert-danger mt-4'>$err</div>";
        }
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
