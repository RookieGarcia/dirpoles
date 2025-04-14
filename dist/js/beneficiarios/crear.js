//------------------------------------------------- AJAX
function validarCed(element, callback) {
    const tipoCedula = document.getElementById('tipo_cedula').value;
    const cedula = element.value.trim();
    const cedulaError = document.getElementById('cedulaerror');

    element.value = element.value.replace(/[^0-9]/g, '');

    if (cedula.length < 7 || cedula.length > 8) {
        cedulaError.textContent = 'Introduzca una cédula válida';
        callback(false);
        return;
    } else {
        cedulaError.textContent = '';
    }

    if (cedula) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?action=validar_cedula", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send("cedula=" + encodeURIComponent(cedula) + "&tipo_cedula=" + encodeURIComponent(tipoCedula));

        xhr.onload = function() {
            if (xhr.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);

                if (respuesta.existe) {
                    cedulaError.textContent = "La cédula ya está registrada.";
                    callback(false);
                } else {
                    cedulaError.textContent = "";
                    callback(true);
                }
            } else {
                cedulaError.textContent = "Error al verificar la cédula. Intente nuevamente.";
                callback(false);
            }
        };
    } else {
        cedulaError.textContent = "Debe ingresar una cédula.";
        callback(false);
    }
}
//--------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    document.getElementById('nombres').addEventListener('input', function() {
        validarNombreApellido(this, 'nombreerror');
    });
    document.getElementById('apellidos').addEventListener('input', function() {
        validarNombreApellido(this, 'apellidoerror');
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
    document.getElementById('estatus').addEventListener('change', function() {
        validarSeleccion(this, 'estatuserror');
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        concatenarTelefono();
        const errores = validarFormulario();
        if (errores.length > 0) {
            console.log("Errores encontrados:", errores);
        } else {
            validarCed(document.getElementById('cedula'), function(isCedulaValid) {
                if (isCedulaValid) {
                    form.submit();
                } else {
                    toastr.error("La cedula que introdujo ya se encuentra en sistema.", "Error");
                }
            });
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
    const correoRegex = /^[a-zA-Z0-9._%+-]+@(hotmail|yahoo|gmail|outlook)\.(com|es|net|org)$/i;

    correoError.textContent = '';
    if (!correoRegex.test(input.value)) {
        correoError.textContent = 'Por favor, ingrese un correo válido con un dominio permitido (hotmail, yahoo, gmail, outlook).';
        return false;
    }
    return true;
}

function validarTelefono(input) {
    const prefijo = document.getElementById('telefono_prefijo').value;
    const telefonoError = document.getElementById('telefonoerror');
    const numero = input.value.trim();

    telefonoError.textContent = '';
    input.value = numero.replace(/[^0-9]/g, '');

    // Validación básica de longitud
    if (numero.length !== 7) {
        telefonoError.textContent = 'Debe tener 7 dígitos';
        return false;
    }

    // Validación de existencia en BD
    if (prefijo && numero) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?action=validar_telefono", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.send("prefijo=" + encodeURIComponent(prefijo) + "&numero=" + encodeURIComponent(numero));

        xhr.onload = function() {
            if (xhr.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);
                
                if (respuesta.existe) {
                    telefonoError.textContent = "El teléfono ya está registrado";
                } else {
                    telefonoError.textContent = "";
                }
            }
        };
    }

    return true;
}

// Función de concatenación actualizada
function concatenarTelefono() {
    const prefijo = document.getElementById('telefono_prefijo').value;
    const numero = document.getElementById('telefono_numero').value;
    
    if (prefijo && numero) {
        // Si tienes un campo oculto para el teléfono completo:
        document.getElementById('telefono').value = prefijo + numero;
    }
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

    if (input.value === '' || input.selectedIndex === 0) {
        errorElement.textContent = 'Este campo es obligatorio.';
        return false;
    }
    return true;
}

function validarFormulario() {
    const errores = [];
    if (!validarCorreo(document.getElementById('correo'))) errores.push('correo');
    if (!validarTelefono(document.getElementById('telefono_numero'))) errores.push('telefono');
    if (!validarNombreApellido(document.getElementById('nombres'), 'nombreerror')) errores.push('nombres');
    if (!validarNombreApellido(document.getElementById('apellidos'), 'apellidoerror')) errores.push('apellidos');
    if (!validarFechaNacimiento()) errores.push('fecha_nac');
    if (!validarDireccion()) errores.push('direccion');
    if (!validarPrefijoTelefono(document.getElementById('telefono_prefijo'))) errores.push('telefono_prefijo');
    if (!validarSeleccion(document.getElementById('id_pnf'), 'id_pnferror')) errores.push('id_pnf');
    if (!validarSeleccion(document.getElementById('genero'), 'generoerror')) errores.push('genero');
    if (!validarSeleccion(document.getElementById('estatus'), 'estatuserror')) errores.push('estatus');
    return errores;
}