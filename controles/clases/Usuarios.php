<?php

class Usuarios
{
    private $pdo;

    public function __construct() {
 $host = 'db5015905427.hosting-data.io';
        $dbname = 'dbs12963202';
        $username = 'dbu5578123';
        $password = 'Nd8jhmRJvc';

        try {
            // Conexión a la base de datos utilizando PDO
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Manejo de errores en caso de fallo en la conexión o consulta
            echo "Error: en la conexion a la base de datos " . $e->getMessage();
        }    
    }    public function login($user, $pass)
    {
        try {
            $query = "SELECT id_usuario, nombre, apellido, dni, correo, clave 
                      FROM usuario 
                      WHERE lower(correo) = lower(:correo);";
            $queryPreparada = $this->pdo->prepare($query);
            $parametros = array(":correo" => $user);
            $queryPreparada->execute($parametros);
            $queryPreparada->setFetchMode(PDO::FETCH_ASSOC);
    
            $fila = $queryPreparada->fetch();
    
            if ($fila) {
                if ($pass === $fila['clave']) { // Verifica si la contraseña coincide
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION["id_usuario"] = $fila['id_usuario'];
                    $_SESSION["nombre"] = $fila['nombre'];
                    $_SESSION["apellido"] = $fila['apellido'];
                    $_SESSION["dni"] = $fila['dni'];
                    $_SESSION["correo"] = $fila['correo'];
                    $_SESSION["valid"] = true;
                    // Actualizar cualquier otra información necesaria en la base de datos aquí
                    header("Location: index.php"); // Redirige al usuario al index.php
                    exit();
                } else {
                    return "Contraseña incorrecta.";
                }
            } else {
                return "Usuario no encontrado.";
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de fallo en la conexión o consulta
            return "Error en la conexión a la base de datos: " . $e->getMessage();
        }
    }
    public function verificarDniYCorreo($dni, $correo) {
        try {
            // Preparar la consulta SQL para verificar si existe un usuario con el DNI y correo proporcionados
            $query = "SELECT * FROM usuario WHERE dni = :dni AND correo = :correo";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':dni', $dni);
            $statement->bindParam(':correo', $correo);
            $statement->execute();
            $usuario = $statement->fetch(PDO::FETCH_ASSOC);
            return $usuario ? $usuario : false;
        } catch (PDOException $e) {
            // Manejar errores en caso de problemas de conexión o consulta
            echo "Error: en la conexión a la base de datos " . $e->getMessage();
            return false;
        }
    }
    public function cambiarContrasena($id_usuario, $nueva_contrasena)
{
    try {
        // Preparar la consulta SQL para actualizar la contraseña del usuario
        $query = "UPDATE usuario SET clave = :nueva_contrasena WHERE id_usuario = :id_usuario";
        
        // Preparar la declaración
        $statement = $this->pdo->prepare($query);

        // Bind de parámetros
        $statement->bindParam(':nueva_contrasena', $nueva_contrasena);
        $statement->bindParam(':id_usuario', $id_usuario);

        // Ejecutar la consulta
        $statement->execute();

        // Devolver true para indicar que se actualizó correctamente
        return true;
    } catch (PDOException $e) {
        // Manejar errores en caso de problemas de conexión o consulta
        echo "Error: en la conexión a la base de datos " . $e->getMessage();
        return false; // Devolver false para indicar que ocurrió un error
    }
}

    public function nuevoUsuario($nombre, $apellido, $dni, $correo, $clave)
    {
        try {
            // Corregir la consulta SQL para usar correctamente los marcadores de posición
            $query = "INSERT INTO usuario (nombre, apellido, dni, correo, clave)
                      VALUES (:nombre, :apellido, :dni, :correo,  :clave)";

            $queryPreparada = $this->pdo->prepare($query);

            // Corregir el array de parámetros para incluir todos los valores
            $parametros = array(
                ":nombre" => $nombre,
                ":apellido" => $apellido,
                ":dni" => $dni,
                ":correo" => $correo,
                ":clave" => $clave
            );

            $queryPreparada->execute($parametros);
            $id_usuario = $this->pdo->lastInsertId();
            return $id_usuario;
            echo "<div class='container mt-5'><div class='alert alert-success' role='alert'>Nuevo registro creado exitosamente</div></div>";
        } catch (PDOException $e) {
            echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div></div>";
        }
        $this->pdo = null;
    }
    public function mostrarDatosUsuario($id_usuario) {
        try {
            // Consulta SQL para obtener los datos del usuario
            $queryUsuario = "SELECT nombre, apellido, dni, correo FROM usuario WHERE id_usuario = :id_usuario";
            $queryPreparadaUsuario = $this->pdo->prepare($queryUsuario);
            $queryPreparadaUsuario->bindParam(':id_usuario', $id_usuario);
            $queryPreparadaUsuario->execute();
            $usuario = $queryPreparadaUsuario->fetch(PDO::FETCH_ASSOC);

            // Verificar si se encontró el usuario
            if (!$usuario) {
                throw new Exception("Usuario no encontrado.");
            }

            // Generar el formulario HTML con los datos del usuario usando Bootstrap
            $formulario = "<form action='actualizar_usuario.php' method='POST' class='mt-4'>";
            $formulario .= "<div class='mb-3'>";
            $formulario .= "<label for='id_usuario' class='form-label'>ID Usuario:</label>";
            $formulario .= "<input type='text' class='form-control' id='id_usuario' name='id_usuario' value='{$id_usuario}' readonly>";
            $formulario .= "</div>";
            $formulario .= "<div class='mb-3'>";
            $formulario .= "<label for='nombre' class='form-label'>Nombre:</label>";
            $formulario .= "<input type='text' class='form-control' id='nombre' name='nombre' value='{$usuario['nombre']}'>";
            $formulario .= "</div>";
            $formulario .= "<div class='mb-3'>";
            $formulario .= "<label for='apellido' class='form-label'>Apellido:</label>";
            $formulario .= "<input type='text' class='form-control' id='apellido' name='apellido' value='{$usuario['apellido']}'>";
            $formulario .= "</div>";
            $formulario .= "<div class='mb-3'>";
            $formulario .= "<label for='dni' class='form-label'>DNI:</label>";
            $formulario .= "<input type='text' class='form-control' id='dni' name='dni' value='{$usuario['dni']}'>";
            $formulario .= "</div>";
            $formulario .= "<div class='mb-3'>";
            $formulario .= "<label for='correo' class='form-label'>Correo:</label>";
            $formulario .= "<input type='email' class='form-control' id='correo' name='correo' value='{$usuario['correo']}'>";
            $formulario .= "</div>";
            $formulario .= "<div class='mb-3'>";
            $formulario .= "<label for='nueva_contrasena' class='form-label'>Nueva Contraseña:</label>";
            $formulario .= "<input type='password' class='form-control' id='nueva_contrasena' name='nueva_contrasena'>";
            $formulario .= "</div>";
            $formulario .= "<button type='submit' class='btn btn-primary'>Modificar</button>";
            $formulario .= "</form>";

            return $formulario;

        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public function actualizarUsuario($id_usuario, $nombre, $apellido, $dni, $correo) {
        try {
            $query = "UPDATE usuario SET nombre = :nombre, apellido = :apellido, dni = :dni, correo = :correo WHERE id_usuario = :id_usuario";
            $queryPreparada = $this->pdo->prepare($query);
            $queryPreparada->bindParam(':id_usuario', $id_usuario);
            $queryPreparada->bindParam(':nombre', $nombre);
            $queryPreparada->bindParam(':apellido', $apellido);
            $queryPreparada->bindParam(':dni', $dni);
            $queryPreparada->bindParam(':correo', $correo);
            $queryPreparada->execute();

            header("Location: ./miCuenta.php");
           exit();

        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

?>