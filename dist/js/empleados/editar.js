$(document).ready(function() {
    function toggleHorarioSection() {
        var selectedValue = $('#id_tipo_empleado').val();
        
        if (selectedValue == 1) { // Si el id_tipo_emp es igual a 1 (Psicólogo)
            $('#horarios_psicologo').show();
            $('#agregar_horario').show();
        } else {
            $('#horarios_psicologo').hide();
            $('#agregar_horario').hide();
        }
    }
    
    // Llamar a la función al cambiar el select
    $('#id_tipo_empleado').change(function() {
        toggleHorarioSection();
    });
    
    // Llamar a la función al cargar la página para verificar el valor inicial
    toggleHorarioSection();
});


document.addEventListener("DOMContentLoaded", function () {
    const horariosWrapper = document.getElementById("horarios_wrapper");
    const agregarHorarioBtn = document.getElementById("agregar_horario");
    const MAX_HORARIOS = 6; // Máximo de 6 horarios

    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    const idEmpleado = getUrlParameter('id_empleado');
    const diasSeleccionados = new Set();

    function validarHorario(horaInicio, horaFin) {
        const horaInicioDate = new Date(`1970-01-01T${horaInicio}:00`);
        const horaFinDate = new Date(`1970-01-01T${horaFin}:00`);
        const horaLimiteInferior = new Date('1970-01-01T07:00:00');
        const horaLimiteSuperior = new Date('1970-01-01T16:00:00');

        return horaInicioDate >= horaLimiteInferior && horaFinDate <= horaLimiteSuperior;
    }

    agregarHorarioBtn.addEventListener("click", function () {
        // Validar cantidad máxima
        if (horariosWrapper.children.length >= MAX_HORARIOS) {
            toastr.error('Máximo 6 días de horario permitidos');
            return;
        }

        const horarioHtml = `
        <form action="index.php?action=horario_agregar" method="post">
        <input type="hidden" name="id_empleado" value="${idEmpleado}">
            <div class="form-row align-items-center mb-2">
                <div class="col">
                    <label>Día</label>
                    <select name="dia_semana" class="form-control dia_semana" required>
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
                    <input type="time" name="hora_inicio" class="form-control hora_inicio" required>
                </div>
                <div class="col">
                    <label>Hora de Fin</label>
                    <input type="time" name="hora_fin" class="form-control hora_fin" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-sm mt-4 eliminar_horario">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button type="submit" class="btn btn-info btn-sm mt-4 agregar_horario">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>`;

        horariosWrapper.insertAdjacentHTML("beforeend", horarioHtml);
        const ultimoFormulario = horariosWrapper.lastElementChild;

        // Función para eliminar horario
        const eliminarBtn = ultimoFormulario.querySelector(".eliminar_horario");
        eliminarBtn.addEventListener("click", function () {
            const dia = ultimoFormulario.querySelector(".dia_semana").value;
            diasSeleccionados.delete(dia);
            ultimoFormulario.remove();
        });

        // Validación al enviar
        ultimoFormulario.addEventListener("submit", function (event) {
            const dia = ultimoFormulario.querySelector(".dia_semana").value;
            const horaInicio = ultimoFormulario.querySelector(".hora_inicio").value;
            const horaFin = ultimoFormulario.querySelector(".hora_fin").value;

            if (!validarHorario(horaInicio, horaFin)) {
                toastr.error('Horario debe ser entre 7:00 AM y 4:00 PM');
                event.preventDefault();
                return;
            }

            if (diasSeleccionados.has(dia)) {
                toastr.error('Este día ya fue agregado');
                event.preventDefault();
                return;
            }

            diasSeleccionados.add(dia);
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    // Manejadores de eventos de input para validación en tiempo real
    document.getElementById('nombre').addEventListener('input', function() {
        validarNombreApellido(this, 'nombreerror');
    });
    document.getElementById('apellido').addEventListener('input', function() {
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
    document.getElementById('clave').addEventListener('input', function() {
        validarClave();
    });
    document.getElementById('fecha_nacimiento').addEventListener('input', function() {
        validarFechaNacimiento(); // Llamada para validar en tiempo real
    });
    document.getElementById('direccion').addEventListener('input', function() {
        validarDireccion();
    });

    // Manejadores de eventos de cambio para los campos de selección (prefijo de teléfono, estatus, cargo)
    document.getElementById('telefono_prefijo').addEventListener('change', function() {
        validarPrefijoTelefono(this);
    });
    document.getElementById('id_tipo_empleado').addEventListener('change', function() {
        validarSeleccion(this, 'id_tipo_empleadoerror');
    });
    document.getElementById('estatus').addEventListener('change', function() {
        validarSeleccion(this, 'estatuserror');
    });

    // Manejador de evento para el botón de cancelar
    document.getElementById('btnCancelar').addEventListener('click', function() {
        form.reset();
        eliminarTodosErrores();
    });

    // Manejador de evento para el envío del formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar envío del formulario
        concatenarTelefono();  // Asegurarnos de concatenar el teléfono antes de enviar
        const errores = validarFormulario();
        if (errores.length > 0) {
            console.log("Errores encontrados:", errores);
        } else {
            form.submit();  // Enviar el formulario si no hay errores
        }
    });
});

// Función para eliminar el mensaje de error de un campo
function eliminarErrorDeCampo(errorId) {
    const errorElement = document.getElementById(errorId);
    if (errorElement) {
        errorElement.textContent = '';  // Limpiar el mensaje de error
    }
}

// Función para eliminar todos los errores cuando el formulario es reseteado
function eliminarTodosErrores() {
    const errorElements = document.querySelectorAll('.text-danger');
    errorElements.forEach(errorElement => {
        errorElement.textContent = ''; // Limpiar todos los mensajes de error
    });
}

// Función para validar el correo
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

// Función para validar la cédula
function validarCedula(input) {
    const cedulaError = document.getElementById('cedulaerror');
    input.value = input.value.replace(/[^0-9]/g, ''); // Asegurarse de que solo sean números

    if (input.value.length < 7 || input.value.length > 8) {
        cedulaError.textContent = 'Introduzca una cédula válida';
        return false;
    } else {
        cedulaError.textContent = ''; // Limpiar el mensaje de error si es válido
    }
    return true;
}

// Función para validar nombres y apellidos (sin números ni símbolos)
function validarNombreApellido(input, errorId) {
    const errorElement = document.getElementById(errorId);
    errorElement.textContent = '';  // Limpiar el mensaje de error

    // Validación de campo vacío
    if (input.value.trim() === '') {
        errorElement.textContent = 'Este campo es obligatorio.';
        return false;
    }

    // Validación de que solo contenga letras y espacios
    input.value = input.value.replace(/[^A-Za-zÀ-ÿ\s]/g, ''); // Permitir solo letras y espacios
    if (/[^A-Za-zÀ-ÿ\s]/.test(input.value)) {
        errorElement.textContent = 'Solo se permiten letras y espacios.';
        return false;
    }
    return true;
}

// Función para validar la clave
function validarClave() {
    const clave = document.getElementById('clave');
    const claveError = document.getElementById('claveerror');
    const claveRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8}$/;

    claveError.textContent = '';  // Limpiar el mensaje de error
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

document.addEventListener('DOMContentLoaded', function() {
    // Cargar el prefijo y el número al cargar la página
    const telefonoCompleto = "<?php echo htmlspecialchars($empleado['telefono']); ?>";
    
    if (telefonoCompleto.length === 11) {
        const prefijo = telefonoCompleto.substring(0, 4);  // Los primeros 4 dígitos
        const numero = telefonoCompleto.substring(4);       // Los siguientes 7 dígitos
        
        document.getElementById('telefono_prefijo').value = prefijo;
        document.getElementById('telefono_numero').value = numero;
    }
});

// Función para validar la fecha de nacimiento
function validarFechaNacimiento() {
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    const fechaNacimientoError = document.getElementById('fechaNacimientoError');

    fechaNacimientoError.textContent = ''; // Limpiar el mensaje de error

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
        fechaNacimientoError.textContent = 'Debe registrar una persona de 15 años.';
        return false;
    }
    return true;
}

// Función para validar la dirección
function validarDireccion() {
    const direccionInput = document.getElementById('direccion');
    const direccionError = document.getElementById('direccionerror');

    direccionError.textContent = '';  // Limpiar el mensaje de error
    if (direccionInput.value.trim() === '') {
        direccionError.textContent = 'La dirección es obligatoria.';
        return false;
    }
    return true;
}

// Función para validar el prefijo del teléfono
function validarPrefijoTelefono(input) {
    const prefijoError = document.getElementById('telefono_prefijoerror');
    
    prefijoError.textContent = ''; // Limpiar mensaje de error
    if (input.value === '') {
        prefijoError.textContent = 'Este campo es obligatorio.';
        return false;
    }
    return true;
}

// Función para validar campos de selección (estatus y cargo)
function validarSeleccion(input, errorId) {
    const errorElement = document.getElementById(errorId);
    errorElement.textContent = '';  // Limpiar el mensaje de error

    if (input.value === '' || input.selectedIndex === 0) {  // Si no se ha seleccionado una opción válida
        errorElement.textContent = 'Este campo es obligatorio.';
        return false;
    }
    return true;
}

// Función para validar el formulario completo
function validarFormulario() {
    const errores = [];
    if (!validarCorreo(document.getElementById('correo'))) errores.push('correo');
    if (!validarTelefono(document.getElementById('telefono_numero'))) errores.push('telefono');
    if (!validarNombreApellido(document.getElementById('nombre'), 'nombreerror')) errores.push('nombre');
    if (!validarNombreApellido(document.getElementById('apellido'), 'apellidoerror')) errores.push('apellido');
    if (!validarCedula(document.getElementById('cedula'))) errores.push('cedula');
    if (!validarClave()) errores.push('clave');
    if (!validarFechaNacimiento()) errores.push('fecha_nacimiento');
    if (!validarDireccion()) errores.push('direccion');
    if (!validarPrefijoTelefono(document.getElementById('telefono_prefijo'))) errores.push('telefono_prefijo');
    if (!validarSeleccion(document.getElementById('id_tipo_empleado'), 'id_tipo_empleadoerror')) errores.push('id_tipo_empleado');
    if (!validarSeleccion(document.getElementById('estatus'), 'estatuserror')) errores.push('estatus');

    return errores;
}