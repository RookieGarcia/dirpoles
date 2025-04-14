function validarEditarCuentaBcv() {
    const ctabcv = document.getElementById('ctabcv_editar').value;
    const ctabcvError = document.getElementById('ctabcv-error');
    const regexCtabcv = /^[0-9]{16}$/;

    if (!regexCtabcv.test(ctabcv)) {
      ctabcvError.textContent = 'La cuenta bancaria debe contener exactamente 16 números.'
      return false;
    } else {
      ctabcvError.textContent = '';
      return true;
    }
  }

  document.getElementById('ctabcv_editar').addEventListener('input', function() {
    validarEditarCuentaBcv();
  });

  document.getElementById('ctabcv_editar').addEventListener('input', function(e) {
    const valor = e.target.value;
    e.target.value = valor.replace(/[^0-9]/g, '').slice(0, 16);
  });

  document.getElementById('FormularioEditarBeca').addEventListener('submit', function(event) {

    if (!validarEditarCuentaBcv()) {
      event.preventDefault();
    }
  });
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("planilla").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });