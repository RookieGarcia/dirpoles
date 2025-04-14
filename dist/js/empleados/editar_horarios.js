document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.querySelector('#formulario-empleado'); // Ajusta el selector según tu formulario

    formulario.addEventListener('submit', function (event) {
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