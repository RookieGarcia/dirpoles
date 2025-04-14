$(document).ready(function() {
    $('#tabla_beneficiarios').DataTable({
      "responsive": true,
      "autoWidth": false,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
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
  });