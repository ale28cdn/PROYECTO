<?php
session_start();
$title = "Blog";
require_once "../../comunes/head.php";
require_once "../../controles/controladores/funciones.php";
require '../../controles/clases/Fallecido.php';
$fallecido = new Fallecido();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publicar'])) {
    $titulo = isset($_POST['titulo']) ? limpiar($_POST['titulo']) : " ";
    $contenido = isset($_POST['contenido']) ? limpiar($_POST['contenido']) : " ";
    $archivo = isset($_FILES['archivo']) ? $_FILES['archivo'] : null;

    if (empty($titulo) && empty($contenido)) {
        $error = "Debes ingresar ambos campos";
    }

    if (!isset($error)) {
        $fallecido->crearPublicacion($_SESSION['id_usuario'], $_SESSION['id_fallecido'], $titulo, $contenido);
        $ultimoID = $fallecido->obtenerUltimoIdInsercion();

        if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
            $nombre_archivo = $archivo['name'];
            $tipo_archivo = $archivo['type'];
            $ruta_archivo_temporal = $archivo['tmp_name'];
            $tamaño_archivo = $archivo['size'];

            $carpeta_usuario = "multimedia/{$_SESSION['id_fallecido']}/";
            
            if (!file_exists($carpeta_usuario)) {
                mkdir($carpeta_usuario, 0775, true);
            }
            $extension_archivo = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombre_archivo_final = "{$ultimoID}.{$extension_archivo}";
            $ruta_archivo_final = $carpeta_usuario . $nombre_archivo_final;
            
            if (move_uploaded_file($ruta_archivo_temporal, $ruta_archivo_final)) {
                $ruta_bd = $ruta_archivo_final;
                if ($tipo_archivo === 'image/png' || $tipo_archivo === 'image/jpeg' || $tipo_archivo === 'image/JPG') {
                    $fallecido->actualizar_bd_con_ruta_imagen($ultimoID, $ruta_bd);
                } elseif ($tipo_archivo === 'video/mp4') {
                    $fallecido->actualizar_bd_con_ruta_video($ultimoID, $ruta_bd);
                } else {
                    error_log("Tipo de archivo no soportado: " . $tipo_archivo);
                }
                header("Location: blog.php");
                exit;
            } else {
                error_log("Error al mover el archivo: " . $nombre_archivo);
            }
            
        }
    }
}
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
                    <li class="breadcrumb-item active">Panel de opciones</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                       <?php
                       if (isset($error)) {
                        echo $error;
                       }
                       ?>
                        <i class="fas fa-plus"></i> Nueva Publicación
                    </div>
                    <div class="card-body">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido</label>
                            <textarea class="form-control" id="contenido" name="contenido" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Adjuntar archivo</label>
                            <input type="file" class="form-control" id="archivo" name="archivo">
                            <small class="form-text text-muted">Sube una imagen o video relacionado con la publicación.</small>
                        </div>
                        <input type="submit" name="publicar" class="btn btn-primary" value="Publicar">
                    </form>
                    </div>
                </div>

                <?php
                $publicaciones = $fallecido->contenidoBlog($_SESSION['id_fallecido']);
                
                
                ?>
                
                <div class="col-md-8 blog-main">
                   
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
</body>
</html>
