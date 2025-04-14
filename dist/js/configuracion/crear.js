function validarSoloLetras(event) {
    let charCode = event.charCode || event.keyCode;
    let char = String.fromCharCode(charCode);
    const regex = /^[A-Za-z\s]*$/;
    
    if (!regex.test(char) && char !== "") {
        event.preventDefault();
    }
}

function validarLetrasYNumeros(event) {
    let charCode = event.charCode || event.keyCode;
    let char = String.fromCharCode(charCode);
    const regex = /^[A-Za-z0-9\s]*$/;
    
    if (!regex.test(char) && char !== "") {
        event.preventDefault();
    }
}

function validarCampos(event) {
    const form = event.target.closest('form');
    const inputs = form.querySelectorAll('input[type="text"], select');
    let camposVacios = false;

    inputs.forEach(input => {
        if (input.value.trim() === '') {
            camposVacios = true;
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (camposVacios) {
        event.preventDefault();
        alert('Está intentando guardar un campo vacío');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const nombrePresentacion = document.getElementById('nombre_presentacion');
    const nombreServicio = document.getElementById('nombre_serv');
    const nombrePatologia = document.getElementById('nombre_patologia');
    const tipoEmpleado = document.getElementById('tipo');
    const nombrePnf = document.getElementById('nombre_pnf');

    if (nombrePresentacion) nombrePresentacion.addEventListener('keypress', validarSoloLetras);
    if (nombreServicio) nombreServicio.addEventListener('keypress', validarSoloLetras);
    if (nombrePatologia) nombrePatologia.addEventListener('keypress', validarLetrasYNumeros);
    if (tipoEmpleado) tipoEmpleado.addEventListener('keypress', validarSoloLetras);
    if (nombrePnf) nombrePnf.addEventListener('keypress', validarSoloLetras);

    const botonesGuardar = document.querySelectorAll('button[type="submit"]');
    botonesGuardar.forEach(boton => {
        boton.addEventListener('click', validarCampos);
    });
});

document.getElementById('form_pnf').addEventListener('submit', function(event) {
        var nombre_pnf = document.getElementById('nombre_pnf').value.trim();

        var errorDiv = document.getElementById('id_pnferror');

        if (/pnf/i.test(nombre_pnf)) {
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = 'Error: Ingrese solo el nombre sin la palabra "PNF", el sistema la añadirá automáticamente.';
            event.preventDefault();
        } else {
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';
        }
    });
    document.getElementById('form_pnf').addEventListener('submit', function(event) {
        var nombre_pnf = document.getElementById('nombre_pnf').value.trim();
        
        if (!nombre_pnf.startsWith('PNF')) {
            document.getElementById('nombre_pnf').value = 'PNF ' + nombre_pnf;
        }
    });