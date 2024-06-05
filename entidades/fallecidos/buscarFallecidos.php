<?php
session_start();
$title = "Galeria";
require_once "../../comunes/head.php";
require_once "../../controles/controladores/funciones.php";
require_once "../../controles/clases/Fallecido.php";

$fallecido = new Fallecido();
if(isset($_POST['solicitar_acceso'])){
    $fallecido->registrarSolicitudAcceso($_POST["id_fallecido"], $_SESSION['id_usuario']);
    header("Location: blog.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" class="js-site-favicon" type="image/png" href="./assets/img/favIcon.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AWM | Login</title>
    <link href="./styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                    $fallecido->buscarFallecido($_GET['busqueda']);
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
