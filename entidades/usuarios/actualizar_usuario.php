<?php
session_start();
require "../../controles/clases/Usuarios.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];

    $usuarios = new Usuarios();
    $resultado = $usuarios->actualizarUsuario($id_usuario, $nombre, $apellido, $dni, $correo);
        // Actualizar la sesión con los nuevos datos
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido'] = $apellido;
    $_SESSION['dni'] = $dni;
    $_SESSION['correo'] = $correo;

    if (!empty($nueva_contrasena)) {
        $resultado_contrasena = $usuarios->cambiarContrasena($id_usuario, $nueva_contrasena);
        if ($resultado_contrasena) {
           header("Location: ../../../../index.php");
           exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al actualizar la contraseña.</div>";
        }
    }

    echo $resultado;
}
?>
