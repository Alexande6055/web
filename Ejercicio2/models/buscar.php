<?php
include_once "conexion.php";
class crudBUSCAR {
    public static function seleccionarEstudiantesPorCedula($cedula) {
        // Prepare and execute the SQL statement
        $selectEstudiantes = "SELECT * FROM estudiantes WHERE cedula LIKE :cedula "; 
        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();
        
        $result = $conn->prepare($selectEstudiantes);
        $cedulaWithWildcard = $cedula . '%'; // Add wildcard '%' to the cedula value
        $result->bindParam(':cedula', $cedulaWithWildcard, PDO::PARAM_STR);        
        $result->execute();
        
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $dataJson = json_encode($data);
        
        // Return or echo the JSON data
        echo ($dataJson);
    }
}

?>