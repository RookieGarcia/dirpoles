let insumosSeleccionados = []; // Arreglo para almacenar los insumos seleccionados

function seleccionarInsumo(idInsumo, nombreInsumo, cantidadSeleccionada) {
    // Verificar si la cantidad es 0 o menor
    if (cantidadSeleccionada <= 0) {
        toastr.error("La cantidad seleccionada debe ser mayor que 0.");
        return; // Salir de la función si la cantidad no es válida
    }

    // Verificar si el insumo ya está en la lista
    const existe = insumosSeleccionados.some(insumo => insumo.id === idInsumo);
    if (existe) {
        toastr.error("Este insumo ya ha sido seleccionado.");
        return;
    }

    // Agregar insumo al arreglo
    insumosSeleccionados.push({
        id: idInsumo,
        nombre: nombreInsumo,
        cantidad: cantidadSeleccionada
    });

    // Actualizar la tabla de insumos seleccionados
    actualizarTablaInsumos();

    // Cerrar el modal
    $('#modalInsumo').modal('hide');
}


function actualizarTablaInsumos() {
    const tbody = document.getElementById('tablaInsumosSeleccionados');
    tbody.innerHTML = ''; // Limpiar tabla

    insumosSeleccionados.forEach((insumo, index) => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${insumo.nombre}</td>
            <td>${insumo.cantidad} unidades</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarInsumo(${index})" title="Eliminar insumo">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;
        tbody.appendChild(fila);
    });


    // Actualizar el input hidden para enviar al servidor
    document.getElementById('insumosInputHidden').value = JSON.stringify(insumosSeleccionados);
}

function eliminarInsumo(index) {
    // Eliminar insumo del arreglo
    insumosSeleccionados.splice(index, 1);

    // Actualizar la tabla
    actualizarTablaInsumos();
}

document.addEventListener('DOMContentLoaded', function() {
    // Evento para capturar el clic en el botón "Seleccionar" dentro del modal
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function() {
            // Obtener los datos del beneficiario seleccionado
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

            // Asignar los valores a los campos en el formulario principal
            document.getElementById('id_beneficiario').value = idBeneficiario;
            document.getElementById('nombre_beneficiario').value = nombreBeneficiario;

            // Limpiar mensaje de error en el campo beneficiario
            document.getElementById('nombre_beneficiarioerror').innerHTML = '';

            // Cerrar el modal
            $('#modalBeneficiario').modal('hide');
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Validación para el campo Estatura
    document.getElementById('estatura').addEventListener('input', function(event) {
        let input = event.target;
        let value = input.value;

        // Solo permite números y un punto decimal
        input.value = value.replace(/[^0-9\.]/g, '');

        // No permite empezar con un punto
        if (input.value.startsWith('.')) {
            input.value = input.value.substring(1); // Elimina el primer carácter si es un punto
        }

        // Permite solo un punto decimal
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.(?=.*\.)/g, '');
        }

        // Limita a dos decimales
        if (input.value.includes('.')) {
            let parts = input.value.split('.');
            if (parts[1].length > 2) {
                input.value = parts[0] + '.' + parts[1].substring(0, 2);
            }
        }

        // Validación del rango (0.00 a 3)
        if (parseFloat(input.value) > 3) {
            input.value = '3'; // Ajusta al máximo permitido
        } else if (parseFloat(input.value) < 0 && input.value !== '') {
            input.value = '0'; // Ajusta al mínimo permitido
        }
    });

    // Validación para el campo Peso
    document.getElementById('peso').addEventListener('input', function(event) {
        let input = event.target;
        let value = input.value;

        // Solo permite números y un punto decimal
        input.value = value.replace(/[^0-9\.]/g, '');

        // No permite empezar con un punto
        if (input.value.startsWith('.')) {
            input.value = input.value.substring(1); // Elimina el primer carácter si es un punto
        }

        // Permite solo un punto decimal
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.(?=.*\.)/g, '');
        }

        // Limita a dos decimales
        if (input.value.includes('.')) {
            let parts = input.value.split('.');
            if (parts[1].length > 2) {
                input.value = parts[0] + '.' + parts[1].substring(0, 2);
            }
        }

        // Validación del rango (0.00 a 300)
        if (parseFloat(input.value) > 300) {
            input.value = '300'; // Ajusta al máximo permitido
        } else if (parseFloat(input.value) < 0 && input.value !== '') {
            input.value = '0'; // Ajusta al mínimo permitido
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Función para validar todos los campos obligatorios
    function validarFormulario() {
        let esValido = true;

        // Limpiar los errores previos
        const errores = document.querySelectorAll('.text-danger');
        errores.forEach(function(error) {
            error.innerHTML = '';
        });

        // Validar cada campo
        const camposRequeridos = [{
                id: 'nombre_beneficiario',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'nombre_insumo',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'id_patologia',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'estatura',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'peso',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'tipo_sangre',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'motivo_visita',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'diagnostico',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'observaciones',
                mensaje: 'Este campo es obligatorio.'
            },
            {
                id: 'tratamiento',
                mensaje: 'Este campo es obligatorio.'
            }
        ];

        // Recorrer los campos y verificar si están vacíos
        camposRequeridos.forEach(function(campo) {
            const input = document.getElementById(campo.id);
            if (input) {
                // Verifica si el campo está vacío (para 'input' y 'select')
                if ((input.tagName === 'SELECT' && input.value === '') ||
                    (input.tagName !== 'SELECT' && input.value.trim() === '')) {
                    esValido = false;

                    // Comprobar si el div de error existe
                    const errorDiv = document.getElementById(campo.id + 'error');
                    if (errorDiv) {
                        errorDiv.innerHTML = campo.mensaje;
                    }
                }
            }
        });

        // Devolver el resultado de la validación
        return esValido;
    }

    // Capturamos el evento del botón de Registrar
    document.getElementById('btnRegistrar').addEventListener('click', function(event) {
        event.preventDefault(); // Previene el envío del formulario inmediatamente

        // Validar el formulario
        if (validarFormulario()) {
            // Si todo es válido, enviamos el formulario
            Swal.fire({
                title: '¿Crear consulta médica?',
                text: "Una vez creada la consulta, no podrás modificar el insumo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Registrar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true // Para invertir el orden de los botones
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si confirma, enviamos el formulario
                    document.getElementById('formularioConsultaMedica').submit();
                } else {
                    // Si cancela, no hacemos nada
                    console.log('Registro cancelado');
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Formulario incompleto!',
                text: 'Por favor complete todos los campos obligatorios.',
            });
        }
    });

    // Función para limpiar el formulario si el usuario cancela
    function limpiarFormulario() {
        document.getElementById('formularioConsultaMedica').reset(); // Resetea todos los campos del formulario

        // Limpiar los errores
        const errores = document.querySelectorAll('.text-danger');
        errores.forEach(function(error) {
            error.innerHTML = '';
        });
    }

    // Asignar el evento de limpiar el formulario al botón "Cancelar"
    document.getElementById('btnCancelar').addEventListener('click', limpiarFormulario);

    // Validación en tiempo real: cuando el usuario escribe en un campo
    const camposRequeridos = [
        'nombre_beneficiario',
        'nombre_insumo',
        'id_patologia',
        'estatura',
        'peso',
        'tipo_sangre',
        'motivo_visita',
        'diagnostico',
        'observaciones',
        'tratamiento'
    ];

    camposRequeridos.forEach(function(id) {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                const errorDiv = document.getElementById(id + 'error');
                // Para inputs de tipo texto o numérico
                if (input.tagName !== 'SELECT' && input.value.trim() !== '') {
                    if (errorDiv) {
                        errorDiv.innerHTML = ''; // Eliminar el mensaje de error si el campo no está vacío
                    }
                }
                // Para select
                else if (input.tagName === 'SELECT' && input.value !== '') {
                    if (errorDiv) {
                        errorDiv.innerHTML = ''; // Eliminar el mensaje de error si el campo no está vacío
                    }
                } else {
                    if (errorDiv) {
                        errorDiv.innerHTML = 'Este campo es obligatorio.'; // Mostrar el error si el campo está vacío
                    }
                }
            });
        }
    });
});


$(function() {
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

$(function() {
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


