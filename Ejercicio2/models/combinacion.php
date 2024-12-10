<?php
include_once "conexion.php";
class crudInsertar {
    public static function insertarRelacion($estudiante_id, $curso_id) {
        // Prepare and execute the SQL statement
        $insertRelacion = "INSERT INTO estudiantes_cursos (estudiante_id, curso_id) VALUES (:estudiante_id, :curso_id)";
        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();
        
        $stmt = $conn->prepare($insertRelacion);
        $stmt->bindParam(':estudiante_id', $estudiante_id, PDO::PARAM_INT);
        $stmt->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            echo json_encode(["success" => true, "message" => "Relación insertada con éxito."]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    }
}
?>


<?php
include_once "conexion.php";

class crudProductos {
    public static function obtenerProductos() {
        $query = "SELECT id, nombre FROM productos";
        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();

        try {
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Devuelve los productos en formato JSON
            echo json_encode($productos);
        } catch (Exception $e) {
            echo json_encode(["error" => true, "message" => $e->getMessage()]);
        }
    }
}

// Llama al método para enviar los productos al frontend
crudProductos::obtenerProductos();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <h1>Seleccionar Producto</h1>
    <select id="productosSelect">
        <option value="">Seleccione un producto</option>
    </select>

    <p id="productoSeleccionado"></p>

    <script>
        // URL del archivo PHP que obtiene los productos
        const url = "ruta_a_tu_php/archivo.php";

        // Elemento <select>
        const productosSelect = document.getElementById("productosSelect");
        const productoSeleccionado = document.getElementById("productoSeleccionado");

        // Cargar los productos
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.message);
                } else {
                    // Rellena el <select> con las opciones
                    data.forEach(producto => {
                        const option = document.createElement("option");
                        option.value = producto.id; // El ID del producto
                        option.textContent = producto.nombre; // El nombre del producto
                        productosSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error("Error al cargar los productos:", error));

        // Evento para obtener el ID del producto seleccionado
        productosSelect.addEventListener("change", () => {
            const selectedId = productosSelect.value;
            const selectedText = productosSelect.options[productosSelect.selectedIndex].text;
            productoSeleccionado.textContent = selectedId 
                ? `ID: ${selectedId}, Producto: ${selectedText}`
                : "No se seleccionó ningún producto.";
        });
    </script>
</body>
</html>
