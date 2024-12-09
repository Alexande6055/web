<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Basic CRUD Application - jQuery EasyUI CRUD Demo</title>
    <link rel="stylesheet" type="text/css" href="../jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/easyui@1.10.0/themes/default/easyui.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/easyui@1.10.0/jquery.easyui.min.js"></script>

    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../jquery/jquery.easyui.min.js"></script>
</head>
<body>
    <h2>CRUD ESTUDIANTES</h2>
    <form id="estudianteForm" action="../controllers/apiRest.php" method='GET'>
    <label for="">Cédula</label>
    <input type="text" name='cedula' required>
</form>

<div>
    <button type="button" onclick="buscarUser()">Buscar</button>
</div>

<br>
<table id="dg" title="My Users" class="easyui-datagrid" style="width:700px;height:250px"
       url="http://localhost/servicios/Ejercicio2/controllers/apiRest.php" method='GET'
       toolbar="#toolbar" pagination="true"
       rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="cedula" width="50">Cedula</th>
            <th field="nombre" width="50">Nombre</th>
            <th field="apellido" width="50">Apellido</th>
            <th field="direccion" width="50">Direccion</th>
            <th field="telefono" width="50">Telefono</th>
        </tr>
    </thead>
</table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove User</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Estudiante</h3>
            <div style="margin-bottom:10px">
                <input name="cedula" class="easyui-textbox" required="true" label="Cedula:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="nombre" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="apellido" class="easyui-textbox" required="true" label="Apellido:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="telefono" class="easyui-textbox" required="true" label="Telefono:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="direccion" class="easyui-textbox" required="true" label="Direcion:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>

    <script type="text/javascript">
        var url;
        function newUser() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New User');
    $('#fm').form('clear'); // Limpia el formulario
    window.selectedCedula = null; // Restablece la cédula seleccionada
}


      

function editUser() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit User');
        $('#fm').form('load', row);
        window.selectedCedula = row.cedula; // Almacena la cédula para usarla al guardar
    } else {
        alert('Por favor, selecciona un usuario para editar.');
    }
}


function saveUser() {
    var url = 'http://localhost/servicios/Ejercicio2/controllers/apiRest.php';
    var type;

    if (window.selectedCedula) {
        // Estamos editando, así que usamos PUT
        url += '?cedula=' + window.selectedCedula;
        type = 'PUT';
    } else {
        // Estamos guardando, así que usamos POST
        type = 'POST';
    }

    $.ajax({
        url: url,
        type: type,
        data: $('#fm').serialize(),
        success: function(data) {
            console.log('Usuario guardado con éxito:', data);
            $('#dlg').dialog('close'); // Cierra el diálogo
            $('#dg').datagrid('reload'); // Recarga el datagrid con los datos actualizados
        },
        error: function(error) {
            console.error('Error al guardar el usuario:', error);
        }
    });
}

function destroyUser() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function(r) {
            if (r) {
                var url = 'http://localhost/servicios/Ejercicio2/controllers/apiRest.php?cedula=' + row.cedula;
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(result) {
                        if (result.success) {
                            $('#dg').datagrid('reload'); // Recargar los datos del usuario
                        } else {
                            $.messager.show({ // Mostrar mensaje de error
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        }
                    },
                    dataType: 'json' // Asegúrate de que estás esperando un JSON
                });
            }
        });
    } else {
        $.messager.alert('Warning', 'Por favor, selecciona un usuario para eliminar.');
    }
}
function buscarUser() {
    const cedula = document.querySelector('input[name="cedula"]').value.trim();
    if (cedula) {
        const form = document.getElementById('estudianteForm');
        const actionUrl = `../controllers/apiRest.php?cedula=${cedula}`;

        fetch(actionUrl)
            .then(response => response.json())
            .then(data => {
                // Check if data contains a message (for no student found)
                if (data.message) {
                    alert(data.message); // Alert user if no students found
                    $('#dg').datagrid('loadData', []); // Clear the datagrid
                    return;
                }

                // Load data into the datagrid
                $('#dg').datagrid('loadData', data);
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert('Por favor, ingrese una cédula.');
    }
}
    </script>
</body>
</html>