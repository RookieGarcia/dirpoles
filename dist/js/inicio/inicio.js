//Calendario
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        events: 'index.php?action=cargar_citas',
        eventClick: function(info) {
            
            $('#eventModalTitle').text(info.event.title);
            $('#eventModalBody').html(`
                <p><strong>Fecha:</strong> ${info.event.start.toLocaleDateString()}</p>
                <p><strong>Hora:</strong> ${info.event.start.toLocaleTimeString()}</p>
                <p><strong>Observación:</strong> ${info.event.extendedProps.description || 'Puedes revisar la cita con mas detalle en las consultas de las citas.'}</p>
            `);
            $('#eventModal').modal('show'); // Muestra el modal
        }
    });
    calendar.render();

    
    $(window).on('resize', function() {
        calendar.updateSize(); // Forza a redimensionar el calendario
    });

    // Evento de redimensionamiento al colapsar el sidebar
    $('[data-widget="pushmenu"]').on('click', function() {
        setTimeout(function() {
            calendar.updateSize();
        }, 300);
    });
});

//Diagnosticos por áreas
    const labels = [
        'Consulta Médica',
        'Consulta Psicológica',
        'Discapacidad',
        'Orientación',
        'Fames',
        'Exoneración',
        'Becas'
    ];

    const dataValues = [
        diagnosticosPorArea.total_consulta_medica,
        diagnosticosPorArea.total_consulta_psicologica,
        diagnosticosPorArea.total_discapacidad,
        diagnosticosPorArea.total_orientacion,
        diagnosticosPorArea.total_fames,
        diagnosticosPorArea.total_exoneracion,
        diagnosticosPorArea.total_becas
    ];

    // Array de valores para el gráfico: se truncan a 10 si exceden ese valor.
    const displayValues = dataValues.map(value => value > 10 ? 10 : value);

    // Array de valores reales para usarlos en tooltips.
    const realValues = dataValues; // Se mantienen sin truncar.

    const ctx = document.getElementById('diagnosticosChart').getContext('2d');
    const diagnosticosChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad de Diagnósticos',
                data: displayValues,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(231, 233, 237, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(231, 233, 237, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10, // Forzamos que el eje Y se detenga en 10.
                    ticks: {
                        callback: function(value) {
                            return value; // Los ticks se mostrarán de 0 a 10.
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // Muestra el valor real en el tooltip
                            const index = context.dataIndex;
                            const realVal = realValues[index];
                            return realVal > 10 ? realVal + " (más de 10)" : realVal;
                        }
                    }
                },
                datalabels: {
                    // Si usas chartjs-plugin-datalabels para mostrar etiquetas encima de cada barra
                    display: true,
                    color: 'black',
                    formatter: function(value, context) {
                        // Si el valor real es mayor que 10, añade un indicador.
                        const index = context.dataIndex;
                        const realVal = realValues[index];
                        return realVal > 10 ? "10+" : realVal;
                    }
                }
            }
        },
        plugins: [ChartDataLabels] // Si usas el plugin de datalabels, recuérdalo.
    });

//Citas por semana

(function() {
    const labels = citasPorDia.map(item => item.dia);
    const dataValues = citasPorDia.map(item => item.total);
    const ctx = document.getElementById('citasChart').getContext('2d');
    const citasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Citas por Día',
                data: dataValues,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
})();