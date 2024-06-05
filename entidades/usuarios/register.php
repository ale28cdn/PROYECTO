<?php
session_start();
require '../../controles/clases/Usuarios.php';
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once "./styles.css";?>
    <body class="bg-primary">
    <?php
$mensaje = '';
require "../../controles/controladores/funciones.php";
require "../../controles/clases/Acceso.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
$acc = new Usuarios();

$nombre = isset($_POST['nombre_fa']) ? limpiar($_POST['nombre_fa']) : " ";
$apellido = isset($_POST['apellido_fa']) ? limpiar($_POST['apellido_fa']) : " ";
$correo = isset($_POST['correo']) ? limpiar($_POST['correo']) : " ";
$clave = isset($_POST['clave']) ? limpiar($_POST['clave']) : " ";
$claveDos = isset($_POST['claveDos']) ? limpiar($_POST['claveDos']) : " ";

// Comprueba que si estan rellenados todos los datos
if (isset($_POST['submit']) && !empty($nombre) && !empty($apellido)&& !empty($correo) && (!empty($clave) === !empty($claveDos))) {
    $acc->nuevoUsuario($nombre, $apellido, $correo, $clave, $claveDos);
    if (isset($_SESSION['valid'])) {
        header("Location: ./inicio.php");
        exit();
    }
} else {
    $mensaje = 'Debes rellenar todos los campos';
}}
?>

        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create tú cuenta</h3></div>
                                    <div class="card-body">
                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="formulario__register">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" />
                                                        <label name="nombre_fa" for="inputFirstName">First name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" />
                                                        <label name="apellido_fa" for="inputLastName">Last name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
                                                <label name="correo" for="inputEmail">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" />
                                                        <label name="clave" for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" />
                                                        <label name="claveDos" for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><a class="btn btn-primary btn-block" href="login.html">Create Account</a></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.html">¿Tienes cuenta ? Inicia aqui</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../js/scripts.js"></script>
    </body>
</html>
