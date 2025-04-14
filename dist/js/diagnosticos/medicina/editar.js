document.addEventListener("DOMContentLoaded", function() {
    // Función para validar si un campo está vacío y mostrar el mensaje de error
    function validarCampo(campo, mensajeError) {
        const errorDiv = campo.parentElement.querySelector('.text-danger');
        if (campo.value.trim() === "") {
            if (errorDiv) {
                errorDiv.innerHTML = mensajeError;
            }
            return false;
        } else {
            if (errorDiv) {
                errorDiv.innerHTML = "";
            }
            return true;
        }
    }

    // Validación específica para estatura y peso
    function validarEstaturaYPeso(input, maxValor) {
        // Permitir solo números y un punto decimal
        input.value = input.value.replace(/[^0-9\.]/g, '');

        // No permitir empezar con un punto
        if (input.value.startsWith('.')) {
            input.value = input.value.substring(1);
        }

        // Permitir solo un punto decimal
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.(?=.*\.)/g, '');
        }

        // Limitar a dos decimales
        if (input.value.includes('.')) {
            let parts = input.value.split('.');
            if (parts[1].length > 2) {
                input.value = parts[0] + '.' + parts[1].substring(0, 2);
            }
        }

        // Validar rango (0.00 a maxValor)
        const value = parseFloat(input.value);
        if (value > maxValor) {
            input.value = maxValor.toFixed(2); // Ajustar al máximo permitido
        } else if (value < 0 && input.value !== "") {
            input.value = "0.00"; // Ajustar al mínimo permitido
        }
    }

    // Obtener los campos de estatura y peso
    const estatura = document.querySelector('[name="estatura"]');
    const peso = document.querySelector('[name="peso"]');

    // Validar estatura en tiempo real
    estatura.addEventListener('input', function() {
        validarEstaturaYPeso(estatura, 3);
        validarCampo(estatura, "Este campo es obligatorio.");
    });

    // Validar peso en tiempo real
    peso.addEventListener('input', function() {
        validarEstaturaYPeso(peso, 300);
        validarCampo(peso, "Este campo es obligatorio.");
    });

    // Validación de otros campos del formulario
    const formulario = document.getElementById('formularioConsultaMedica');
    const nombreBeneficiario = document.getElementById('nombre_beneficiario');
    const idPatologia = document.querySelector('[name="id_patologia"]');
    const motivoVisita = document.querySelector('[name="motivo_visita"]');
    const diagnostico = document.querySelector('[name="diagnostico"]');
    const tratamiento = document.querySelector('[name="tratamiento"]');

    // Validación en tiempo real
    nombreBeneficiario.addEventListener('input', function() {
        validarCampo(nombreBeneficiario, "Este campo es obligatorio.");
    });

    idPatologia.addEventListener('input', function() {
        validarCampo(idPatologia, "Este campo es obligatorio.");
    });

    motivoVisita.addEventListener('input', function() {
        validarCampo(motivoVisita, "Este campo es obligatorio.");
    });

    diagnostico.addEventListener('input', function() {
        validarCampo(diagnostico, "Este campo es obligatorio.");
    });

    tratamiento.addEventListener('input', function() {
        validarCampo(tratamiento, "Este campo es obligatorio.");
    });

    // Validar todos los campos al enviar el formulario
    formulario.addEventListener('submit', function(event) {
        let valid = true;

        if (!validarCampo(nombreBeneficiario, "Este campo es obligatorio.")) valid = false;
        if (!validarCampo(idPatologia, "Este campo es obligatorio.") || idPatologia.value === "") valid = false;
        if (!validarCampo(estatura, "Este campo es obligatorio.") || estatura.value.trim() === "") valid = false;
        if (!validarCampo(peso, "Este campo es obligatorio.") || peso.value.trim() === "") valid = false;
        if (!validarCampo(motivoVisita, "Este campo es obligatorio.")) valid = false;
        if (!validarCampo(diagnostico, "Este campo es obligatorio.")) valid = false;
        if (!validarCampo(tratamiento, "Este campo es obligatorio.")) valid = false;

        // Si algún campo no es válido, evitar el envío del formulario
        if (!valid) {
            event.preventDefault();
            alert("Por favor, complete todos los campos obligatorios.");
        }
    });

    // Evento para capturar el clic en el botón "Seleccionar" dentro del modal
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir comportamiento por defecto del botón

            // Obtener los datos del beneficiario seleccionado
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

            // Asignar los valores a los campos en el formulario principal
            document.getElementById('id_beneficiario').value = idBeneficiario;
            document.getElementById('nombre_beneficiario').value = nombreBeneficiario;

            // Cerrar el modal
            $('#modalBeneficiario').modal('hide');
        });
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

    $(function () {
    var table = $('#tabla_inventario').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "language": {
            "sEmptyTable": "No hay registros de Insumos disponibles",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Insumos",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 Insumos",
            "sInfoFiltered": "(filtrado de _MAX_ Insumos totales)",
            "sLengthMenu": "Mostrar _MENU_ Insumos",
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