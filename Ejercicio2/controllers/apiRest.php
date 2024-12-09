    <?php
    include_once '../models/acceder.php';
    include_once '../models/guardar.php';
    include_once '../models/borrar.php';
    include_once '../models/editar.php';
    include_once '../models/buscar.php';


    // Obtener el método HTTP (GET, POST, DELETE, PUT)
    $opc = $_SERVER['REQUEST_METHOD'];

    // Manejar diferentes métodos HTTP
    switch ($opc) {
        case 'GET':
            if (isset($_GET['cedula'])) {
                crudBUSCAR::seleccionarEstudiantesPorCedula($_GET['cedula']);
            } else {
                crudS::seleccionarEstudiantes(); // Retrieves all students
            }
            break;
            
        case 'POST':
            crudI::guardarEstudiante();
            break;

        case 'DELETE':
            crudD::borrarEstudiante();
            break;

        case 'PUT':
            parse_str(file_get_contents("php://input"), $_PUT);
            $_REQUEST = array_merge($_REQUEST, $_PUT);
            crudU::actualizarEstudiante(); 
            break;

        default:
            echo  json_encode("Método HTTP no soportado");
            break;
    }
    ?>
