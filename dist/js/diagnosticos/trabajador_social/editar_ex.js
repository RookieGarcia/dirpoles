function mantenerPrefijo(event) {
    const input = event.target;
    const prefijo = "D- ";
    if (!input.value.startsWith(prefijo)) {
      input.value = prefijo + input.value.slice(prefijo.length).replace(prefijo, '');
    }
  }

  function soloNumeros(e) {
    const key = e.keyCode || e.which;
    const tecla = String.fromCharCode(key).toString();
    const numeros = "0123456789";

    const especiales = [8, 13]; // backspace, enter
    let tecla_especial = false;

    for (const i in especiales) {
      if (key === especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (numeros.indexOf(tecla) === -1 && !tecla_especial) {
      e.preventDefault();
    }
  }

  function validarCarta() {
    const carta = document.getElementById('carta');
    const cartaError = document.getElementById('carta_error');
    if (carta.value === '') {
      cartaError.textContent = '';
      return true;
    }

    const cartaExtension = carta.value.split('.').pop().toLowerCase();
    if (!carta.value || !['pdf'].includes(cartaExtension)) {
      cartaError.textContent = 'Por favor, seleccione un archivo válido (PDF).';
      return false;
    } else {
      cartaError.textContent = '';
      return true;
    }

  }

  document.getElementById('carta').addEventListener('change', validarCarta);

  document.getElementById('FormularioExoneracion').addEventListener('submit', function(event) {
    if (!validarCarta()) {
      toastr.error("No ha seleccionado un tipo de carta valido.", "Error");
      event.preventDefault();
    }
  });

  document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("carta").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });

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