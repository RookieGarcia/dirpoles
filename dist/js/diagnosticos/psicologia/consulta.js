$(function() {
    var table = $('#tabla_psicologia').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i> Exportar a Excel',
                title: 'Beneficiarios',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
                title: 'Reporte General',
                className: 'btn btn-danger',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function(doc) {

                    doc.content[0].bold = true;
                    doc.content[0].alignment = 'center';

                    const pageInfo = table.page.info();
                    const summaryText = `Mostrando ${pageInfo.start + 1} a ${pageInfo.end} de ${pageInfo.recordsTotal} registros`;

                    doc.content.splice(2, 0, {
                        text: summaryText,
                        alignment: 'left',
                        margin: [0, 10, 0, 10]
                    });

                    doc.content[1].margin = [0, 20, 0, 0];
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                    doc.header = function(currentPage, pageCount, pageSize) {
                        return {
                            image: '<?php echo BASE_HEADER; ?>',
                            width: 800,
                            alignment: 'center',
                            opacity: 1,
                            margin: [0, 0, 0, 0],
                        };
                    };

                    doc.content[0].margin = [0, 20, 0, 0];

                    doc.background = function(page) {
                        return {
                            type: 'image',
                            image: '<?php echo BASE_FONDO; ?>',
                            width: 400,
                            opacity: 0.2,
                            x: 250,
                        };
                    };
                }
            },
            {
                text: '<i class="fas fa-user-plus"></i> Crear Consulta Psicológica',
                className: 'btn btn-info',
                action: function() {
                    window.location.href = 'index.php?action=diagnostico_psicologia';
                }
            }
        ],
        "dom": 'Bfrtip',
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

    table.buttons().container().appendTo('#tabla_empleados_wrapper .col-md-6:eq(0)');
});