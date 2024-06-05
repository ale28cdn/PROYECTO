<?php 
session_start();
$error = [];
$nombre = $apellido = $dni = $correo = $usuario = $clave = "";
function limpiarDatos($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? limpiarDatos($_POST['nombre']) : "";
    $apellido = isset($_POST['apellido']) ? limpiarDatos($_POST['apellido']) : "";
    $dni = isset($_POST['dni']) ? limpiarDatos($_POST['dni']) : "";
    $correo = isset($_POST['correo']) ? limpiarDatos($_POST['correo']) : "";
    $clave = isset($_POST['clave']) ? limpiarDatos($_POST['clave']) : "";
    $clave2 = isset($_POST['clave2']) ? limpiarDatos($_POST['clave2']) : "";

    if (empty($nombre)) {
        $error[] = "Debes ingresar un nombre";
    }
    if (empty($apellido)) {
        $error[] = "Debes ingresar un apellido";
    }
    if (empty($dni)) {
        $error[] = "Debes ingresar un DNI";
    }
    if (empty($correo)) {
        $error[] = "Debes ingresar un correo";
    }
    if (empty($clave)) {
        $error[] = "Debes ingresar una clave";
    }
    if ($clave !== $clave2) {
        $error[] = "Las claves no coinciden";
    }

    if (empty($error)) {
        // Aquí deberías crear la instancia de la clase Usuario y llamar a crearUsuario
        require 'Usuarios.php';
        $usuario = new Usuarios();
        $usuario->nuevoUsuario($nombre, $apellido, $dni, $correo, $clave);
        echo "<div class='alert alert-success'>Usuario registrado correctamente.</div>";
        // Resetear los valores
        //REDIRIGIMOS A BLOG.
        header("Location: blog.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$title = "Blog";
require_once "../../comunes/head.php";
require "../../controles/clases/Fallecido.php";

// Manejo del formulario de alta de fallecido
$mensaje = '';
$fallecido = new Fallecido();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_fallecido'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nac = $_POST['fecha_nac'];
    $fecha_def = $_POST['fecha_def'];
    $id_cementerio = $_POST['id_cementerio'];
    $ubicacion_tumba = $_POST['ubicacion_tumba'];

    $resultado = $fallecido->darDeAltaFallecido($nombre, $apellido, $fecha_nac, $fecha_def, $id_cementerio, $ubicacion_tumba);
    if ($resultado === true) {
        $mensaje = "Fallecido dado de alta exitosamente.";
    } else {
        $mensaje = $resultado;
    }

    
}
?>

<body class="sb-nav-fixed">
    <?php
    require_once "../../comunes/nav.php";
    require_once "../../comunes/aside.php";
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Always With Me</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Alta usuario</li>
                </ol>
                <!-- Formulario para dar de alta a un fallecido -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user-plus"></i> Dar de Alta Fallecido
                    </div>
                    <div class="card-body">
                        <?php if ($mensaje): ?>
                            <div class="alert alert-info" role="alert">
                                <?= $mensaje ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_def" class="form-label">Fecha de Defunción</label>
                                <input type="date" class="form-control" id="fecha_def" name="fecha_def" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_cementerio" class="form-label">ID Cementerio</label>
                                <input type="number" class="form-control" id="id_cementerio" name="id_cementerio" required>
                            </div>
                            <div class="mb-3">
                                <label for="ubicacion_tumba" class="form-label">Ubicación de la Tumba</label>
                                <input type="text" class="form-control" id="ubicacion_tumba" name="ubicacion_tumba" required>
                            </div>
                            <button type="submit" name="submit_fallecido" class="btn btn-primary">Dar de Alta</button>
                        </form>
                    </div>
                </div>
 
            </div>
        </main>
        <?php
        require_once "../../comunes/footer.php";
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>
</html>
