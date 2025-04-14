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


(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


document.getElementById('Posee_carnet_discapacidad').addEventListener('change', function() {
    const carnetInput = document.getElementById('Carnet_discapacidad');
    if (this.value === "Sí") {
      carnetInput.style.display = "block";
      carnetInput.querySelector('input').setAttribute('required', 'required');
    } else {
      carnetInput.style.display = "none";
      carnetInput.querySelector('input').removeAttribute('required');
    }
  });

function validarFormulario() {
    let esValido = true;

   
    const idBeneficiario = document.getElementById('id_beneficiario').value.trim();
    const errorBeneficiario = document.getElementById('nombre_beneficiarioerror');

    if (!idBeneficiario) {
        errorBeneficiario.textContent = "Este campo es obligatorio.";
        esValido = false;
    } else {
        errorBeneficiario.textContent = "";
    }

   
    const campos = [
        "Condicion_medica",
        "Naturaleza_discapacidad",
        "Impacto_disc",
        "Habilidades_funcionales_beneficiario",
        "Dispositivos_asistencia",
        "Salud_mental"
    ];

 
    campos.forEach(campoId => {
        const input = document.getElementById(campoId);
        const errorDiv = document.getElementById(campoId + "error");

     
        input.addEventListener('input', () => {
            if (!input.value.trim()) {
                errorDiv.textContent = "Este campo es obligatorio.";
            } else {
                errorDiv.textContent = "";
            }
        });

       
        if (!input.value.trim()) {
            errorDiv.textContent = "Este campo es obligatorio.";
            esValido = false;
        }
    });

    return esValido;
}

$(function () {
    var table = $('#tabla_beneficiarios').DataTable({
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