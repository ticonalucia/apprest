
function agregarJoya() {
    var nombre = document.getElementById("nombreAdd").value;
    var tipo = document.getElementById("tipoAdd").value;
    var material = document.getElementById("materialAdd").value;
    var peso = document.getElementById("pesoAdd").value;

    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('tipo', tipo);
    formData.append('material', material);
    formData.append('peso', peso);

    fetch('http://localhost/fronend_lucia/ApiRest/create_joya.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            throw new Error('No se pudo agregar la joya.');
        }
    })
    .catch(error => {
        console.error('Error al enviar la solicitud:', error);
        alert("No se pudo agregar la joya.");
    });
}
