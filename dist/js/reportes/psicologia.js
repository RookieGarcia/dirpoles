$('#tipo_reporte').change(function() {

    $('#id_beneficiario').val('');
    $('#nombre_beneficiario').val('');
  });

  document.getElementById('limpiarBeneficiario').addEventListener('click', function() {

    document.getElementById('id_beneficiario').value = '';
    document.getElementById('nombre_beneficiario').value = '';

  });

  //---------------------------------------------------- MODAL
  document.addEventListener('DOMContentLoaded', function() {
    const tipoReporteSelect = document.getElementById('tipo_reporte');
    const tablaBeneficiariosBody = document.querySelector('#modalBeneficiarios tbody');
    const idBeneficiarioInput = document.getElementById('id_beneficiario');
    const nombreBeneficiarioInput = document.getElementById('nombre_beneficiario');

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


    if (!tablaBeneficiariosBody) {
      console.error("No se encontró el tbody de la tabla beneficiarios.");
      return;
    }

    tipoReporteSelect.addEventListener('change', cargarBeneficiarios);

    function cargarBeneficiarios() {
      const tipoReporte = tipoReporteSelect.value;

      let url = '';
      if (tipoReporte === 'citas') {
        url = `index.php?action=reportes_psicologia&tipo_reporte=citas`;
      } else if (tipoReporte === 'morbilidad') {
        url = `index.php?action=reportes_psicologia&tipo_reporte=morbilidad`;
      }

      if (url !== '') {
        fetch(url)
          .then(response => response.json())
          .then(beneficiarios => {
            tableBenef.clear();

            if (beneficiarios.length > 0) {
              const rows = beneficiarios.map(beneficiario => [
                beneficiario.nombres,
                beneficiario.apellidos,
                beneficiario.cedula,
                beneficiario.nombre_pnf,
                `<button class="btn btn-primary btn-select-beneficiario" data-id="${beneficiario.id_beneficiario}" data-nombre="${beneficiario.nombres}" data-apellido="${beneficiario.apellidos}">Seleccionar</button>`
              ]);
              tableBenef.rows.add(rows).draw();
            }
          })
          .catch(error => console.error('Error al cargar beneficiarios:', error));
      }
    }

    document.querySelector('#modalBeneficiarios').addEventListener('click', function(event) {
      if (event.target && event.target.matches('button.btn-select-beneficiario')) {
        const idBeneficiario = event.target.getAttribute('data-id');
        const nombre = event.target.getAttribute('data-nombre');
        const apellido = event.target.getAttribute('data-apellido');

        idBeneficiarioInput.value = idBeneficiario;

        nombreBeneficiarioInput.value = `${nombre} ${apellido}`;

        idBeneficiarioInput.dispatchEvent(new Event("input"));

        $('#modalBeneficiario').modal('hide');
      }
    });
  });

  //---------------------------------------------------------------------

  $(document).ready(function() {
    const tablePsG = $('#tabla_psG').DataTable({
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
          title: 'Reportes Psicología',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'Reportes Psicología',
          className: 'btn btn-danger',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {

            doc.content[0].bold = true;
            doc.content[0].alignment = 'center';

            const pageInfo = tablePsG.page.info();
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
                opacity: 0.1,
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

    const tableCitas = $('#tabla_citas').DataTable({
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
          title: 'Reportes Citas',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'Reportes Citas',
          className: 'btn btn-danger',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {

            doc.content[0].bold = true;
            doc.content[0].alignment = 'center';

            const pageInfo = tableCitas.page.info();
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

    //------------------------------------------ VALIDACIONES
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

    document.getElementById("fecha_inicio").addEventListener("input", function() {
      validarFechaManual("fecha_inicio", "error_fecha_inicio");
    });

    document.getElementById("fecha_fin").addEventListener("input", function() {
      validarFechaManual("fecha_fin", "error_fecha_fin");
    });

    document.getElementById("tipo_reporte").addEventListener("change", function() {
      validarTipoReporte();
    });

    document.getElementById("form-reporte").addEventListener("submit", function(event) {
      const fechaInicioValida = validarFechaManual("fecha_inicio", "error_fecha_inicio");
      const fechaFinValida = validarFechaManual("fecha_fin", "error_fecha_fin");
      const tipoReporteValido = validarTipoReporte();

      if (!tipoReporteValido) {
        event.preventDefault();
        toastr.error("El formulario no puede estar vacio.", "Error");
        return;
      }

      if (!fechaInicioValida || !fechaFinValida) {
        event.preventDefault();
        toastr.error("La fecha de inicio y fin no pueden ser fechas futuras.", "Error");
        return;
      }

      toastr.success("Reporte generado correctamente.", "Éxito");

    });

    //--------------------------------------------------------------


    //-------------------------------- SELECCION DE TIPO DE REPORTE
    function actualizarContenedores() {
      const tipoReporte = $('#tipo_reporte').val();

      $('#contenedor_citas').hide();
      $('#contenedor_psG').hide();

      if (tipoReporte === 'morbilidad') {
        $('#contenedor_psG').show();
      } else if (tipoReporte === 'citas') {
        $('#contenedor_citas').show();
      }
    }

    $('#tipo_reporte').change(function() {
      actualizarContenedores();
    });

    //------------------------------------------------------

    $('#form-reporte').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'index.php?action=reportes_psicologia',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {

          if ($('#tipo_reporte').val() === 'morbilidad' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin") || $('#tipo_reporte').val() === 'morbilidad' && $('fecha_inicio').val() === '' && $('fecha_fin').val() === '') {
            tablePsG.clear();

            const idBeneficiarioSeleccionado = $('#id_beneficiario').val();

            const filteredData = idBeneficiarioSeleccionado ? data.filter(item => item.id_beneficiario === $('#id_beneficiario').val()) : data;

            filteredData.forEach(item => {

              const dateParts = item.fecha_creacion.split('-');
              const fecha_formateada = `${dateParts[2]}-${dateParts[1]} -${dateParts[0]}`;

              const nombresApellidos = item.nombres + ' ' + item.apellidos;

              tablePsG.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, item.motivo, item.motivo_otro]);
            });

            tablePsG.draw();

          } else if ($('#tipo_reporte').val() === 'citas' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin") || $('#tipo_reporte').val() === 'citas' && $('fecha_inicio').val() === '' && $('fecha_fin').val() === '' ) {
            tableCitas.clear();

            const idBeneficiarioSeleccionado = $('#id_beneficiario').val();

            const filteredData = idBeneficiarioSeleccionado ? data.filter(item => item.id_beneficiario === $('#id_beneficiario').val()) : data;

            filteredData.forEach(item => {

              const dateParts = item.fecha_creacion.split('-');
              const fecha_formateada = `${dateParts[2]}-${dateParts[1]} -${dateParts[0]}`;

              const dateParts2 = item.fecha.split('-');
              const fecha_formateada2 = `${dateParts2[2]}-${dateParts2[1]} -${dateParts2[0]}`;

              const nombresApellidos = item.nombres + ' ' + item.apellidos;

              tableCitas.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, fecha_formateada2, item.hora]);
            });

            tableCitas.draw();
          } else {
            tablePsG.clear().draw();
            tableCitas.clear().draw();
          }

        }
      });
    });
  });