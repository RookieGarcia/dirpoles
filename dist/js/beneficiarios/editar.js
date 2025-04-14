document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    document.getElementById('nombres').addEventListener('input', function() {
        validarNombreApellido(this, 'nombreerror');
    });
    document.getElementById('apellidos').addEventListener('input', function() {
        validarNombreApellido(this, 'apellidoerror');
    });
    document.getElementById('cedula').addEventListener('input', function() {
        validarCedula(this);
    });
    document.getElementById('correo').addEventListener('input', function() {
        validarCorreo(this);
    });
    document.getElementById('telefono_numero').addEventListener('input', function() {
        validarTelefono(this);
    });
   
    document.getElementById('fecha_nac').addEventListener('input', function() {
        validarFechaNacimiento();
    });
    document.getElementById('direccion').addEventListener('input', function() {
        validarDireccion();
    });

    document.getElementById('telefono_prefijo').addEventListener('change', function() {
        validarPrefijoTelefono(this);
    });
    document.getElementById('id_pnf').addEventListener('change', function() {
        validarSeleccion(this, 'id_pnferror');
    });
    document.getElementById('genero').addEventListener('change', function() {
        validarSeleccion(this, 'generoerror');
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const errores = validarFormulario();
        if (errores.length > 0) {
            console.log("Errores encontrados:", errores);
        } else {
            form.submit();
        }
    });
});

function eliminarErrorDeCampo(errorId) {
    const errorElement = document.getElementById(errorId);
    if (errorElement) {
        errorElement.textContent = '';
    }
}

function eliminarTodosErrores() {
    const errorElements = document.querySelectorAll('.text-danger');
    errorElements.forEach(errorElement => {
        errorElement.textContent = '';
    });
}

function validarCorreo(input) {
    const correoError = document.getElementById('correoerror');
    const correoRegex = /^[a-zA-Z0-9._%+-]+@(hotmail|yahoo|gmail|outlook)\.com$/i;

    correoError.textContent = ''; 
    if (!correoRegex.test(input.value)) {
        correoError.textContent = 'Por favor, ingrese un correo válido con un dominio permitido (hotmail, yahoo, gmail, outlook).';
        return false;
    }
    return true;
}

function validarTelefono(input) {
    const telefonoError = document.getElementById('telefonoerror');
    
    telefonoError.textContent = '';
    input.value = input.value.replace(/[^0-9]/g, '');

    if (input.value === '') {
        telefonoError.textContent = 'Este campo es obligatorio.';
        return false;
    }
    if (input.value.length !== 7) {
        telefonoError.textContent = 'Introduzca un teléfono válido';
        return false;
    }
    return true;
}


function validarCedula(input) {
    const cedulaError = document.getElementById('cedulaerror');
    input.value = input.value.replace(/[^0-9]/g, '');

    if (input.value.length < 7 || input.value.length > 8) {
        cedulaError.textContent = 'Introduzca una cédula válida';
        return false;
    } else {
        cedulaError.textContent = '';
    }
    return true;
}

function validarNombreApellido(input, errorId) {
    const errorElement = document.getElementById(errorId);
    errorElement.textContent = '';

    if (input.value.trim() === '') {
        errorElement.textContent = 'Este campo es obligatorio.';
        return false;
    }

    input.value = input.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
    if (/[^A-Za-zÀ-ÿ\s]/.test(input.value)) {
        errorElement.textContent = 'Solo se permiten letras y espacios.';
        return false;
    }
    return true;
}


function validarFechaNacimiento() {
    const fechaNacimientoInput = document.getElementById('fecha_nac');
    const fechaNacimientoError = document.getElementById('fechaNacimientoError');

    fechaNacimientoError.textContent = '';

    if (!fechaNacimientoInput.value) {
        fechaNacimientoError.textContent = 'La fecha de nacimiento es obligatoria.';
        return false;
    }

    const fechaNacimiento = new Date(fechaNacimientoInput.value);
    const hoy = new Date();
    const edadMinima = 18;

    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }

    if (edad < edadMinima) {
        fechaNacimientoError.textContent = 'Debe registrar una persona mayor de edad (18 años o más).';
        return false;
    }
    return true;
}

function validarDireccion() {
    const direccionInput = document.getElementById('direccion');
    const direccionError = document.getElementById('direccionerror');

    direccionError.textContent = '';
    if (direccionInput.value.trim() === '') {
        direccionError.textContent = 'La dirección es obligatoria.';
        return false;
    }
    return true;
}

function validarPrefijoTelefono(input) {
    const prefijoError = document.getElementById('telefono_prefijoerror');
    
    prefijoError.textContent = '';
    if (input.value === '') {
        prefijoError.textContent = 'Debe seleccionar un prefijo de teléfono.';
        return false;
    }
    return true;
}

function validarSeleccion(input, errorId) {
    const errorElement = document.getElementById(errorId);
    errorElement.textContent = '';

    if (input.value === '' || input.selectedIndex === '') {
        errorElement.textContent = 'Este campo es obligatorio.';
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const telefonoCompleto = "<?php echo htmlspecialchars($beneficiarios['telefono']); ?>";
    
    if (telefonoCompleto.length === 11) {
        const prefijo = telefonoCompleto.substring(0, 4);
        const numero = telefonoCompleto.substring(4);
        
        document.getElementById('telefono_prefijo').value = prefijo;
        document.getElementById('telefono_numero').value = numero;
    }
});

function validarFormulario() {
    const errores = [];
    if (!validarCorreo(document.getElementById('correo'))) errores.push('correo');
    if (!validarTelefono(document.getElementById('telefono_numero'))) errores.push('telefono');
    if (!validarNombreApellido(document.getElementById('nombres'), 'nombreerror')) errores.push('nombres');
    if (!validarNombreApellido(document.getElementById('apellidos'), 'apellidoerror')) errores.push('apellidos');
    if (!validarCedula(document.getElementById('cedula'))) errores.push('cedula');
    
    if (!validarFechaNacimiento()) errores.push('fecha_nac'); if (!validarDireccion()) errores.push('direccion'); if (!validarPrefijoTelefono(document.getElementById('telefono_prefijo'))) errores.push('telefono_prefijo'); if (!validarSeleccion(document.getElementById('id_pnf'), 'id_pnferror')) errores.push('id_pnf'); if (!validarSeleccion(document.getElementById('genero'), 'generoerror')) errores.push('genero');
    return errores;
}