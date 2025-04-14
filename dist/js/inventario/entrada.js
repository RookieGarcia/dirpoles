document.addEventListener('DOMContentLoaded', function() {
    // Manejar selección de insumo
    document.querySelectorAll('.btn-select-insumo').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('id_insumo').value = this.dataset.id;
            document.getElementById('nombre_insumo').value = this.dataset.nombre;
            document.getElementById('presentacion').value = this.dataset.presentacion;
            $('#modalInsumos').modal('hide');
        });
    });
});

$(function () {
    var table = $('#tabla_insumos').DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "Buttons": false,
        "dom": 'frtip', 
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


