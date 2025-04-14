document.addEventListener('DOMContentLoaded', function() {
    // Función para limpiar los mensajes de error
    function limpiarError(campo) {
        const errorElement = document.getElementById(campo + '_error');
        if (errorElement) {
            errorElement.textContent = ''; // Limpiar el mensaje de error
        }
        const inputElement = document.getElementById(campo);
        if (inputElement) {
            inputElement.classList.remove('is-invalid'); // Quitar clase de error
        }
    }

    // Función para mostrar el mensaje de error
    function mostrarError(campo, mensaje) {
        const errorElement = document.getElementById(campo + '_error');
        if (errorElement) {
            errorElement.textContent = mensaje;
        }
        const inputElement = document.getElementById(campo);
        if (inputElement) {
            inputElement.classList.add('is-invalid'); // Añadir clase de error
        }
    }

    // Validar los campos del formulario
    function validarFormulario() {
        let esValido = true;

        // Validar Beneficiario
        const idBeneficiario = document.getElementById('id_beneficiario').value.trim();
        if (idBeneficiario === '') {
            mostrarError('id_beneficiario', 'El beneficiario es obligatorio.');
            esValido = false;
        } else {
            limpiarError('id_beneficiario');
        }

        // Validar Motivo de Orientación
        const motivoOrientacion = document.getElementById('motivo_orientacion').value.trim();
        if (motivoOrientacion === '') {
            mostrarError('motivo_orientacion', 'El motivo es obligatorio.');
            esValido = false;
        } else {
            limpiarError('motivo_orientacion');
        }

        // Validar Descripción
        const descripcionOrientacion = document.getElementById('descripcion_orientacion').value.trim();
        if (descripcionOrientacion === '') {
            mostrarError('descripcion_orientacion', 'La descripción es obligatoria.');
            esValido = false;
        } else {
            limpiarError('descripcion_orientacion');
        }

        // Validar Tratamiento (Indicaciones)
        const indicacionesOrientacion = document.getElementById('indicaciones_orientacion').value.trim();
        if (indicacionesOrientacion === '') {
            mostrarError('indicaciones_orientacion', 'El tratamiento es obligatorio.');
            esValido = false;
        } else {
            limpiarError('indicaciones_orientacion');
        }

        // Validar Observaciones
        const obsAdicOrientacion = document.getElementById('obs_adic_orientacion').value.trim();
        if (obsAdicOrientacion === '') {
            mostrarError('obs_adic_orientacion', 'Las observaciones son obligatorias.');
            esValido = false;
        } else {
            limpiarError('obs_adic_orientacion');
        }

        return esValido;
    }

    // Asociar la validación al enviar el formulario
    document.getElementById('formularioConsultaOrientacion').addEventListener('submit', function(event) {
        // Prevenir el envío del formulario si hay errores
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });

    // Validación en tiempo real (cuando el usuario empieza a escribir)
    const camposValidacion = [
        'id_beneficiario', 
        'motivo_orientacion', 
        'descripcion_orientacion', 
        'indicaciones_orientacion', 
        'obs_adic_orientacion'
    ];

    camposValidacion.forEach(function(campo) {
        document.getElementById(campo).addEventListener('input', function() {
            limpiarError(campo); // Limpiar el error cuando el usuario empieza a escribir
        });
    });

    // Evento para seleccionar un beneficiario
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function() {
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');
            
            // Asignar los valores al formulario
            document.getElementById('id_beneficiario').value = idBeneficiario;
            document.getElementById('nombre_beneficiario').value = nombreBeneficiario;
            
            // Limpiar cualquier error
            limpiarError('id_beneficiario');
            
            // Cerrar el modal
            $('#modalBeneficiario').modal('hide');
        });
    });
});