<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$title = "Listar Usuario";
require_once "../../comunes/head.php";
?>

<body class="sb-nav-fixed">
    <?php
    require_once "../../comunes/nav.php";
    require_once "../../comunes/aside.php";
    require_once "../../controles/clases/Fallecido.php";
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Always With Me</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Panel de opciones</li>
                </ol>
                <div class="card mb-4">
                    <?php
                        $fallecido = new Fallecido();
                        $nombresUsuarios = $fallecido->obtenerNombresUsuariosPorFallecido($_SESSION['id_fallecido']);

                        // Verifica si hay nombres de usuarios para mostrar
                        if (!empty($nombresUsuarios)) {
                            // Recorre el array de nombres de usuarios y muestra cada nombre por pantalla
                            foreach ($nombresUsuarios as $nombreUsuario) {
                                echo $nombreUsuario . "<br>";
                            }
                        } else {
                            // Si no hay nombres de usuarios, muestra un mensaje indicando que no hay usuarios asociados al fallecido
                            echo "No hay usuarios asociados a este fallecido.";
                        }                    ?>

                </div>
            </div>
        </main>
        <?php require_once "../../comunes/footer.php"; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
</body>
</html>
