<?php
include_once "conexion.php";

class crudD {
    public static function borrarEstudiante() {
        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();
        $cedula = $_REQUEST['cedula'];

        if (!empty($cedula)) {
            $borrarestudiante = "DELETE FROM estudiantes WHERE cedula = :cedula";
            $result = $conn->prepare($borrarestudiante);
            $result->bindParam(':cedula', $cedula); // Usando parámetros para evitar inyecciones SQL

            if ($result->execute()) {
                echo  json_encode('Estudiante eliminado correctamente.');
            } else {
                echo  json_encode('Error al eliminar el estudiante.');
            }
        } else {
            echo  json_encode('Cédula no especificada.');
        }
    }
}
?>
