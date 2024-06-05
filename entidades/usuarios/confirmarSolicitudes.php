<?php
session_start();
$title = "Confirmar Solicitudes";
require_once "../../comunes/head.php";
require_once "../../controles/clases/Fallecido.php";
$fallecido= new fallecido();
if(isset($_POST['confirmar_acceso'])){

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>
    <!-- Aquí se incluirían otros elementos del head -->
</head>
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
                    <li class="breadcrumb-item active">Panel de opciones</li>
                </ol>
                <?php
                $datosFallecido= $fallecido->obtenerIdFallecidosPorUsuario($_SESSION['id_usuario']);
                if(!empty($datosFallecido)){
                    $fallecido->imprimirDatosFallecido($datosFallecido);
                }else{
                    ?>
                    <div class="alert alert-info" role="alert">
                        No hay solicitudes de acceso pendientes para confirmar.
                    </div>
                    <?php
                }
                
                ?>
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
