<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Inicio</div>
                    <a class="nav-link" href="../fallecidos/blog.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Blog
                    </a>                    <a class="nav-link" href="../fallecidos/galeria.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Imagenes
                    </a>
                    <a class="nav-link" href="../fallecidos/videoteca.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Videos
                    </a>

                    <div class="sb-sidenav-menu-heading">Opciones</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                        aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Paginas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                aria-controls="pagesCollapseAuth">
                                Fallecido
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../fallecidos/darAltaFallecido.php">Alta</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapseError" aria-expanded="false"
                                aria-controls="pagesCollapseError">
                                Usuarios
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../fallecidos/listarUsuario_Fallecidos.php">Listar Usuarios</a>
                                    <a class="nav-link" href="../usuarios/registrarUsuario.php">Crear Usuarios</a>
                                </nav>
                            </div>
                        </nav>
                    </div>


                    <div class="sb-sidenav-menu-heading">Complementos</div>
                    <a class="nav-link" href="../fallecidos/seleccionarFallecido.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Cambiar Fallecido
                    </a>
                    <a class="nav-link" href="../usuarios/confirmarSolicitudes.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Confirmar Acceso a fallecido
                    </a>
                    
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Bienvenido
                    <?php echo $_SESSION['nombre'] ?>
                    <?php echo $_SESSION['apellido'] ?>
                    <?php echo date('d-m-Y'); ?>
                </div>

            </div>
        </nav>
    </div>