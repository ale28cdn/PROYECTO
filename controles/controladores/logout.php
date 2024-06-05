<!DOCTYPE html>
<html lang="es">

<head>

  <link rel="stylesheet" href="estilos.css">
</head>

<body>


  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title titulo">Cerrando sesión en AWM</h5>
        <p class="card-text">Te esperamos pronto...</p>
      </div>
    </div>
  </div>

  <?php
  session_start();
  session_unset();
  session_destroy();
  header('Refresh: 2; URL = ../../index.php'); ?>
</body>

</html>