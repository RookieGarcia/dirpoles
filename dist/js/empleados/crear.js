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
        xhr.open("POST", "index.php?action=validar_cedula_emp", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send("tipo_cedula=" + encodeURIComponent(tipoCedula) + "&cedula=" + encodeURIComponent(cedula));

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

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    document.getElementById('nombre').addEventListener('input', function() {
        validarNombreApellido(this, 'nombreerror');
    });
    document.getElementById('apellido').addEventListener('input', function() {
        validarNombreApellido(this, 'apellidoerror');
    });
    document.getElementById('correo').addEventListener('input', function() {
        validarCorreo(this);
    });
    document.getElementById('telefono_numero').addEventListener('input', function() {
        validarTelefono(this);
    });
    document.getElementById('clave').addEventListener('input', function() {
        validarClave();
    });
    document.getElementById('fecha_nacimiento').addEventListener('input', function() {
        validarFechaNacimiento();
    });
    document.getElementById('direccion').addEventListener('input', function() {
        validarDireccion();
    });
    document.getElementById('telefono_prefijo').addEventListener('change', function() {
        validarPrefijoTelefono(this);
    });
    document.getElementById('id_tipo_empleado').addEventListener('change', function() {
        validarSeleccion(this, 'id_tipo_empleadoerror');
        toggleHorariosPsicologo();
    });
    document.getElementById('estatus').addEventListener('change', function() {
        validarSeleccion(this, 'estatuserror');
    });

    const horariosWrapper = document.getElementById('horarios_wrapper');
    horariosWrapper.addEventListener('input', function() {
        if (validarHorariosPsicologo()) {
            document.getElementById('horarioerror').textContent = '';
        }
    });

    document.getElementById('btnCancelar').addEventListener('click', function() {
        form.reset();
        eliminarTodosErrores();
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
        xhr.open("POST", "index.php?action=validar_telefono_emp", true);
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

function validarClave() {
    const clave = document.getElementById('clave');
    const claveError = document.getElementById('claveerror');
    const claveRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8}$/;

    claveError.textContent = '';
    if (clave.value === "") {
        claveError.textContent = 'Por favor, ingrese una clave.';
        return false;
    }
    if (!claveRegex.test(clave.value)) {
        claveError.textContent = 'La clave debe tener exactamente 8 caracteres, incluyendo al menos una letra y un número.';
        return false;
    }
    return true;
}

function validarFechaNacimiento() {
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    const fechaNacimientoError = document.getElementById('fechaNacimientoError');

    fechaNacimientoError.textContent = '';
    if (!fechaNacimientoInput.value) {
        fechaNacimientoError.textContent = 'La fecha de nacimiento es obligatoria.';
        return false;
    }

    const fechaNacimiento = new Date(fechaNacimientoInput.value);
    const hoy = new Date();
    const edadMinima = 15;

    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }

    if (edad < edadMinima) {
        fechaNacimientoError.textContent = 'Debe registrar una persona mayor de 15 años).';
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

function validarHorariosPsicologo() {
    const tipoEmpleado = document.getElementById('id_tipo_empleado').value;
    const horariosWrapper = document.getElementById('horarios_wrapper');
    const horarioError = document.getElementById('horarioerror');

    if (tipoEmpleado === "1") {
        if (horariosWrapper.children.length === 0) {
            horarioError.textContent = 'Debe agregar al menos un horario para el psicólogo.';
            return false;
        }
    }
    return true;
}

function validarFormulario() {
    const errores = [];
    if (!validarCorreo(document.getElementById('correo'))) errores.push('correo');
    if (!validarTelefono(document.getElementById('telefono_numero'))) errores.push('telefono');
    if (!validarNombreApellido(document.getElementById('nombre'), 'nombreerror')) errores.push('nombre');
    if (!validarNombreApellido(document.getElementById('apellido'), 'apellidoerror')) errores.push('apellido');
    if (!validarClave()) errores.push('clave');
    if (!validarFechaNacimiento()) errores.push('fecha_nacimiento');
    if (!validarDireccion()) errores.push('direccion');
    if (!validarPrefijoTelefono(document.getElementById('telefono_prefijo'))) errores.push('telefono_prefijo');
    if (!validarSeleccion(document.getElementById('id_tipo_empleado'), 'id_tipo_empleadoerror')) errores.push('id_tipo_empleado');
    if (!validarSeleccion(document.getElementById('estatus'), 'estatuserror')) errores.push('estatus');
    if (!validarHorariosPsicologo()) errores.push('horarios');

    return errores;
}

function toggleHorariosPsicologo() {
    const tipoEmpleado = document.getElementById('id_tipo_empleado').value;
    const horariosSection = document.getElementById('horarios_section');

    if (tipoEmpleado === "1") {
        horariosSection.style.display = 'block';
    } else {
        horariosSection.style.display = 'none';
    }
}


document.addEventListener("DOMContentLoaded", function() {
    const tipoEmpleadoSelect = document.getElementById("id_tipo_empleado");
    const horariosWrapper = document.getElementById("horarios_wrapper");
    const horariosPsicologo = document.getElementById("horarios_psicologo");
    const agregarHorarioBtn = document.getElementById("agregar_horario");

    tipoEmpleadoSelect.addEventListener("change", function() {
        if (this.value === "1") {
            horariosPsicologo.style.display = "block";
        } else {
            horariosPsicologo.style.display = "none";
            horariosWrapper.innerHTML = "";
        }
    });

    agregarHorarioBtn.addEventListener("click", function() {
        const horarioHtml = `
    <div class="form-row align-items-center mb-2">
        <div class="col">
            <label>Día</label>
            <select name="dia_semana[]" class="form-control" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
            </select>
        </div>
        <div class="col">
            <label>Hora de Inicio</label>
            <input type="time" name="hora_inicio[]" class="form-control" id="hora_inicio">
            <div id="hora_inicio_error" class="text-danger"></div>
        </div>
        <div class="col">
            <label>Hora de Fin</label>
            <input type="time" name="hora_fin[]" class="form-control" id="hora_fin">
            <div id="hora_fin_error" class="text-danger"></div>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger btn-sm mt-4 eliminar_horario">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>`;
        horariosWrapper.insertAdjacentHTML("beforeend", horarioHtml);

        horariosWrapper.querySelectorAll(".eliminar_horario").forEach(function(btn) {
            btn.addEventListener("click", function() {
                btn.closest(".form-row").remove();
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('#formulario-empleado');

    formulario.addEventListener('submit', function(event) {
        const horasInicio = document.querySelectorAll('input[name="hora_inicio[]"]');
        const horasFin = document.querySelectorAll('input[name="hora_fin[]"]');

        for (let i = 0; i < horasInicio.length; i++) {
            const horaInicio = new Date(`1970-01-01T${horasInicio[i].value}:00`);
            const horaFin = new Date(`1970-01-01T${horasFin[i].value}:00`);

            if (horaInicio < new Date('1970-01-01T07:00:00') || horaFin > new Date('1970-01-01T16:00:00')) {
                toastr.error('El horario debe estar entre las 7:00 AM y las 4:00 PM.');
                event.preventDefault();
                return;
            }
        }
    });
});