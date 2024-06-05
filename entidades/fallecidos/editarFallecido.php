<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$title = "Modificar Fallecido";
require_once "./head.php";
?>

<body class="sb-nav-fixed">
    <?php
    require_once "./nav.php";
    require_once "./aside.php";
    require_once "./Fallecido.php";
    $falle = new Fallecido();
    $fallecidos = $falle->generarSelectFallecidosPorUsuario($_SESSION['id_usuario']);
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Always With Me</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Panel de opciones</li>
                </ol>

                <!-- Formulario con el select de fallecidos -->
                <div class="card mb-4">
                    
                </div>
            </div>
        </main>
        <?php require_once "./footer.php"; ?>
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
