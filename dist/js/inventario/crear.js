document.addEventListener("DOMContentLoaded", function() {
    // Establecer la fecha mínima (no se puede elegir una fecha pasada)
    const fechaVencimientoInput = document.getElementById('fecha_vencimiento');
    const today = new Date(); // Obtener la fecha actual
    const todayString = today.toISOString().split('T')[0]; // Formato YYYY-MM-DD
    
    // Validación en tiempo real de la fecha de vencimiento
    fechaVencimientoInput.addEventListener('input', function() {
        const fechaVencimiento = fechaVencimientoInput.value;

        // Si la fecha es anterior a la fecha actual
        if (fechaVencimiento && fechaVencimiento < todayString) {
            document.getElementById('fecha_vencimientoerror').textContent = 'La fecha de vencimiento no puede ser anterior a la fecha actual';
        } else {
            // Si la fecha es válida, eliminar el mensaje de error
            document.getElementById('fecha_vencimientoerror').textContent = '';
        }
    });

    // Validación para el campo "Nombre Insumo" - Solo letras con acentos y espacios permitidos
    const nombreInsumoInput = document.getElementById("nombre_insumo");
    nombreInsumoInput.addEventListener("input", function(e) {
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]*$/; // Solo letras (con acentos) y espacios
        if (!regex.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚ\s]/g, '');
        }
        
        // Eliminar mensaje de error si el campo es válido
        if (e.target.value.trim()) {
            document.getElementById('nombre_insumoerror').textContent = ''; // Elimina el error
        }
    });

    /*// Validación para el campo "Cantidad" - Solo números permitidos
    const cantidadInput = document.getElementById("cantidad");
    cantidadInput.addEventListener("input", function(e) {
        const regex = /^[0-9]*$/; // Solo números
        if (!regex.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        }

        // Eliminar mensaje de error si el campo es válido
        if (e.target.value.trim() && e.target.value > 0) {
            document.getElementById('cantidaderror').textContent = ''; // Elimina el error
        }
    });*/

    // Validación en tiempo real para "Presentación"
    const presentacionInput = document.getElementById("id_presentacion");
    presentacionInput.addEventListener("change", function() {
        // Si hay una opción seleccionada, eliminamos el mensaje de error
        if (presentacionInput.value.trim()) {
            document.getElementById('id_presentacionerror').textContent = ''; // Elimina el error
        }
    });

    // Validación en tiempo real para "Tipo de Insumo"
    const tipoInsumoInput = document.getElementById("tipo_insumo");
    tipoInsumoInput.addEventListener("change", function() {
        // Si hay una opción seleccionada, eliminamos el mensaje de error
        if (tipoInsumoInput.value.trim()) {
            document.getElementById('tipo_insumoerror').textContent = ''; // Elimina el error
        }
    });

    // Validación en tiempo real para "Descripción"
    const descripcionInput = document.getElementById("descripcion");
    descripcionInput.addEventListener("input", function() {
        // Si la descripción tiene texto, eliminamos el mensaje de error
        if (descripcionInput.value.trim()) {
            document.getElementById('descripcionerror').textContent = ''; // Elimina el error
        }
    });

    // Validación de campos al enviar el formulario
    const form = document.getElementById("formInsumo");
    
    form.addEventListener('submit', function(event) {
        let valid = true;
        
        // Limpiar mensajes de error anteriores
        document.querySelectorAll('.text-danger').forEach(function(errorDiv) {
            errorDiv.textContent = '';
        });

        // Validación para "Nombre Insumo"
        if (!nombreInsumoInput.value.trim()) {
            valid = false;
            document.getElementById('nombre_insumoerror').textContent = 'Este campo es obligatorio';
        }

        // Validación para "Presentación"
        if (!presentacionInput.value.trim()) {
            valid = false;
            document.getElementById('id_presentacionerror').textContent = 'Este campo es obligatorio';
        }

        // Validación para "Tipo Insumo"
        if (!tipoInsumoInput.value.trim()) {
            valid = false;
            document.getElementById('tipo_insumoerror').textContent = 'Este campo es obligatorio';
        }

        // Validación para "Cantidad"
        if (!cantidadInput.value.trim() || cantidadInput.value <= 0) {
            valid = false;
            document.getElementById('cantidaderror').textContent = 'Por favor ingrese una cantidad válida';
        }

        // Validación para "Fecha de Vencimiento"
        if (!fechaVencimientoInput.value.trim() || fechaVencimientoInput.value < todayString) {
            valid = false;
            document.getElementById('fecha_vencimientoerror').textContent = 'La fecha de vencimiento no puede ser anterior a la fecha actual';
        }

        // Validación para "Descripción"
        if (!descripcionInput.value.trim()) {
            valid = false;
            document.getElementById('descripcionerror').textContent = 'Este campo es obligatorio';
        }

        // Si algún campo no es válido, prevenimos el envío del formulario
        if (!valid) {
            event.preventDefault();
        }
    });
});