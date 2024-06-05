<?php
// Asegúrate de que no haya ningún espacio en blanco ni líneas en blanco antes de esta línea.
session_start();
if (isset($_GET["id_fallecido"])) {
    $id_fallecido = $_GET['id_fallecido'];
    $_SESSION['id_fallecido'] = $id_fallecido;
    header("Location: ./blog.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id'])) {
    $arrayString = $_GET['id'];
    $array = explode(',', $arrayString);
    $_SESSION["id_usuario"] = $array[0];
    $_SESSION["nombre"] = $array[1];
    $_SESSION["apellido"] = $array[2];
    $_SESSION["dni"] = $array[3];
    $_SESSION["correo"] = $array[4];
    $_SESSION["valid"] = true;
}

$title = "Seleccion de Fallecidos";
require "../../comunes/head.php";
require "../../controles/clases/Fallecido.php";


// Lógica para obtener los fallecidos asociados al usuario actual
$fallecido = new Fallecido();
$fallecidos = $fallecido->generarSelectFallecidosPorUsuario($_SESSION['id_usuario']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tu código del head aquí -->
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
                    <li class="breadcrumb-item active">Selección de fallecido</li>
                </ol>

                <!-- Formulario para seleccionar un fallecido -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                    <div class="mb-3">
                        <label for="selectFallecido" class="form-label">Selecciona un fallecido:</label>
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
