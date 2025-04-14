$(function () {
    var table = $('#tabla_movimientos').DataTable({
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
                title: 'Registro de Movimientos',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
                title: 'Registro de Movimientos',
                className: 'btn btn-danger'
            },
            {
                text: '<i class="fas fa-arrow-left"></i> Volver al Inventario',
                className: 'btn btn-secondary',
                action: function () {
                    window.location.href = 'index.php?action=inventario_consulta';
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