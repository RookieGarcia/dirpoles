$(function () {
    var table = $('#tabla_inventario').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i> Exportar a Excel',
                title: 'Inventario Médico',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
                title: 'Reporte General',
                className: 'btn btn-danger',
                orientation: 'landscape',
                pageSize: 'A1',
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
                text: '<i class="fas fa-briefcase-medical"></i> Agregar Insumo',
                className: 'btn btn-info',
                action: function () {
                    window.location.href = 'index.php?action=inventario_crear';
                }
            },
            {
                text: '<i class="fas fa-plus-circle"></i> Registrar entrada',
                className: 'btn btn-success',
                action: function () {
                    window.location.href = 'index.php?action=inventario_entrada';
                }
            },
            {
                text: '<i class="fas fa-history"></i> Ver Movimientos',
                className: 'btn btn-secondary',
                action: function () {
                    window.location.href = 'index.php?action=inventario_movimientos';
                }
            }
        ],
        "dom": 'Bfrtip', 
        "language": {
            "sEmptyTable": "No hay datos disponibles en la tabla",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "sInfoFiltered": "(filtrado de _MAX_ entradas totales)",
            "sLengthMenu": "Mostrar _MENU_ entradas",
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