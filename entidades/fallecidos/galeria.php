<?php
session_start();
$title = "Galeria";
require_once "../../comunes/head.php";
require_once "../../controles/controladores/funciones.php";
require_once "../../controles/clases/Fallecido.php";

$fallecido = new Fallecido();
$publicaciones = $fallecido->galeria($_SESSION['id_fallecido']);

?>
<!DOCTYPE html>
<html lang="en">

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
                    <li class="breadcrumb-item active">Galeria Imagenes</li>
                </ol><?php
                if($publicaciones){
                ?>
                    <!-- Galería de publicaciones con imágenes -->
                <div class="row">
                    <?php foreach ($publicaciones as $publicacion) : ?>
                        <?php if (!empty($publicacion['foto'])) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="<?= htmlspecialchars($publicacion['foto']) ?>" class="card-img-top" alt="Imagen de la publicación">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($publicacion['titulo']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($publicacion['contenido']) ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted">Publicado por: <?= htmlspecialchars($publicacion['nombre_usuario']) ?> <?= htmlspecialchars($publicacion['apellido_usuario']) ?> el <?= htmlspecialchars($publicacion['fecha']) ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
                }else{
                    echo "<div class='alert alert-warning' role='alert'>No se encontraron publicaciones para este fallecido</div>";
                    echo "<img src='../../assets/img/sinResultados.jpeg' alt='sinDatos' style='max-width: 20rem; height: 20rem;'/>";
                }?>
                
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
