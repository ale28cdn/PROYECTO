<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$title = "Mi Cuenta";
require_once "../../comunes/head.php";
require "../../controles/clases/Usuarios.php";
$usuarios = new Usuarios();
?>

<body class="sb-nav-fixed">
    <?php
    require_once "../../comunes/nav.php";
    require_once "../../comunes/aside.php";
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Mi cuenta</h1>
                <?php
                if (isset($_SESSION['id_usuario'])) {
                    // Obtener el ID de usuario de la sesión
                    $id_usuario = $_SESSION['id_usuario'];
                    
                    // Generar el formulario con los datos del usuario
                    echo $usuarios->mostrarDatosUsuario($id_usuario);
                } else {
                    // Si no hay sesión de usuario, mostrar mensaje de error
                    echo "<div class='alert alert-danger' role='alert'>No se ha iniciado sesión.</div>";
                }
                ?>
            </div>
        </main>
        <?php
        require_once "../../comunes/footer.php";
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous
