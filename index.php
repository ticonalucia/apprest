<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styles.css">


    <script src="joya.js"></script>

    <title>Joyería</title>
   
</head>
<body>
    
    <div class="container">
        <table border="2">
        
        
        <div class="fondo-personalizado">
    <div id="panel-edicion" class="panel-edicion" style="display: none;">
    
        <h2>Editar Joya</h2>
        <form id="editForm">
            <input type="hidden" id="idEditar" name="idEditar">
            <label for="nombreJoyaEdit">Nombre:</label>
            <input type="text" id="nombreJoyaEdit" name="nombreJoyaEdit"><br><br>
            
            <label for="tipoEdit">Tipo:</label>
            <input type="text" id="tipoEdit" name="tipoEdit"><br><br>
            
            <label for="materialEdit">Material:</label>
            <input type="text" id="materialEdit" name="materialEdit"><br><br>
            
            <label for="pesoEdit">Peso:</label>
            <input type="text" id="pesoEdit" name="pesoEdit"><br><br>
            
            <button type="button" onclick="guardarCambiosJoya()">Guardar Cambios</button>
            <button type="button" onclick="ocultarFormularioEditar()">Salir</button>
        </form>
    </div>
    </div>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Material</th>
                    <th>Peso</th>
                    <th>Procede</th> <!-- Nueva columna para los botones de editar y eliminar -->
                </tr>
            </thead>
            <tbody>
                <?php
                $canal = curl_init();
                $url = 'http://localhost/ApiRest/get_all_joya.php/localhost/ApiRestRider/get_all_joya.php';
                curl_setopt($canal, CURLOPT_URL, $url);
                curl_setopt($canal, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($canal);

                if (curl_errno($canal)) {
                    $error_msg = curl_error($canal);
                    echo "<tr><td colspan='6'>Error en la conexión: $error_msg</td></tr>";
                } else {
                    curl_close($canal);

                    $joyas = json_decode($respuesta, true);
                    foreach ($joyas as $joya) {
                        echo "<tr>";
                        echo "<td>{$joya['id']}</td>";
                        echo "<td>{$joya['nombre']}</td>";
                        echo "<td>{$joya['tipo']}</td>";
                        echo "<td>{$joya['material']}</td>";
                        echo "<td>{$joya['peso']}</td>";
                        echo "<td>
                                <button onclick=\"mostrarFormularioEditar({$joya['id']}, '{$joya['nombre']}', '{$joya['tipo']}', '{$joya['material']}', '{$joya['peso']}')\">Editar</button>
                                <button onclick=\"eliminarJoya({$joya['id']})\">Eliminar</button></td>";
                                
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Panel de Edición -->
   

    <script>
        function mostrarFormularioEditar(id, nombre, tipo, material, peso) {
            document.getElementById('idEditar').value = id;
            document.getElementById('nombreJoyaEdit').value = nombre;
            document.getElementById('tipoEdit').value = tipo;
            document.getElementById('materialEdit').value = material;
            document.getElementById('pesoEdit').value = peso;

            document.getElementById('panel-edicion').style.display = 'block';
        }
      
        function ocultarFormularioEditar() {
            document.getElementById('panel-edicion').style.display = 'none';
        }

        function guardarCambiosJoya() {
            var id = document.getElementById('idEditar').value;
            var nombre = document.getElementById('nombreJoyaEdit').value;
            var tipo = document.getElementById('tipoEdit').value;
            var material = document.getElementById('materialEdit').value;
            var peso = document.getElementById('pesoEdit').value;

            var url = 'http://localhost/ApiRest/update_joya.php?id=' + id +
                      '&nombre=' + encodeURIComponent(nombre) +
                      '&tipo=' + encodeURIComponent(tipo) +
                      '&material=' + encodeURIComponent(material) +
                      '&peso=' + encodeURIComponent(peso);

            fetch(url, {
                method: 'PUT'
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("No se pudo editar la joya.");
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
            });
        }
        
        function eliminarJoya(id) {
            if (confirm("¿Está seguro de que desea eliminar esta joya?")) {
                fetch('http://localhost/ApiRest/delete_joya.php?id=' + id, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert("No se pudo eliminar la joya.");
                    }
                })
                .catch(error => {
                    console.error('Error al enviar la solicitud:', error);
                });
            }
        }
        function agregarJoya() {
            var nombre = document.getElementById("nombreJoyaAdd").value;
            var tipo = document.getElementById("tipoAdd").value;
            var material = document.getElementById("materialAdd").value;
            var peso = document.getElementById("pesoAdd").value;

            var url = 'http://localhost/ApiRest/create_joya.php?nombre=' + encodeURIComponent(nombre) + '&tipo=' + encodeURIComponent(tipo) + '&material=' + encodeURIComponent(material) + '&peso=' + encodeURIComponent(peso);

            fetch(url, {
                method: 'POST'
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("No se pudo agregar la joya.");
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
            });
        }
    </script>


<details>
            
            <summary><h2>Nueva Joya</h2></summary>
            <form id="addForm">
            <div class="fondo-personalizado"> 
                <label for="nombreJoyaAdd">Nombre:</label>
                <input type="text" id="nombreJoyaAdd" name="nombreJoyaAdd"><br><br>
                
                <label for="tipoAdd">Tipo:</label>
                <input type="text" id="tipoAdd" name="tipoAdd"><br><br>
                
                <label for="materialAdd">Material:</label>
                <input type="text" id="materialAdd" name="materialAdd"><br><br>
                
                <label for="pesoAdd">Peso:</label>
                <input type="text" id="pesoAdd" name="pesoAdd"><br><br>
                
                <button type="button" onclick="agregarJoya()">Agregar Joya</button>
            </div>
            </form>
        </details>
</body>
</html>


