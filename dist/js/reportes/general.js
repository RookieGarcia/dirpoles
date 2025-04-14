//-------------------------------------------- VALIDACIONES
const hoy = new Date();
const fechaActual = hoy.toISOString().split('T')[0];

document.getElementById("fecha_inicio").setAttribute("max", fechaActual);
document.getElementById("fecha_fin").setAttribute("max", fechaActual);

function validarFechaManual(inputId, errorId) {
  const input = document.getElementById(inputId);
  const error = document.getElementById(errorId);

  if (new Date(input.value) > new Date(fechaActual)) {
    error.textContent = 'La fecha no puede ser futura.';
    return false;
  } else {
    error.textContent = '';
    return true;
  }

}

document.getElementById("fecha_inicio").addEventListener("input", function() {
  validarFechaManual("fecha_inicio", "error_fecha_inicio");
});

document.getElementById("fecha_fin").addEventListener("input", function() {
  validarFechaManual("fecha_fin", "error_fecha_fin");
});

document.getElementById("form-reporte").addEventListener("submit", function(event) {
  const fechaInicioValida = validarFechaManual("fecha_inicio", "error_fecha_inicio");
  const fechaFinValida = validarFechaManual("fecha_fin", "error_fecha_fin");

  if (!fechaInicioValida || !fechaFinValida) {
    event.preventDefault();
    toastr.error('La fecha no puede ser futura.', 'Error');
  }
});

//-----------------------------------------------------------------------------

//------------------------------- MODAL
document.addEventListener('DOMContentLoaded', function() {
  // Evento para capturar el clic en el botón "Seleccionar" dentro del modal
  document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
    button.addEventListener('click', function() {
      // Obtener los datos del beneficiario seleccionado
      const idBeneficiario = this.getAttribute('data-id');
      const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

      // Asignar los valores a los campos en el formulario principal
      document.getElementById('id_beneficiario').value = idBeneficiario;
      document.getElementById('nombre_beneficiario').value = nombreBeneficiario;


      // Cerrar el modal
      $('#modalBeneficiario').modal('hide');
    });
  });
});

//---------------------------------------------------------------------

$(document).ready(function() {
  const tableGeneral = $('#tabla_general').DataTable({
    "responsive": true,
    "autoWidth": false,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "dom": 'Bfrtip',
    "buttons": [{
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Exportar a Excel',
        title: 'Reporte General',
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

          const pageInfo = tableGeneral.page.info();
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
      }
    ],
    "language": {
      "sEmptyTable": "No hay registros disponibles",
      "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
      "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
      "sLengthMenu": "Mostrar _MENU_ registros",
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

  $('#form-reporte').submit(function(e) {
    e.preventDefault();

    $('#contenedor_general').show();

    $.ajax({
      type: 'POST',
      url: 'index.php?action=reportes_general',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(data) {
        console.log(data);

        if (validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin") || $('fecha_inicio').val() === '' && $('fecha_fin').val() === '') {
          tableGeneral.clear();

          data.forEach(item => {

            const dateParts = item.fecha_creacion.split('-');
            const fecha_formateada = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

            const nombresApellidos = item.nombres + ' ' + item.apellidos;

            tableGeneral.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, item.nombre_serv]);
          });

          tableGeneral.draw();
        } else {
          tableGeneral.clear().draw();
        }
      }
    });
  });
});