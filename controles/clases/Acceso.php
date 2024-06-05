<?php
class Acceso
{
    private $pdo;

    public function __construct()
    {
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
            echo "Error en la conexión a la base de datos: " . $e->getMessage();
            exit();
        }
    }


    
    public function login($user, $pass)
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
                if ($pass === $fila['clave']) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION["id_usuario"] = $fila['id_usuario'];
                    $_SESSION["nombre"] = $fila['nombre'];
                    $_SESSION["apellido"] = $fila['apellido'];
                    $_SESSION["dni"] = $fila['dni'];
                    $_SESSION["correo"] = $fila['correo'];
                    $_SESSION["valid"] = true;
                    return true;
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

    public function datosFallecido($id_usuario)
    {
        try {
            $query = "SELECT fa.nombre, fa.apellido, fa.id_usuario
                      FROM fallecido fa
                      LEFT JOIN usuario u ON fa.id_usuario = u.id_usuario
                      WHERE fa.id_usuario = :id_usuario;";
            $queryPreparada = $this->pdo->prepare($query);
            $parametros = array(":id_usuario" => $id_usuario);
            $queryPreparada->execute($parametros);
            $queryPreparada->setFetchMode(PDO::FETCH_ASSOC);

            $fila = $queryPreparada->fetch();
            if ($fila) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["nombre_fallecido"] = $fila['nombre'];
                $_SESSION["apellido_fallecido"] = $fila['apellido'];
            } else {
                return "Error en los datos ingresados.";
            }
        } catch (PDOException $e) {
            return "Error en la conexión a la base de datos: " . $e->getMessage();
        }
    }
}
?>