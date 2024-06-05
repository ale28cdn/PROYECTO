<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$title = "Blog";
require_once "./head.php";

// Incluir el archivo de conexión y la clase Awm
require "./Fallecido.php";
$fallecido = new Fallecido();

// Verificar si se ha enviado el formulario para actualizar la publicación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_publicacion'])) {
    // Obtener los datos del formulario
    $id_publicacion = $_POST['id_publicacion'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    // Actualizar la publicación
    $actualizacion = $fallecido->actualizarPublicacion($id_publicacion, $titulo, $contenido);
    

    // Redirigir a la página anterior si la actualización fue exitosa
    if ($actualizacion) {
        header("Location: blog.php");
        exit;
    }
}

// Obtener los datos de la publicación para prellenar el formulario
if (isset($_GET['id'])) {
    $id_publicacion = $_GET['id'];

    $publicacion = $fallecido->obtenerPublicacion($id_publicacion);
    if (!$publicacion) {
        // Redirigir a la página del blog si no se encuentra la publicación
        header("Location: blog.php");
        exit;
    }
} else {
    // Redirigir a la página del blog si no se prporciona un ID de publicación válido
    header("Location: blog.php");
    exit;
}
?>

<body class="sb-nav-fixed">
    <?php
    require_once "./nav.php";
    require_once "./aside.php";
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Always With Me</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Panel de opciones</li>
                </ol>

                <!-- Formulario para actualizar la publicación -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit"></i> 
                        Actualizar Publicación
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="id_publicacion" value="<?php echo htmlspecialchars($publicacion['id_publicacion']); ?>">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($publicacion['titulo']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="contenido" class="form-label">Contenido</label>
                                <textarea class="form-control" id="contenido" name="contenido" rows="4" required><?php echo htmlspecialchars($publicacion['contenido']); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="blog.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php
        require_once "./footer.php";
        ?>
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