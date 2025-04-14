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

document.getElementById('form_config').addEventListener('submit', function(event) {
    var nombre_pnf = document.getElementById('nombre_pnf').value.trim();
    var errorDiv = document.getElementById('id_pnferror');

    if (nombre_pnf && !/^PNF\s.+$/.test(nombre_pnf)) {
        errorDiv.style.display = 'block';
        errorDiv.innerHTML = 'Error: El nombre debe comenzar con "PNF" seguido de un espacio y el nombre correspondiente.';
        event.preventDefault();
    } else {
        errorDiv.style.display = 'none';
        errorDiv.innerHTML = '';
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const inputsValidacion = {
        'nombre_presentacion': validarSoloLetras,
        'nombre_serv': validarSoloLetras,
        'nombre_patologia': validarLetrasYNumeros,
        'tipo': validarSoloLetras,
        'nombre_pnf': validarSoloLetras
    };

    Object.keys(inputsValidacion).forEach(id => {
        const input = document.getElementById(id);
        if (input) input.addEventListener('keypress', inputsValidacion[id]);
    });

    const botonesGuardar = document.querySelectorAll('button[type="submit"]');
    botonesGuardar.forEach(boton => {
        boton.addEventListener('click', validarCampos);
    });
});