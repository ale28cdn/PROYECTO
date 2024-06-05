<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$title = "Modificar Fallecido";
require_once "../../comunes/head.php";
?>

<body class="sb-nav-fixed">
    <?php
    require_once "../../comunes/nav.php";
    require_once "../../comunes/aside.php";
    require_once "../../controles/clases/Fallecido.php";
    $falle = new Fallecido();
    $fallecidos=$falle->generarSelectFallecidosPorUsuario($_SESSION['id_usuario']);

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
                    <div class="card-header">
                        Selecciona un fallecido
                    </div>
                    <div class="card-body">
                        <form action="ruta_de_tu_script_para_procesar_formulario.php" method="POST">
                            <div class="mb-3">
                                <label for="selectFallecido" class="form-label">Fallecido:</label>
                                <select class="form-select" id="selectFallecido" name="id_fallecido">
                                    <?php foreach ($fallecidos as $fallecido) : ?>
                                        <option value="<?= $fallecido['id_fallecido'] ?>">
                                            <?= $fallecido['nombre'] . ' ' . $fallecido['apellido'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Seleccionar</button>
                        </form>
                    </div>
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
