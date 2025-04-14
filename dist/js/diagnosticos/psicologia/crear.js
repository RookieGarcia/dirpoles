document.getElementById("btnAction").addEventListener("click", function() { window.location.href = "index.php?action=psicologia_listar"; }); 

$(document).ready(function() {
    // Mostrar el formulario correspondiente al hacer clic en los botones
    $('#btnDiagnosticoGeneral').click(function() {
        $('.form-section').hide();
        $('#formDiagnosticoGeneral').show();
    });

    $('#btnCambioCarrera').click(function() {
        $('.form-section').hide();
        $('#formCambioCarrera').show();
    });

    $('#btnRetiroTemporal').click(function() {
        $('.form-section').hide();
        $('#formRetiroTemporal').show();
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Evento para capturar el clic en el botón "Seleccionar" dentro del modal
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function() {
            // Obtener los datos del beneficiario seleccionado
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');
            const cedulaBeneficiario = this.getAttribute('data-cedula');
            const pnfBeneficiario = this.getAttribute('data-pnf');

            // Actualizar los campos correspondientes
            // Para id_beneficiario_cita (formulario de citas)
            if (document.getElementById('id_beneficiario_cita')) {
                document.getElementById('id_beneficiario_cita').value = idBeneficiario;
                document.getElementById('nombre_beneficiario_cita').value = nombreBeneficiario + ' - ' + cedulaBeneficiario + ' - ' + pnfBeneficiario;
            }

            // Para id_beneficiario_cambio (formulario de cambio de carrera)
            if (document.getElementById('id_beneficiario_cambio')) {
                document.getElementById('id_beneficiario_cambio').value = idBeneficiario;
                document.getElementById('nombre_beneficiario_cambio').value = nombreBeneficiario + ' - ' + cedulaBeneficiario + ' - ' + pnfBeneficiario;
            }

            // Para id_beneficiario_retiro (formulario de retiro temporal)
            if (document.getElementById('id_beneficiario_retiro')) {
                document.getElementById('id_beneficiario_retiro').value = idBeneficiario;
                document.getElementById('nombre_beneficiario_retiro').value = nombreBeneficiario + ' - ' + cedulaBeneficiario + ' - ' + pnfBeneficiario;
            }

            // Cerrar el modal de beneficiarios
            $('#modalBeneficiario').modal('hide');
        });
    });
});

document.getElementById('guardar_cita').addEventListener('click', function() {
    // Obtener los valores de los inputs de fecha y hora
    var fecha = document.getElementById('fecha').value;
    var hora = document.getElementById('hora').value;
    var id_empleado = document.getElementById('id_empleado').value;
    
    // Asignar los valores a los inputs hidden
    document.getElementById('hidden_fecha').value = fecha;
    document.getElementById('hidden_hora').value = hora;
    document.getElementById('hidden_id_empleado').value = id_empleado;
    
    // Asignar los valores a los inputs text deshabilitados
    document.getElementById('text_fecha').value = 'Fecha: ' + fecha;
    document.getElementById('text_hora').value = 'Hora: ' + hora;

    // Mostrar un mensaje de éxito o realizar otra acción necesaria
    $('#modalCita').modal('hide');
});

// Añadir los inputs hidden y text deshabilitados en el HTML



$(function () {
    var table = $('#tabla_beneficiarios').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "language": {
            "sEmptyTable": "No hay registros de beneficiarios disponibles",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ beneficiarios",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 beneficiarios",
            "sInfoFiltered": "(filtrado de _MAX_ beneficiarios totales)",
            "sLengthMenu": "Mostrar _MENU_ beneficiarios",
            "sLoadingRecords": "Cargando...",
            "sProcessing": "Procesando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "No se encontraron resultados",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-select-empleado');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const idEmpleado = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const apellido = this.getAttribute('data-apellido');
            const cedula = this.getAttribute('data-cedula');

            document.getElementById('id_empleado').value = idEmpleado;
            document.getElementById('nombre_empleado').value = `${nombre} ${apellido} - ${cedula}`;
            document.getElementById('nombre_empleadoerror').innerHTML = '';

            $('#modalEmpleado').modal('hide');
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.querySelector('#fecha');
    const hoy = new Date();
    const year = hoy.getFullYear();
    const month = String(hoy.getMonth() + 1).padStart(2, '0');
    const day = String(hoy.getDate()).padStart(2, '0');
    const fechaHoy = `${year}-${month}-${day}`;
    fechaInput.setAttribute('min', fechaHoy);
});

$(document).ready(function() {
    // Función para la validación del formulario de Diagnóstico General
    $("#formDiagnosticoGeneral form").submit(function(event) {
        let valid = true;
        let errorMessage = "Por favor complete todos los campos requeridos en el Diagnóstico General.";
        
        // Validar campos de tipo texto y <select>
        $(this).find(".form-control, .custom-select").each(function() {
            // Excluir campos opcionales de la validación
            if ($(this).hasClass('optional')) {
                $(this).removeClass("is-invalid");
                return true; // Saltar a la siguiente iteración
            }
            
            if ($(this).is('select') && $(this).val() === "") {
                $(this).addClass("is-invalid");  // Agregar borde rojo si no se ha seleccionado opción válida
                valid = false;
            } else if ($(this).val() === "") {
                $(this).addClass("is-invalid");  // Agregar borde rojo si el campo de texto está vacío
                valid = false;
            } else {
                $(this).removeClass("is-invalid");  // Quitar borde rojo si el campo tiene valor
            }
        });

        // Si hay errores, mostrar mensaje de alerta
        if (!valid) {
            alert(errorMessage);
            event.preventDefault(); // No enviar el formulario
        }
    });


    // Función para la validación del formulario de Cambio de Carrera
    $("#formCambioCarrera form").submit(function(event) {
        let valid = true;
        let errorMessage = "Por favor complete todos los campos requeridos en el Cambio de Carrera.";
        
        // Validar campos de tipo texto y <select>
        $(this).find(".form-control, .custom-select").each(function() {
            if ($(this).is('select') && $(this).val() === "") {
                $(this).addClass("is-invalid");  // Agregar borde rojo si no se ha seleccionado opción válida
                valid = false;
            } else if ($(this).val() === "") {
                $(this).addClass("is-invalid");  // Agregar borde rojo si el campo de texto está vacío
                valid = false;
            } else {
                $(this).removeClass("is-invalid");  // Quitar borde rojo si el campo tiene valor
            }
        });

        // Si hay errores, mostrar mensaje de alerta
        if (!valid) {
            alert(errorMessage);
            event.preventDefault(); // No enviar el formulario
        }
    });

    // Función para la validación del formulario de Retiro Temporal
    $("#formRetiroTemporal form").submit(function(event) {
        let valid = true;
        let errorMessage = "Por favor complete todos los campos requeridos en el Retiro Temporal.";
        
        // Validar campos de tipo texto y <select>
        $(this).find(".form-control, .custom-select").each(function() {
            if ($(this).is('select') && $(this).val() === "") {
                $(this).addClass("is-invalid");  // Agregar borde rojo si no se ha seleccionado opción válida
                valid = false;
            } else if ($(this).val() === "") {
                $(this).addClass("is-invalid");  // Agregar borde rojo si el campo de texto está vacío
                valid = false;
            } else {
                $(this).removeClass("is-invalid");  // Quitar borde rojo si el campo tiene valor
            }
        });

        // Si hay errores, mostrar mensaje de alerta
        if (!valid) {
            alert(errorMessage);
            event.preventDefault(); // No enviar el formulario
        }
    });

    // Eliminar la clase de borde rojo cuando el usuario empieza a escribir en los campos
    $(".form-control, .custom-select").on("input change", function() {
        if ($(this).val() !== "" && $(this).val() !== null) {
            $(this).removeClass("is-invalid");
        }
    });
});


//Validar en tiempo real las citas para la consulta psicológica

document.addEventListener('DOMContentLoaded', function() {
    const formPsicologia = document.getElementById('formDiagnosticoGeneral'); // Asegúrate de que el formulario tenga este ID
    let fechaValida = false;
    let empleadoDisponible = false;

    // Elementos de error (ajusta los IDs según tu HTML)
    const fechaError = document.getElementById('fechaError');
    const empleadoError = document.getElementById('nombre_empleadoerror');
    const horaError = document.getElementById('horaError');

    // Validar fecha
    document.getElementById('fecha').addEventListener('change', function() {
        const fecha = this.value;
        
        fetch('index.php?action=validar_fecha_cita', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `fecha=${encodeURIComponent(fecha)}`
        })
        .then(response => response.json())
        .then(data => {
            fechaValida = data.valido;
            fechaError.textContent = data.valido ? '' : 'No se permiten fechas pasadas';
        });
    });

    // Validar disponibilidad
    function validarDisponibilidadPsicologo() {
        const idEmpleado = document.getElementById('id_empleado').value;
        const fecha = document.getElementById('fecha').value;
        const hora = document.getElementById('hora').value;

        if (!idEmpleado || !fecha || !hora) return;

        fetch('index.php?action=validar_disponibilidad_empleado', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id_empleado=${idEmpleado}&fecha=${fecha}&hora=${hora}`
        })
        .then(response => response.json())
        .then(data => {
            let mensaje = '';
            if (!data.horario_valido) {
                mensaje = 'El psicólogo no tiene disponibilidad en este horario';
            } else if (data.existe_misma_hora) {
                mensaje = 'Ya existe una cita a esta hora exacta';
            } else if (data.existe_intervalo) {
                mensaje = 'Ya hay una cita programada 30 minutos antes/después';
            }
            
            empleadoError.textContent = mensaje;
            empleadoDisponible = data.horario_valido && !data.existe_misma_hora && !data.existe_intervalo;
        });
    }

    // Escuchar cambios en campos
    ['id_empleado', 'fecha', 'hora'].forEach(id => {
        document.getElementById(id).addEventListener('change', validarDisponibilidadPsicologo);
    });

    // Validar antes de enviar
    formPsicologia.addEventListener('submit', function(e) {
        let puedeEnviar = true;

        if (!fechaValida) {
            fechaError.textContent = 'Verifique la fecha';
            puedeEnviar = false;
        }

        if (!empleadoDisponible) {
            empleadoError.textContent = 'Verifique disponibilidad';
            puedeEnviar = false;
        }

        if (!puedeEnviar) {
            e.preventDefault();
            toastr.error('Corrija los errores antes de enviar');
        }
    });
});
