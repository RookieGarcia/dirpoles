document.getElementById('formInsumo').addEventListener('submit', function(e) {
    const esDesbloqueo = document.querySelector('input[name="desbloquear"]') !== null;
    const fechaInput = document.getElementById('fecha_vencimiento');
    const hoy = new Date().toISOString().split('T')[0];

    if(esDesbloqueo) {
        const fechaSeleccionada = new Date(fechaInput.value);
        const manana = new Date();
        manana.setDate(manana.getDate() + 1);

        if(fechaSeleccionada <= new Date()) {
            e.preventDefault();
            document.getElementById('fecha_vencimientoerror').textContent = 
                'Debe seleccionar una fecha futura para reactivar';
            fechaInput.focus();
            return;
        }
    }
    
});

document.getElementById('formInsumo').addEventListener('submit', function(e) {
    const fechaInput = document.getElementById('fecha_vencimiento');
    const hoy = new Date().toISOString().split('T')[0];
    
    if(fechaInput.value <= hoy) {
        e.preventDefault();
        toastr.error('¡La fecha de vencimiento debe ser futura!');
        fechaInput.focus();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const fechaVencimientoInput = document.getElementById('fecha_vencimiento');
    const nombreInsumoInput = document.getElementById('nombre_insumo');
    const descripcionInput = document.getElementById('descripcion');

    fechaVencimientoInput.addEventListener('input', function() {
        const today = new Date();
        const todayString = today.toISOString().split('T')[0];
        const fechaVencimiento = fechaVencimientoInput.value;

        if (fechaVencimiento && fechaVencimiento < todayString) {
            document.getElementById('fecha_vencimientoerror').textContent = 'La fecha de vencimiento no puede ser anterior a la fecha actual';
        } else {
            document.getElementById('fecha_vencimientoerror').textContent = '';
        }
    });

    // Validación en tiempo real para el campo "Nombre Insumo" - Solo letras con acentos y espacios permitidos
    nombreInsumoInput.addEventListener('input', function() {
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;
        const valor = nombreInsumoInput.value;

        // Validar solo letras y espacios
        if (!regex.test(valor)) {
            nombreInsumoInput.value = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); // Elimina caracteres no permitidos
            document.getElementById('nombre_insumoerror').textContent = 'Solo se permiten letras y espacios';
        } else {
            document.getElementById('nombre_insumoerror').textContent = '';
        }
    });

    // Validación en tiempo real para el campo "Descripción"
    descripcionInput.addEventListener('input', function() {
        if (descripcionInput.value.trim() === '') {
            document.getElementById('descripcionerror').textContent = 'La descripción es obligatoria';
        } else {
            document.getElementById('descripcionerror').textContent = '';
        }
    });

    // Función de validación al momento de enviar el formulario
    document.getElementById('formInsumo').addEventListener('submit', function(e) {
        let formIsValid = true;

        // Obtener la fecha actual en cada submit
        const today = new Date();
        const todayString = today.toISOString().split('T')[0]; // Formato YYYY-MM-DD

        // Validación de cantidad
        const cantidad = document.getElementById('cantidad');
        if (!cantidad.value || isNaN(cantidad.value) || cantidad.value <= 0) {
            formIsValid = false;
            document.getElementById('cantidaderror').textContent = 'Debe ingresar una cantidad válida mayor a 0';
        }

        // Validación de fecha vencimiento
        const fechaVencimiento = fechaVencimientoInput.value;
        if (!fechaVencimiento || fechaVencimiento < todayString) {
            formIsValid = false;
            document.getElementById('fecha_vencimientoerror').textContent = 'La fecha de vencimiento no puede ser anterior a la fecha actual';
        }

        // Validación de nombre insumo
        const nombreInsumo = nombreInsumoInput.value;
        if (nombreInsumo.trim() === '') {
            formIsValid = false;
            document.getElementById('nombre_insumoerror').textContent = 'El nombre del insumo es obligatorio';
        }

        // Validación de descripción
        const descripcion = descripcionInput.value;
        if (descripcion.trim() === '') {
            formIsValid = false;
            document.getElementById('descripcionerror').textContent = 'La descripción es obligatoria';
        }

        // Forzar validaciones previas al submit
        fechaVencimientoInput.dispatchEvent(new Event('input'));
        nombreInsumoInput.dispatchEvent(new Event('input'));
        descripcionInput.dispatchEvent(new Event('input'));

        // Si alguna validación falla, se previene el envío del formulario
        if (!formIsValid) {
            e.preventDefault();
        }
    });
});