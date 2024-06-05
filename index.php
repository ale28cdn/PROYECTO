<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "comunes/url-base.php";

$mensaje = '';
require "controles/controladores/funciones.php";
require "controles/clases/Acceso.php";
$acc = new Acceso();

$user = isset($_POST['user']) ? limpiar($_POST['user']) : "";
$pass = isset($_POST['pass']) ? limpiar($_POST['pass']) : "";

if (isset($_POST['submit']) && !empty($user) && !empty($pass)) {
    // Datos de conexión a la base de datos
    $dbname = 'dbs12963202';
    $username = 'dbu5578123';
    $password = 'Nd8jhmRJvc';
    $host = 'db5015905427.hosting-data.io';

    try {
        // Conexión a la base de datos utilizando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Manejo de errores en caso de fallo en la conexión o consulta
        echo "Error en la conexión a la base de datos: " . $e->getMessage();
        exit();
    }
    
    // Preparar y ejecutar la consulta SQL
    $query = "SELECT id_usuario, nombre, apellido, dni, correo, clave FROM usuario WHERE lower(correo) = lower(:correo)";
    $queryPreparada = $pdo->prepare($query);
    $parametros = array(":correo" => $user);
    $queryPreparada->execute($parametros);
    $queryPreparada->setFetchMode(PDO::FETCH_ASSOC);

    $fila = $queryPreparada->fetch();

    if ($fila) {

        if ($pass === $fila['clave']) {  // Comparar directamente las contraseñas
            session_start();
            $arrayString = implode(',', $fila);

            if($arrayString){
                header("Location: entidades/fallecidos/seleccionarFallecido.php?id=$arrayString");
                exit();       
            }
        } else {
            $mensaje = 'Contraseña incorrecta';
        }
    } else {
        $mensaje = 'Usuario no encontrado';
    }
} else {
    $mensaje = 'Debes ingresar el usuario y la clave';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" class="js-site-favicon" type="image/png" href="./assets/img/favIcon.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AWM | Login</title>
    <link href="css/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url("./assets/img/fond.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 80%;
        }

        #layoutAuthentication {
            display: flex;
            min-height: 100vh;
        }

        #layoutAuthentication_content {
            flex: 1;
        }

        #layoutAuthentication_footer {
            width: 100%;
        }

        .custom-logo {
            height: 50px;
            margin-right: 10px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-header div {
            text-align: center;
        }

        .card-header span {
            display: block;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="bg-primary">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Always With Me</a>
</nav>

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <img src="./assets/img/favIcon.jpg" alt="Logo" class="custom-logo">
                                <div>
                                    <span>Always</span>
                                    <span>With Me</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="form-floating mb-3">
                                        <input name="user" class="form-control <?= !empty($mensaje) ? 'is-invalid' : '' ?>" type="text" placeholder="Usuario" />
                                        <label for="inputUsuario">Usuario</label>
                                        <?php if (!empty($mensaje)): ?>
                                            <div class="invalid-feedback">
                                                <?= $mensaje ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="pass" type="password" placeholder="Contraseña" />
                                        <label for="inputContraseña">Contraseña</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="modificarContrasenia.php">¿Olvidaste tu contraseña?</a>
                                        <input class="btn btn-primary" type="submit" value="Acceder" name="submit">
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="registrarUsuario.php">¿Necesitas una cuenta? ¡Regístrate!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require "./comunes/footer.php"; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="./js/scripts.js"></script>
</body>
</html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "comunes/url-base.php";

$mensaje = '';
require "controles/controladores/funciones.php";
require "controles/clases/Acceso.php";
$acc = new Acceso();

$user = isset($_POST['user']) ? limpiar($_POST['user']) : "";
$pass = isset($_POST['pass']) ? limpiar($_POST['pass']) : "";

if (isset($_POST['submit']) && !empty($user) && !empty($pass)) {
    // Datos de conexión a la base de datos
    $dbname = 'dbs12963202';
    $username = 'dbu5578123';
    $password = 'Nd8jhmRJvc';
    $host = 'db5015905427.hosting-data.io';

    try {
        // Conexión a la base de datos utilizando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Manejo de errores en caso de fallo en la conexión o consulta
        echo "Error en la conexión a la base de datos: " . $e->getMessage();
        exit();
    }
    
    // Preparar y ejecutar la consulta SQL
    $query = "SELECT id_usuario, nombre, apellido, dni, correo, clave FROM usuario WHERE lower(correo) = lower(:correo)";
    $queryPreparada = $pdo->prepare($query);
    $parametros = array(":correo" => $user);
    $queryPreparada->execute($parametros);
    $queryPreparada->setFetchMode(PDO::FETCH_ASSOC);

    $fila = $queryPreparada->fetch();

    if ($fila) {
        // Para depuración: mostrar datos de la fila
        echo '<pre>' . print_r($fila, true) . '</pre>';

        if ($pass === $fila['clave']) {  // Comparar directamente las contraseñas
            $_SESSION["id_usuario"] = $fila['id_usuario'];
            $_SESSION["nombre"] = $fila['nombre'];
            $_SESSION["apellido"] = $fila['apellido'];
            $_SESSION["dni"] = $fila['dni'];
            $_SESSION["correo"] = $fila['correo'];
            $_SESSION["valid"] = true;

            header("Location: $url_base_http/entidades/fallecidos/seleccionarFallecido.php");
            exit();
        } else {
            $mensaje = 'Contraseña incorrecta';
        }
    } else {
        $mensaje = 'Usuario no encontrado';
    }
} else {
    $mensaje = 'Debes ingresar el usuario y la clave';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" class="js-site-favicon" type="image/png" href="./assets/img/favIcon.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AWM | Login</title>
    <link href="css/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url("./assets/img/fond.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 80%;
        }

        #layoutAuthentication {
            display: flex;
            min-height: 100vh;
        }

        #layoutAuthentication_content {
            flex: 1;
        }

        #layoutAuthentication_footer {
            width: 100%;
        }

        .custom-logo {
            height: 50px;
            margin-right: 10px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-header div {
            text-align: center;
        }

        .card-header span {
            display: block;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="bg-primary">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Always With Me</a>
</nav>

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <img src="./assets/img/favIcon.jpg" alt="Logo" class="custom-logo">
                                <div>
                                    <span>Always</span>
                                    <span>With Me</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="form-floating mb-3">
                                        <input name="user" class="form-control <?= !empty($mensaje) ? 'is-invalid' : '' ?>" type="text" placeholder="Usuario" />
                                        <label for="inputUsuario">Usuario</label>
                                        <?php if (!empty($mensaje)): ?>
                                            <div class="invalid-feedback">
                                                <?= $mensaje ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="pass" type="password" placeholder="Contraseña" />
                                        <label for="inputContraseña">Contraseña</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="modificarContrasenia.php">¿Olvidaste tu contraseña?</a>
                                        <input class="btn btn-primary" type="submit" value="Acceder" name="submit">
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="registrarUsuario.php">¿Necesitas una cuenta? ¡Regístrate!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require "./comunes/footer.php"; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="./js/scripts.js"></script>
</body>
</html>
