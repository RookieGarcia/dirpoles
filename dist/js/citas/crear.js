document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function() {
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

            document.getElementById('id_beneficiario').value = idBeneficiario;
            document.getElementById('nombre_beneficiario').value = nombreBeneficiario;

            document.getElementById('nombre_beneficiarioerror').innerHTML = '';

            $('#modalBeneficiario').modal('hide');
        });
    });
});

$(function () {
    var table = $('#tabla_empleados').DataTable({
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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function() {
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

            document.getElementById('id_beneficiario').value = idBeneficiario;
            document.getElementById('nombre_beneficiario').value = nombreBeneficiario;

            document.getElementById('nombre_beneficiarioerror').innerHTML = '';

            $('#modalBeneficiario').modal('hide');
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



document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('citaForm');
    let fechaValida = false;
    let empleadoDisponible = false;

    // Elementos de error
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

    // Validar disponibilidad al cambiar empleado, fecha u hora
    function validarDisponibilidad() {
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
            // Actualiza empleadoDisponible con TODAS las condiciones
            empleadoDisponible = data.horario_valido && !data.existe_misma_hora && !data.existe_intervalo;
            
            let mensaje = '';
            if (!data.horario_valido) {
                mensaje = 'El empleado no tiene disponibilidad en este horario';
            } else if (data.existe_misma_hora) {
                mensaje = 'Ya existe una cita registrada a esta hora exacta';
            } else if (data.existe_intervalo) {
                mensaje = 'El empleado ya tiene una cita programada 30 minutos antes/después';
            }
            
            horaError.textContent = mensaje;
        });
    }

    // Escuchar cambios en campos relevantes
    ['id_empleado', 'fecha', 'hora'].forEach(id => {
        document.getElementById(id).addEventListener('change', validarDisponibilidad);
    });

    // Validar antes de enviar
    form.addEventListener('submit', function(e) {
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