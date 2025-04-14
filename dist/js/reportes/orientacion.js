//---------------------------------------- VALIDACIONES


$('#tipo_reporte').change(function() {

    $('#id_beneficiario').val('');
    $('#nombre_beneficiario').val('');
  });

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

  function validarTipoReporte() {
    const tipoReporte = document.getElementById("tipo_reporte").value
    const tipoError = document.getElementById("error_tipo_reporte");

    if (!tipoReporte) {
      tipoError.textContent = 'Este campo no puede estar vacío.';
      return false;
    } else {
      tipoError.textContent = '';
      return true;
    }

  }

  function validarDatosBenef() {
    const benefValue = document.getElementById("id_beneficiario").value
    const benefError = document.getElementById("error_id_beneficiario");

    if (!benefValue) {
      benefError.textContent = 'Este campo no puede estar vacío.';
      return false;
    } else {
      benefError.textContent = '';
      return true;
    }
  }

  document.getElementById("fecha_inicio").addEventListener("input", function() {
    validarFechaManual("fecha_inicio", "error_fecha_inicio");
  });

  document.getElementById("fecha_fin").addEventListener("input", function() {
    validarFechaManual("fecha_fin", "error_fecha_fin");
  });

  document.getElementById("tipo_reporte").addEventListener("change", function() {
    validarTipoReporte();
  });

  document.getElementById("id_beneficiario").addEventListener("input", function() {
    validarDatosBenef();
  });

  document.getElementById("form-reporte").addEventListener("submit", function(event) {
    const fechaInicioValida = validarFechaManual("fecha_inicio", "error_fecha_inicio");
    const fechaFinValida = validarFechaManual("fecha_fin", "error_fecha_fin");
    const tipoReporteValido = validarTipoReporte();

    if (!fechaInicioValida || !fechaFinValida) {
      event.preventDefault();
      toastr.error('La fecha no puede ser futura.', 'Error');
      return;
    }

    if (!tipoReporteValido) {
      event.preventDefault();
      toastr.error("El formulario no puede estar vacio.", "Error");
      return;
    }

    if ($('#tipo_reporte').val() === 'por_beneficiario') {

      if (!validarDatosBenef()) {
        event.preventDefault();
        toastr.error("El beneficiario no puede estar vacio.", "Error");
        return;
      }
    }

    toastr.success('Reporte generado con exito.', 'Exito')
  });

  //-----------------------------------------------------------------

  //------------------------------- MODAL
  document.addEventListener('DOMContentLoaded', function() {

    const tableBenef = $('#modalBeneficiarios').DataTable({
      "responsive": true,
      "autoWidth": false,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "dom": 'frtip',
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

    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
      button.addEventListener('click', function() {
        const idBeneficiario = this.getAttribute('data-id');
        const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

        document.getElementById('id_beneficiario').value = idBeneficiario;
        document.getElementById('nombre_beneficiario').value = nombreBeneficiario;


        $('#modalBeneficiario').modal('hide');
      });
    });
  });

  //---------------------------------------------------------------------

  $(document).ready(function() {
    const tableOr = $('#tabla_orientacion').DataTable({
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
          title: 'Reportes Orientacion',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'Reportes Orientacion',
          className: 'btn btn-danger',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {

            doc.content[0].bold = true;
            doc.content[0].alignment = 'center';

            const pageInfo = tableOr.page.info();
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

    //-------------------------------- SELECCION DE TIPO DE REPORTE
    $('#tipo_reporte').change(function() {
      const selectedValue = $(this).val();

      if (selectedValue === 'por_beneficiario') {
        $('#por_beneficiario').show();
      } else if (selectedValue === 'morbilidad') {
        $('#contenedor_orientacion').show();
        $('#por_beneficiario').hide();
      }
    });



    //------------------------------------------------------

    $('#form-reporte').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'index.php?action=reportes_orientacion',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {

          tableOr.clear();

          const filteredData = $('#tipo_reporte').val() === 'por_beneficiario' ?
            data.filter(item => item.id_beneficiario === $('#id_beneficiario').val()) :
            data;

          filteredData.forEach(item => {

            const dateParts = item.fecha_creacion.split('-');
            const fecha_formateada = `${dateParts[2]}-${dateParts[1]} -${dateParts[0]}`;

            const nombresApellidos = item.nombres + ' ' + item.apellidos;

            tableOr.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, item.motivo_orientacion]);
          });

          tableOr.draw();



        }
      });
    });
  });