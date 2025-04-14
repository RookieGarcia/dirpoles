$('#tipo_reporte, #servicio').change(function() {

    $('#id_beneficiario').val('');
    $('#nombre_beneficiario').val('');
  });

  document.getElementById('limpiarBeneficiario').addEventListener('click', function() {

    document.getElementById('id_beneficiario').value = '';
    document.getElementById('nombre_beneficiario').value = '';

  });

  //---------------------------------- VALIDACIONES

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

  function validarServicio() {
    const servicioValue = document.getElementById("servicio").value
    const servicioError = document.getElementById("error_servicio");

    if (!servicioValue) {
      servicioError.textContent = 'Este campo no puede estar vacío.';
      return false;
    } else {
      servicioError.textContent = '';
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

  document.getElementById("servicio").addEventListener("change", function() {
    validarServicio();
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
    const servicioValido = validarServicio();

    if (!tipoReporteValido || !servicioValido) {
      event.preventDefault();
      toastr.error("El formulario no puede estar vacio.", "Error");
      return;

    }

    if (servicioValido && $('#tipo_reporte').val() === 'por_beneficiario') {

      if (!validarDatosBenef()) {
        event.preventDefault();
        toastr.error("El beneficiario no puede estar vacio.", "Error");
        return;
      }
    }

    if (!fechaInicioValida || !fechaFinValida) {
      event.preventDefault();
      toastr.error("La fecha de inicio y fin no pueden ser fechas futuras.", "Error");
      return;
    }

    toastr.success("Reporte generado correctamente.", "Éxito");

  });

  //------------------------------------------------------------------------------------------

  //------------------------------- MODAL
  document.addEventListener('DOMContentLoaded', function() {
    const servicioSelect = document.getElementById('servicio');
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

    servicioSelect.addEventListener('change', cargarBeneficiarios);

    function cargarBeneficiarios() {
      const servicio = servicioSelect.value;

      let url = '';
      if (servicio === 'becas') {
        url = `index.php?action=reportes_trabajo_social&servicio=becas`;
      } else if (servicio === 'exoneracion') {
        url = `index.php?action=reportes_trabajo_social&servicio=exoneracion`;
      } else if (servicio === 'fames') {
        url = `index.php?action=reportes_trabajo_social&servicio=fames`;
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
              tableBenef.rows.add(rows).draw(); // Agrega y dibuja los nuevos datos
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

  //-------------------------------------------- DATATABLE -------------------------

  $(document).ready(function() {
    const tableBecas = $('#tabla_becas').DataTable({
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
          title: 'Reportes Becas',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'Reportes Becas',
          className: 'btn btn-danger',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {

            doc.content[0].bold = true;
            doc.content[0].alignment = 'center';

            const pageInfo = tableBecas.page.info();
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

    const tableExoneracion = $('#tabla_exoneracion').DataTable({
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
          title: 'Reportes Exoneracion',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'Reportes Exoneracion',
          className: 'btn btn-danger',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {

            doc.content[0].bold = true;
            doc.content[0].alignment = 'center';

            const pageInfo = tableExoneracion.page.info();
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

    const tableFames = $('#tabla_fames').DataTable({
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
          title: 'Reportes Fames',
          className: 'btn btn-success'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'Reportes Fames',
          className: 'btn btn-danger',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {

            doc.content[0].bold = true;
            doc.content[0].alignment = 'center';

            const pageInfo = tableFames.page.info();
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
      if ($(this).val() === 'personal') {
        $('#usuario_personal').show();
      } else {
        $('#usuario_personal').hide();
      }

      if ($(this).val() === 'por_beneficiario') {
        $('#por_beneficiario').show();
      } else {
        $('#por_beneficiario').hide();
      }
    });
    //------------------------------------------- SELECCION DE SERVICIO

    $('#servicio').change(function() {
      var servicioSeleccionado = $(this).val();

      $('#contenedor_becas').hide();
      $('#contenedor_exoneracion').hide();
      $('#contenedor_fames').hide();

      if (servicioSeleccionado === 'becas') {
        $('#contenedor_becas').show();
      } else if (servicioSeleccionado === 'exoneracion') {
        $('#contenedor_exoneracion').show();
      } else if (servicioSeleccionado === 'fames') {
        $('#contenedor_fames').show();
      }
    });

    $('#form-reporte').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'index.php?action=reportes_trabajo_social',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {

          if ($('#servicio').val() === 'becas' && $('#tipo_reporte').val() === 'morbilidad' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin") || $('#servicio').val() === 'becas' && $('#tipo_reporte').val() === 'por_beneficiario' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin")) {
            tableBecas.clear();

            const filteredData = $('#tipo_reporte').val() === 'por_beneficiario' ?
              data.filter(item => item.id_beneficiario === $('#id_beneficiario').val()) :
              data;

            filteredData.forEach(item => {

              const dateParts = item.fecha_creacion.split('-');
              const fecha_formateada = `${dateParts[2]}-${dateParts[1]} -${dateParts[0]}`;

              const nombresApellidos = item.nombres + ' ' + item.apellidos;

              tableBecas.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, item.tipo_banco, item.cta_bcv]);
            });

            tableBecas.draw();

          } else if ($('#servicio').val() === 'exoneracion' && $('#tipo_reporte').val() === 'morbilidad' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin") || $('#servicio').val() === 'exoneracion' && $('#tipo_reporte').val() === 'por_beneficiario' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin")) {
            tableExoneracion.clear();

            const filteredData = $('#tipo_reporte').val() === 'por_beneficiario' ?
              data.filter(item => item.id_beneficiario === $('#id_beneficiario').val()) :
              data;

            filteredData.forEach(item => {
              const dateParts = item.fecha_creacion.split('-');
              const fecha_formateada = `${dateParts[2]}-${dateParts[1]} -${dateParts[0]}`;

              const nombresApellidos = item.nombres + ' ' + item.apellidos;

              tableExoneracion.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, item.motivo, item.otro_motivo]);
            });
            tableExoneracion.draw();

          } else if ($('#servicio').val() === 'fames' && $('#tipo_reporte').val() === 'morbilidad' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin") || $('#servicio').val() === 'fames' && $('#tipo_reporte').val() === 'por_beneficiario' && validarFechaManual("fecha_inicio", "error_fecha_inicio") && validarFechaManual("fecha_fin", "error_fecha_fin")) {
            tableFames.clear();

            const filteredData = $('#tipo_reporte').val() === 'por_beneficiario' ?
              data.filter(item => item.id_beneficiario === $('#id_beneficiario').val()) :
              data;

            filteredData.forEach(item => {
              const dateParts = item.fecha_creacion.split('-');
              const fecha_formateada = `${dateParts[2]}-${dateParts[1]} -${dateParts[0]}`;

              const nombresApellidos = item.nombres + ' ' + item.apellidos;

              tableFames.row.add([fecha_formateada, nombresApellidos, item.cedula, item.nombre_pnf, item.nombre_patologia, item.tipo_ayuda, item.otro_tipo]);
            });
            tableFames.draw();
          } else {
            tableBecas.clear().draw();
            tableExoneracion.clear().draw();
            tableFames.clear().draw();
          }
        }
      });
    });
  });