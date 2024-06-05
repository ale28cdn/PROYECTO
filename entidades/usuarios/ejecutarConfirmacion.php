<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_fallecido']) && isset($_POST['id_usuario'])) {
   
    require_once "../../controles/clases/Fallecido.php";
    $fallecido = new Fallecido();
    $fallecido->confirmarAcceso($_POST['id_usuario'],$_POST['id_fallecido']);

    $archivoCSV = '../../controles/clases/registros/solicitudesAcceso.csv'; // Ruta a tu archivo CSV
    $id_usuario = $_POST['id_usuario'];
    $id_fallecido = $_POST['id_fallecido'];
    
    $fallecido->eliminarCoincidenciaCSV($archivoCSV, $id_usuario, $id_fallecido);

    header("Location: confirmarSolicitudes.php");
    exit();
}
?>