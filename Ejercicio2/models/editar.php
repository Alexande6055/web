<?php
include_once "conexion.php";

class crudU {
    public static function actualizarEstudiante() {
        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();

        // Acceder a las variables
        $cedula = $_REQUEST['cedula'] ?? null;
        $nombre = $_REQUEST['nombre'] ?? null;
        $apellido = $_REQUEST['apellido'] ?? null;
        $direccion = $_REQUEST['direccion'] ?? null;
        $telefono = $_REQUEST['telefono'] ?? null;

        // Verificar si las variables están definidas
        if (is_null($cedula) || is_null($nombre) || is_null($apellido) || is_null($direccion) || is_null($telefono)) {
            echo "Error: uno o más campos no están definidos.";
            return; // Salir de la función si hay un error
        }

        // Consulta SQL para actualizar el estudiante
        $actualizarEstudiante = "UPDATE estudiantes SET 
                                  nombre = :nombre, 
                                  apellido = :apellido, 
                                  direccion = :direccion, 
                                  telefono = :telefono 
                                  WHERE cedula = :cedula";
        try {
            // Preparar la consulta
            $stmt = $conn->prepare($actualizarEstudiante);
            
            // Enlazar los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':cedula', $cedula);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            echo json_encode("Se actualizó el estudiante con cédula: $cedula");
        } catch (PDOException $e) {
            // Manejo de errores
            echo json_encode("Error al actualizar el estudiante: " . $e->getMessage());
        }
    }
}

?>