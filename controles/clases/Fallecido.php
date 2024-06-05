<?php
require "Acceso.php";

class Fallecido {
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
    }


    public function confirmarAcceso($id_usuario, $id_fallecido) {
        try {
            // Insertar en la tabla usuario_fallecido
            $query = "INSERT INTO usuario_fallecido (id_usuario, id_fallecido) VALUES (:id_usuario, :id_fallecido)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':id_usuario' => $id_usuario,
                ':id_fallecido' => $id_fallecido
            ]);

            return true; // Indicar éxito
        } catch (PDOException $e) {
            // Manejar errores
            return "Error: " . $e->getMessage();
        }
    }

    public function darDeAltaFallecido($nombre, $apellido, $fecha_nac, $fecha_def, $id_cementerio, $ubicacion_tumba) {
        try {
            // Insertar nuevo fallecido
            $query = "INSERT INTO fallecido (nombre, apellido, fecha_nac, fecha_def, id_cementerio, ubicacion_tumba) 
                      VALUES (:nombre, :apellido, :fecha_nac, :fecha_def, :id_cementerio, :ubicacion_tumba)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':fecha_nac' => $fecha_nac,
                ':fecha_def' => $fecha_def,
                ':id_cementerio' => $id_cementerio,
                ':ubicacion_tumba' => $ubicacion_tumba
            ]);

            // Obtener el último ID insertado de fallecido
            $id_fallecido = $this->pdo->lastInsertId();

            // Obtener el ID del usuario de la sesión
            $id_usuario = $_SESSION['id_usuario'];

            // Insertar en la tabla usuario_fallecido
            $query = "INSERT INTO usuario_fallecido (id_usuario, id_fallecido) VALUES (:id_usuario, :id_fallecido)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':id_usuario' => $id_usuario,
                ':id_fallecido' => $id_fallecido
            ]);

            return true; // Indicar éxito
        } catch (PDOException $e) {
            // Manejar errores
            return "Error: " . $e->getMessage();
        }
    }

    public function generarSelectFallecidosPorUsuario($id_usuario) {
        try {
            // Consulta SQL para obtener los IDs de los fallecidos asociados al ID de usuario
            $query = "SELECT id_fallecido FROM usuario_fallecido WHERE id_usuario = :id_usuario";
            $queryPreparada = $this->pdo->prepare($query);
            $queryPreparada->bindParam(':id_usuario', $id_usuario);
            $queryPreparada->execute();
            
            // Inicializar el array para almacenar los fallecidos
            $fallecidos = [];
    
            // Obtener los IDs de los fallecidos asociados al usuario
            while ($fila = $queryPreparada->fetch(PDO::FETCH_ASSOC)) {
                // Obtener los datos de cada fallecido utilizando su ID
                $id_fallecido = $fila['id_fallecido'];
                $queryFallecido = "SELECT nombre, apellido FROM fallecido WHERE id_fallecido = :id_fallecido";
                $queryPreparadaFallecido = $this->pdo->prepare($queryFallecido);
                $queryPreparadaFallecido->bindParam(':id_fallecido', $id_fallecido);
                $queryPreparadaFallecido->execute();
                $fallecido = $queryPreparadaFallecido->fetch(PDO::FETCH_ASSOC);
                
                // Agregar los datos del fallecido al array
                if ($fallecido) {
                    $fallecidos[] = [
                        'id_fallecido' => $id_fallecido,
                        'nombre' => $fallecido['nombre'],
                        'apellido' => $fallecido['apellido']
                    ];
                }
            }
    
            // Retornar el array de fallecidos
            return $fallecidos;
        } catch (PDOException $e) {
            // Manejar el error
            return [];
        }
    }
            

    public function formularioModificacionFallecido($id_fallecido) {
        try {
            // Consultar los datos del fallecido por su ID
            $query = "SELECT * FROM fallecido WHERE id_fallecido = :id_fallecido";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id_fallecido' => $id_fallecido]);
            $fallecido = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($fallecido) {
                // Generar el formulario con los datos del fallecido
                ?>
                <form action="ruta_de_tu_script_para_actualizar_fallecido.php" method="POST">
                    <input type="hidden" name="id_fallecido" value="<?= $fallecido['id_fallecido'] ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $fallecido['nombre'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $fallecido['apellido'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="<?= $fallecido['fecha_nac'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_def" class="form-label">Fecha de Defunción</label>
                        <input type="date" class="form-control" id="fecha_def" name="fecha_def" value="<?= $fallecido['fecha_def'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_cementerio" class="form-label">ID del Cementerio</label>
                        <input type="text" class="form-control" id="id_cementerio" name="id_cementerio" value="<?= $fallecido['id_cementerio'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion_tumba" class="form-label">Ubicación de la Tumba</label>
                        <input type="text" class="form-control" id="ubicacion_tumba" name="ubicacion_tumba" value="<?= $fallecido['ubicacion_tumba'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </form>
                <?php
            } else {
                echo "No se encontró el fallecido con ID: $id_fallecido";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function galeria($id_fallecido) {
        try {
            $query = "
            SELECT 
                cb.id_publicacion,
                cb.foto,
                cb.videos,
                cb.contenido,
                cb.fecha,
                cb.titulo,
                u.nombre AS nombre_usuario,
                u.apellido AS apellido_usuario
            FROM 
                contenido_blog cb
            JOIN 
                usuario u ON cb.id_usuario = u.id_usuario
            WHERE 
                cb.id_fallecido = :id_fallecido
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id_fallecido' => $id_fallecido]);
    
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;  
            
        } catch (PDOException $e) {
            echo "Error al obtener el contenido del blog: " . $e->getMessage();
            return [];
        }
    }
    public function contenidoBlog($id_fallecido) {
        try {
            $query = "
            SELECT 
                cb.id_publicacion,
                cb.foto,
                cb.videos,
                cb.contenido,
                cb.fecha,
                cb.titulo,
                u.nombre AS nombre_usuario,
                u.apellido AS apellido_usuario
            FROM 
                contenido_blog cb
            JOIN 
                usuario u ON cb.id_usuario = u.id_usuario
            WHERE 
                cb.id_fallecido = :id_fallecido
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id_fallecido' => $id_fallecido]);
    
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($resultados){
                foreach ($resultados as $resultado) {
                    $idPublicacion = $resultado['id_publicacion'];
                    $titulo = $resultado['titulo'];
                    $contenido = $resultado['contenido'];
                    $fecha = $resultado['fecha'];
                    $nombreUsuario = $resultado['nombre_usuario'];
                    $apellidoUsuario = $resultado['apellido_usuario'];
                    
                    echo "<h2>$titulo</h2>";
                    echo "<p>$contenido</p>";
                    echo "<p><small>Publicado el $fecha por $nombreUsuario $apellidoUsuario</small></p>";
        
                    if (!empty($resultado['foto'])) {
                        $foto = $resultado['foto'];
                        echo "<img src='$foto' alt='Imagen de la publicación' style='max-width: 20rem; height: 20rem;'/>";
                    }
        
                    if (!empty($resultado['videos'])) {
                        $video = $resultado['videos'];
                        echo "<video controls style='max-width: 60%; height: 20rem;'>
                                <source src='$video' type='video/mp4'>
                                Tu navegador no soporta la etiqueta de video.
                            </video>";
                    }
        
                    echo "<hr/>";
                }
        
                return $resultados;
            }else{
                echo "<div class='alert alert-warning' role='alert'>No se encontraron publicaciones para este fallecido</div>";
                echo "<img src='../../assets/img/sinResultados.jpeg' alt='sinDatos' style='max-width: 20rem; height: 20rem;'/>";
            }
        } catch (PDOException $e) {
            echo "Error al obtener el contenido del blog: " . $e->getMessage();
            return [];
        }
    }
    
    
    public function actualizarPublicacion($id_publicacion, $titulo, $contenido)
    {
        try {
            $query = "UPDATE contenido_blog SET titulo = :titulo, contenido = :contenido WHERE id_publicacion = :id_publicacion";
            $queryPreparada = $this->pdo->prepare($query);
            $queryPreparada->bindParam(':id_publicacion', $id_publicacion);
            $queryPreparada->bindParam(':titulo', $titulo);
            $queryPreparada->bindParam(':contenido', $contenido);
            $queryPreparada->execute();
            return true; // La actualización se realizó con éxito
        } catch (PDOException $e) {
            //avisa que fallo la actualización
            return false;
        }
    }
    public function obtenerUltimoIdInsercion() {
        return $this->pdo->lastInsertId();
    }

    public function actualizar_bd_con_ruta_imagen($id, $ruta) {
        $sql = "UPDATE contenido_blog SET foto = :ruta WHERE id_publicacion = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                error_log("Imagen actualizada correctamente: " . $ruta);
            } else {
                error_log("No se actualizó ninguna fila para la imagen: " . $ruta);
            }
        } catch (PDOException $e) {
            error_log("Error al actualizar imagen: " . $e->getMessage());
        }
    }

    public function actualizar_bd_con_ruta_video($id, $ruta) {
        $sql = "UPDATE contenido_blog SET videos = :ruta WHERE id_publicacion = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                error_log("Video actualizado correctamente: " . $ruta);
            } else {
                error_log("No se actualizó ninguna fila para el video: " . $ruta);
            }
        } catch (PDOException $e) {
            error_log("Error al actualizar video: " . $e->getMessage());
        }
    }

    public function buscarFallecido($parametro) {
        try {
            // Consultar fallecidos que coincidan con el parámetro proporcionado
            $query = "SELECT * FROM fallecido WHERE nombre LIKE :parametro OR apellido LIKE :parametro";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':parametro' => "%$parametro%"]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Mostrar los resultados y el botón de solicitar acceso si se encuentra algún fallecido
            foreach ($resultados as $resultado) {
                $id_fallecido = $resultado['id_fallecido'];
                $nombre = $resultado['nombre'];
                $apellido = $resultado['apellido'];
                $fecha_nac = $resultado['fecha_nac'];
                $fecha_def = $resultado['fecha_def'];
    
                echo "<div>";
                echo "<p><strong>Nombre:</strong> $nombre $apellido</p>";
                echo "<p><strong>Fecha de Nacimiento:</strong> $fecha_nac</p>";
                echo "<p><strong>Fecha de Defunción:</strong> $fecha_def</p>";
                echo "<form action='" . $_SERVER["PHP_SELF"] . "' method='POST'>";
                echo "<input type='hidden' name='id_fallecido' value='$id_fallecido'>";
                echo "<button type='submit' name='solicitar_acceso'>Solicitar Acceso</button>";
                echo "</form>";
                echo "</div>";
            }
    
            // Si no se encontraron resultados, mostrar un mensaje
            if (empty($resultados)) {
                echo "No se encontraron fallecidos que coincidan con el parámetro proporcionado.";
            }
        } catch (PDOException $e) {
            echo "Error al buscar fallecido: " . $e->getMessage();
        }
    }

    public function imprimirDatosFallecido($datosFallecido) {
        try {
            if (!is_array($datosFallecido)) {
                throw new Exception("Datos de fallecidos no son válidos.");
            }
    
            foreach ($datosFallecido as $id_usuario => $fallecidos) {
                // Consultar los datos del usuario solicitante
                $query_usuario = "SELECT nombre, apellido FROM usuario WHERE id_usuario = :id_usuario";
                $stmt_usuario = $this->pdo->prepare($query_usuario);
                $stmt_usuario->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt_usuario->execute();
                $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
    
                if (!$usuario) {
                    echo "<div class='alert alert-warning' role='alert'>No se encontraron datos para el usuario con ID: {$id_usuario}</div>";
                    continue;
                }
    
                foreach ($fallecidos as $id_fallecido) {
                    // Consultar los datos del fallecido
                    $query = "SELECT nombre, apellido, fecha_nac, fecha_def FROM fallecido WHERE id_fallecido = :id_fallecido";
                    $stmt = $this->pdo->prepare($query);
                    $stmt->bindParam(':id_fallecido', $id_fallecido, PDO::PARAM_INT);
                    $stmt->execute();
                    $fallecido = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if (!$fallecido) {
                        echo "<div class='alert alert-warning' role='alert'>No se encontraron datos para el fallecido con ID: {$id_fallecido}</div>";
                        continue;
                    }
    
                    echo "<div class='card mb-3'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($fallecido['nombre']) . " " . htmlspecialchars($fallecido['apellido']) . "</h5>";
                    echo "<p class='card-text'><strong>Fecha de Nacimiento:</strong> " . htmlspecialchars($fallecido['fecha_nac']) . "</p>";
                    echo "<p class='card-text'><strong>Fecha de Defunción:</strong> " . htmlspecialchars($fallecido['fecha_def']) . "</p>";
                    echo "<p class='card-text'><strong>Solicitante:</strong> " . htmlspecialchars($usuario['nombre']) . " " . htmlspecialchars($usuario['apellido']) . "</p>";
                    echo "<form action='ejecutarConfirmacion.php' method='POST'>";
                    echo "<input type='hidden' name='id_fallecido' value='" . htmlspecialchars($id_fallecido) . "'>";
                    echo "<input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_usuario) . "'>";
                    echo "<button type='submit' class='btn btn-primary' name='confirmar_acceso'>Confirmar Acceso</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        } catch (PDOException $e) {
            // Manejar errores de PDO
            echo "<div class='alert alert-danger' role='alert'>Error al imprimir los datos del fallecido: " . $e->getMessage() . "</div>";
        } catch (Exception $e) {
            // Manejar otros errores
            echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
        }
    }
    
    public function leerCSV($archivo) {
        $fila = array_map('str_getcsv', file($archivo));
        $cabeceras = array_shift($fila);
        $csv = array();
        foreach ($fila as $fila) {
            $csv[] = array_combine($cabeceras, $fila);
        }
        return $csv;
    }

    public function escribirCSV($archivo, $data) {
        $output = fopen($archivo, 'w');
        foreach ($data as $fila) {
            fputcsv($output, $fila);
        }
        fclose($output);
    }

    public function eliminarConfirmados($archivo, $id_usuario, $id_fallecido) {
        $datos = $this->leerCSV($archivo);
        $nuevosDatos = array_filter($datos, function($fila) use ($id_usuario, $id_fallecido) {
            return !($fila['id_usuario'] == $id_usuario && $fila['id_fallecido'] == $id_fallecido);
        });
        $this->escribirCSV($archivo, $nuevosDatos);
    }

    public function eliminarCoincidenciaCSV($archivo, $id_usuario, $id_fallecido) {
        try {
            // Leer el contenido del archivo CSV
            $datos = $this->leerCSV($archivo);
    
            // Filtrar las filas que coincidan con las variables proporcionadas
            $nuevosDatos = array_filter($datos, function($fila) use ($id_usuario, $id_fallecido) {
                return !($fila['id_usuario'] == $id_usuario && $fila['id_fallecido'] == $id_fallecido);
            });
    
            // Escribir los datos filtrados de nuevo en el archivo CSV
            $this->escribirCSV($archivo, $nuevosDatos);
    
            return "Coincidencia eliminada del archivo CSV correctamente.";
        } catch (Exception $e) {
            return "Error al eliminar la coincidencia del archivo CSV: " . $e->getMessage();
        }
    }

    public function registrarSolicitudAcceso($id_fallecido, $id_usuarioSolicitante) {
        try {
            // Crear el archivo CSV si no existe y abrirlo en modo de escritura
            $csvFile = fopen("../../registros/solicitudesAcceso.csv", "a");
    
            // Verificar si se pudo abrir el archivo correctamente
            if ($csvFile !== false) {
                // Escribir la solicitud en el archivo CSV
                fputcsv($csvFile, array($id_fallecido, $id_usuarioSolicitante));
    
                // Cerrar el archivo CSV
                fclose($csvFile);
    
                echo "Solicitud de acceso registrada correctamente.";
            } else {
                echo "No se pudo abrir el archivo para escribir la solicitud de acceso.";
            }
        } catch (Exception $e) {
            echo "Error al registrar la solicitud de acceso: " . $e->getMessage();
        }
    }

    public function obtenerIdFallecidosPorUsuario($id_usuario) {
        try {
            // Consultar los id_fallecido asociados al id_usuario
            $query = "SELECT id_fallecido FROM usuario_fallecido WHERE id_usuario = :id_usuario";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
            $idFallecidos = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // Leer el archivo CSV de solicitudesAcceso
            $solicitudesAcceso = [];
            $csvFile = dirname(__FILE__) . '\registros\solicitudesAcceso.csv'; // Ruta del archivo CSV
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Asumiendo que el primer valor en cada fila del CSV es el id_fallecido
                    $id_fallecido = $data[0];
                    $id_usuario_solicitante = $data[1];
                    
                    // Si el id_usuario_solicitante ya existe en el arreglo, agregamos el id_fallecido al arreglo existente
                    if (isset($solicitudesAcceso[$id_usuario_solicitante])) {
                        $solicitudesAcceso[$id_usuario_solicitante][] = $id_fallecido;
                    } else { // Si no existe, creamos un nuevo arreglo con el id_fallecido
                        $solicitudesAcceso[$id_usuario_solicitante] = [$id_fallecido];
                    }
                }
                fclose($handle);
            }
    
            return $solicitudesAcceso;
        } catch (PDOException $e) {
            // Manejar errores
            return [];
        }
    }
    public function crearPublicacion($id_usuario, $id_fallecido, $titulo, $contenido,$foto=null ,$video=null){
        try {
        
            $query = "INSERT INTO contenido_blog ( id_usuario, id_fallecido, titulo, contenido, foto, videos) 
                    VALUES ( :id_usuario, :id_fallecido, :titulo, :contenido,  :foto, :videos)";
                $queryPreparada = $this->pdo->prepare($query);
            
            $queryPreparada->bindParam(':id_usuario', $id_usuario);
            $queryPreparada->bindParam(':id_fallecido', $id_fallecido);
            $queryPreparada->bindParam(':titulo', $titulo);
            $queryPreparada->bindParam(':contenido', $contenido);
            $queryPreparada->bindParam(':foto', $foto);
            $queryPreparada->bindParam(':videos', $videos);    
    
            if(!empty($foto)||!empty($foto)){
                
                $uploadDir = "./multimedia/";
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
            
                $fotoPath = null;
                if (isset($foto) && $foto['error'] == 0) {
                    $fotoPath = "$uploadDir/" . basename($foto['name']);
                    move_uploaded_file($foto['tmp_name'], $fotoPath);
                }
        
                $videoPath = null;
                if (isset($video) && $video['error'] == 0) {
                    $videoPath = "$uploadDir/" . basename($video['name']);
                    move_uploaded_file($video['tmp_name'], $videoPath);
                }
    
            
            }
    
    
            $queryPreparada->execute();
            return "Nueva publicación creada exitosamente";
            echo "Publicacion creada correctamente";

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function obtenerNombresUsuariosPorFallecido($id_fallecido) {
        try {
            // Consulta SQL para obtener los nombres de los usuarios relacionados con el fallecido
            $query = "SELECT u.nombre, u.apellido 
                      FROM usuario_fallecido uf
                      JOIN usuario u ON uf.id_usuario = u.id_usuario
                      WHERE uf.id_fallecido = :id_fallecido";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_fallecido', $id_fallecido);
            $stmt->execute();
    
            // Inicializar el array para almacenar los nombres de los usuarios
            $nombresUsuarios = [];
    
            // Obtener los nombres de los usuarios relacionados con el fallecido
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nombre = $fila['nombre'];
                $apellido = $fila['apellido'];
    
                // Agregar el nombre completo del usuario al array
                $nombresUsuarios[] = "$nombre $apellido";
            }
    
            // Retornar el array de nombres de usuarios
            return $nombresUsuarios;
        } catch (PDOException $e) {
            // Manejar el error
            return [];
        }
    }
    public function obtenerNombresCementerios() {
        try {
            $query = "SELECT id_cementerio, nombre FROM cementerio";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
            }  
    }
}