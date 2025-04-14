document.addEventListener('DOMContentLoaded', function() {
    // Función para limpiar los mensajes de error
    function limpiarError(campo) {
        const errorElement = document.getElementById(campo + '_error');
        if (errorElement) {
            errorElement.innerHTML = '';
        }
    }

    // Función de validación en tiempo real
    function validarCampo(campo) {
        let valido = true;

        // Validación del campo Beneficiario
        if (campo === 'id_beneficiario') {
            if (document.getElementById('id_beneficiario').value === '') {
                document.getElementById('id_beneficiario_error').innerText = 'Debe seleccionar un beneficiario.';
                valido = false;
            } else {
                limpiarError('id_beneficiario');
            }
        }

        // Validación del campo Motivo
        if (campo === 'motivo_orientacion') {
            if (document.getElementById('motivo_orientacion').value === '') {
                document.getElementById('motivo_orientacion_error').innerText = 'El motivo es obligatorio.';
                valido = false;
            } else {
                limpiarError('motivo_orientacion');
            }
        }

        // Validación de la Descripción
        if (campo === 'descripcion_orientacion') {
            if (document.getElementById('descripcion_orientacion').value === '') {
                document.getElementById('descripcion_orientacion_error').innerText = 'La descripción es obligatoria.';
                valido = false;
            } else {
                limpiarError('descripcion_orientacion');
            }
        }

        // Validación de las Indicaciones
        if (campo === 'indicaciones_orientacion') {
            if (document.getElementById('indicaciones_orientacion').value === '') {
                document.getElementById('indicaciones_orientacion_error').innerText = 'Las indicaciones son obligatorias.';
                valido = false;
            } else {
                limpiarError('indicaciones_orientacion');
            }
        }

        // Validación de Observaciones
        if (campo === 'obs_adic_orientacion') {
            if (document.getElementById('obs_adic_orientacion').value === '') {
                document.getElementById('obs_adic_orientacion_error').innerText = 'Las observaciones son obligatorias.';
                valido = false;
            } else {
                limpiarError('obs_adic_orientacion');
            }
        }

        return valido;
    }

    // Validación en tiempo real para los campos
    document.getElementById('id_beneficiario').addEventListener('input', function() {
        validarCampo('id_beneficiario');
    });

    document.getElementById('motivo_orientacion').addEventListener('input', function() {
        validarCampo('motivo_orientacion');
    });

    document.getElementById('descripcion_orientacion').addEventListener('input', function() {
        validarCampo('descripcion_orientacion');
    });

    document.getElementById('indicaciones_orientacion').addEventListener('input', function() {
        validarCampo('indicaciones_orientacion');
    });

    document.getElementById('obs_adic_orientacion').addEventListener('input', function() {
        validarCampo('obs_adic_orientacion');
    });

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
            limpiarError('id_beneficiario');

            // Cerrar el modal
            $('#modalBeneficiario').modal('hide');
        });
    });

    // Validación final al enviar el formulario
    document.getElementById('formularioConsultaOrientacion').addEventListener('submit', function(e) {
        let valid = true;

        // Validar cada campo
        ['id_beneficiario', 'motivo_orientacion', 'descripcion_orientacion', 'indicaciones_orientacion', 'obs_adic_orientacion'].forEach(campo => {
            if (!validarCampo(campo)) {
                valid = false;
            }
        });

        // Si algún campo es inválido, prevenir el envío del formulario
        if (!valid) {
            e.preventDefault();
        }
    });
});