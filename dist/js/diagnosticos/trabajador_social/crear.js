//------------------------------- GENERAL
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
      button.addEventListener('click', function() {
        // Obtener los datos del beneficiario seleccionados
        const idBeneficiario = this.getAttribute('data-id');
        const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');
        const targetForm = this.getAttribute('data-formulario'); // Formulario objetivo

        // Actualizar campos del formulario correspondiente
        if (targetForm === 'formularioB') {
          document.getElementById('id_beneficiario_becas').value = idBeneficiario;
          document.getElementById('nombre_beneficiario_becas').value = nombreBeneficiario;
          validarBeneficiarioBecas();
        } else if (targetForm === 'formularioEx') {
          document.getElementById('id_beneficiario_ex').value = idBeneficiario;
          document.getElementById('nombre_beneficiario_ex').value = nombreBeneficiario;
          validarBeneficiarioEx();
        } else if (targetForm === 'formularioF') {
          document.getElementById('id_beneficiario_fames').value = idBeneficiario;
          document.getElementById('nombre_beneficiario_fames').value = nombreBeneficiario;
          validarBeneficiarioFames();
        }

        $(this).closest('.modal').modal('hide');
      });
    });
  });

  //-------------------------------------------------------------

  // BECA
  function validarBeneficiarioBecas() {
    const idBenef = document.getElementById('nombre_beneficiario_becas').value;
    const idBenefError = document.getElementById('id_beneficiario_error');

    if (idBenef == '') {
      idBenefError.textContent = 'Seleccione un beneficiario';
      return false;
    } else {
      idBenefError.textContent = '';
      return true;
    }

  }

  function validarCrearCuentaBcv() {
    const ctabcv = document.getElementById('ctabcv').value;
    const ctabcvError = document.getElementById('ctabcv_error');
    const regexCtabcv = /^[0-9]{16}$/;

    if (!regexCtabcv.test(ctabcv)) {
      ctabcvError.textContent = 'La cuenta bancaria debe contener exactamente 16 números.'
      return false;
    } else {
      ctabcvError.textContent = '';
      return true;
    }

  }

  function validarTipoBanco() {
    const tipoBanco = document.getElementById('tipo_banco').value;
    const tipoBancoError = document.getElementById('tipo_banco_error');

    if (tipoBanco === '') {
      tipoBancoError.textContent = 'El tipo de banco es requerido'
      return false;
    } else {
      tipoBancoError.textContent = '';
      return true;
    }

  }

  function validarPlanilla() {
    const planillaBeca = document.getElementById('planilla').value;
    const planillaError = document.getElementById('planilla_error');

    if (planillaBeca == '') {
      planillaError.textContent = 'La planilla es requerida'
      return false;
    }

    const planillaExtension = planillaBeca.split('.').pop().toLowerCase();
    if (!['pdf'].includes(planillaExtension)) {
      planillaError.textContent = 'Por favor, seleccione un archivo válido (PDF).';
      return false;
    } else {
      planillaError.textContent = '';
      return true;
    }
  }

  function eliminarTodosErrores() {
    const errorElements = document.querySelectorAll('.text-danger');
    errorElements.forEach(errorElement => {
      errorElement.textContent = '';
    });
  }

  document.getElementById('nombre_beneficiario_becas').addEventListener('change', function() {
    validarBeneficiarioBecas();
  });

  document.getElementById('ctabcv').addEventListener('input', function() {
    validarCrearCuentaBcv();
  });

  document.getElementById('planilla').addEventListener('input', function() {
    validarPlanilla();
  });

  document.getElementById('tipo_banco').addEventListener('input', function() {
    validarTipoBanco();
  });

  const formB = document.getElementById('FormularioBecas');

  document.getElementById('btnCancelarB').addEventListener('click', function() {
    formB.reset();
    eliminarTodosErrores();
  });

  function validarBecas() {
    const idBenefValidar = validarBeneficiarioBecas();
    const ctaValidar = validarCrearCuentaBcv();
    const planillaValidar = validarPlanilla();
    const tipoBancoValidar = validarTipoBanco();

    return ctaValidar && planillaValidar && tipoBancoValidar && idBenefValidar;
  }

  document.getElementById('FormularioBecas').addEventListener('submit', function(event) {
    console.log("Formulario en proceso de envío...");
    if (!validarBecas()) {
      console.log("Formulario no enviado, cuenta BCV inválida.");
      toastr.error('Datos incompletos, por favor rellene todos los campos', 'Error')
      event.preventDefault();
    }
  });

  //EXONERACION-----------------------------------------

  function mantenerPrefijoCE(event) {
    const input = event.target;
    const prefijo = "D- ";
    if (!input.value.startsWith(prefijo)) {
      input.value = prefijo + input.value.slice(prefijo.length).replace(prefijo, '');
    }
  }

  const siRadioDiscapacitado = document.getElementById('siRadioDiscapacitado');
  const noRadioDiscapacitado = document.getElementById('noRadioDiscapacitado');

  function mostrarCarnetDisc() {
    const carnetDisc = document.getElementById('carnetDiscapacitado');


    if (siRadioDiscapacitado.checked) {
      carnetDisc.style.display = 'block';
    }

    if (noRadioDiscapacitado.checked) {
      carnetDisc.style.display = 'none';
    }
  }

  document.getElementById('siRadioDiscapacitado').addEventListener('change', mostrarCarnetDisc);
  document.getElementById('noRadioDiscapacitado').addEventListener('change', mostrarCarnetDisc);

  function limpiarFormulario() {
    const contenedor = document.getElementById('seleccionEstudioSE');

    if (contenedor) {
      // Limpiar valores de inputs, selects y textareas
      const inputs = contenedor.querySelectorAll('input, select, textarea');
      inputs.forEach((input) => {
        if (input.type === 'checkbox' || input.type === 'radio') {
          input.checked = false;
        } else {
          input.value = '';
        }
      });

      // Limpiar mensajes de error
      const errores = contenedor.querySelectorAll('.text-danger');
      errores.forEach((error) => {
        error.textContent = '';
      });
    }
  }

  document.getElementById('siRadioDiscapacitado').addEventListener('change', limpiarFormulario);

  function validarBeneficiarioEx() {
    const idBenef = document.getElementById('nombre_beneficiario_ex').value;
    const idBenefError = document.getElementById('id_beneficiario_error_ex');

    if (idBenef == '') {
      idBenefError.textContent = 'Seleccione un beneficiario';
      return false;
    } else {
      idBenefError.textContent = '';
      return true;
    }

  }

  function validarMotivoEx() {
    const motivoEx = document.getElementById('motivo_ex');
    const motivoExError = document.getElementById('motivo_ex_error');

    if (motivoEx.value === "") {
      motivoExError.textContent = 'Por favor, seleccione un motivo.';
      return false;
    } else {
      motivoExError.textContent = '';
      return true;
    }
  }


  function validarCarta() {
    const carta = document.getElementById('carta');
    const cartaError = document.getElementById('carta_error');

    if (!carta.value) {
      cartaError.textContent = 'No se ha seleccionado ningún archivo.';
      return false;
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

  function validarDiscapacitado() {
    const discapacitadoSi = document.getElementById('siRadioDiscapacitado');
    const discapacitadoNo = document.getElementById('noRadioDiscapacitado');
    const discapacitadoError = document.getElementById('discapacitado_error');

    if (!discapacitadoSi.checked && !discapacitadoNo.checked) {
      discapacitadoError.textContent = 'Por favor, seleccione una opción para discapacidad.';
      return false;
    } else {
      discapacitadoError.textContent = '';
      return true;
    }
  }

  document.getElementById('carta').addEventListener('change', validarCarta);

  document.getElementById('nombre_beneficiario_ex').addEventListener('input', function() {
    validarBeneficiarioEx();
  });
  document.getElementById('motivo_ex').addEventListener('change', function() {
    validarMotivoEx();
  });
  document.querySelectorAll('input[name="discapacitado"]').forEach(radio => {
    radio.addEventListener('change', function() {
      validarDiscapacitado();
    });
  });

  //---------------VALIDACIONES FORMULARIO ESTUDIO SOCIO-ECONOMICO---------------
  document.addEventListener("DOMContentLoaded", function() {

    function validarImagen() {
      const archivo = document.getElementById('imagen_se');
      const archivoError = document.getElementById('imagen_error');

      const archivoExtension = archivo.value.split('.').pop().toLowerCase();
      if (!['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(archivoExtension)) {
        archivoError.textContent = 'Por favor, seleccione un archivo de imagen válido (JPG, JPEG, PNG, GIF, BMP).';
        return false;
      }

      if (!archivo.value) {
        archivoError.textContent = '';
        return true;
      }

      archivoError.textContent = '';
      return true;

    }

    function validarSolicitud() {
      const solicitudRenovacion = document.getElementById('solicitud_renovacion');
      const solicitudNueva = document.getElementById('solicitud_nueva');
      const solicitudError = document.getElementById('solicitud_error');

      if (!solicitudRenovacion.checked && !solicitudNueva.checked) {
        solicitudError.textContent = 'Por favor, seleccione una opción de solicitud.';
        return false;
      } else {
        solicitudError.textContent = '';
        return true;
      }
    }

    function validarBeneficio() {
      const beneficio = document.getElementById('beneficio');
      const beneficioError = document.getElementById('beneficio_error');

      if (beneficio.value.length < 3) {
        beneficioError.textContent = 'Por favor, ingrese el beneficio solicitado.';
        return false;
      } else {
        beneficioError.textContent = '';
        return true;
      }
    }

    const hoy = new Date();
    const fechaActual = hoy.toISOString().split('T')[0];

    document.getElementById("fecha").setAttribute("max", fechaActual);

    function validarFecha() {
      const input = document.getElementById('fecha');
      const error = document.getElementById('fecha_error');

      if (!input.value) {
        error.textContent = 'Por favor, ingrese la fecha.';
        return false;
      }

      if (new Date(input.value) > new Date(fechaActual)) {
        error.textContent = 'La fecha no puede ser futura.';
        return false;
      }

      error.textContent = '';
      return true;
    }

    function validarNombre() {
      const nombre = document.getElementById('nombre').value.trim();
      const nombreError = document.getElementById('nombre_error');

      if (nombre.length < 3) {
        nombreError.textContent = 'Por favor, ingrese apellidos y nombres.';
        return false;
      } else {
        nombreError.textContent = '';
        return true;
      }
    }

    function validarNacimiento() {
      const nacimiento = document.getElementById('nacimiento').value.trim();
      const nacimientoError = document.getElementById('nacimiento_error');

      if (nacimiento.length < 3) {
        nacimientoError.textContent = 'Por favor, ingrese un lugar de nacimiento correcto.';
        return false;
      } else {
        nacimientoError.textContent = '';
        return true;
      }
    }

    document.getElementById("fecha_nacimiento").setAttribute("max", fechaActual);

    function validarFechaNac() {
      const fechaNac = document.getElementById('fecha_nacimiento');
      const fechaNacError = document.getElementById('fecha_nacimiento_error');

      if (!fechaNac.value) {
        fechaNacError.textContent = 'Por favor, ingrese la fecha.';
        return false;
      }

      if (new Date(fechaNac.value) > new Date(fechaActual)) {
        fechaNacError.textContent = 'La fecha no puede ser futura.';
        return false;
      }

      const fechaMod = new Date(fechaNac.value);

      let edad = hoy.getFullYear() - fechaMod.getFullYear();
      const mes = hoy.getMonth() - fechaMod.getMonth();
      if (mes < 0 || (mes === 0 && hoy.getDate() < fechaMod.getDate())) {
        edad--;
      }

      if (edad < 15) {
        fechaNacError.textContent = 'Debe registrar una persona mayor de 14 años.';
        return false;
      }

      fechaNacError.textContent = '';
      return true;

    }

    function validarEdad() {
      const edad = document.getElementById('edad');
      const edadError = document.getElementById('edad_error');

      if (edad.value < 14 || edad.value > 80) {
        edadError.textContent = 'Por favor, ingrese una edad mayor a 14 años.';
        return false;
      }

      if (isNaN(edad.value)) {
        edadError.textContent = 'Por favor, ingrese solo numeros.';
        return false;
      }
      edadError.textContent = '';
      return true;

    }

    function validarEstadoCivil() {
      const estadoCivil = document.getElementById('estado_civil');
      const estadoCivilError = document.getElementById('estado_civil_error');

      if (estadoCivil.value === "") {
        estadoCivilError.textContent = 'Por favor, ingrese su estado civil.';
        return false;
      } else {
        estadoCivilError.textContent = '';
        return true;
      }
    }

    function validarCI() {
      const ci = document.getElementById('ci');
      const ciError = document.getElementById('ci_error');

      if (ci.value === "") {
        ciError.textContent = 'Por favor, ingrese su cédula de identidad.';
        return false;
      }

      if (isNaN(ci.value)) {
        ciError.textContent = 'Por favor, ingrese solo numeros';
        return false;
      }

      if (ci.value.length < 6) {
        ciError.textContent = 'Por favor, ingrese mas de 6 digitos.';
        return false;
      }

      ciError.textContent = '';
      return true;

    }

    function validarTelefono() {
      const telefono = document.getElementById('telefono');
      const telefonoError = document.getElementById('telefono_error');

      if (telefono.value === "") {
        telefonoError.textContent = 'Por favor, ingrese su número de teléfono.';
        return false;
      }

      if (isNaN(telefono.value)) {
        telefonoError.textContent = 'Por favor, ingrese solo numeros.';
        return false;
      }

      if (telefono.value.length < 11) {
        telefonoError.textContent = 'Por favor, ingrese un numero de telefono valido.';
        return false;
      }

      telefonoError.textContent = '';
      return true;

    }

    function validarTrabaja() {
      const trabajaSi = document.getElementById('trabaja_si');
      const trabajaNo = document.getElementById('trabaja_no');
      const trabajaError = document.getElementById('trabaja_error');
      if (!trabajaSi.checked && !trabajaNo.checked) {
        trabajaError.textContent = 'Por favor, seleccione si trabaja o no.';
        return false;
      } else {
        trabajaError.textContent = '';
        return true;
      }
    }

    function validarOcupacion() {
      const ocupacion = document.getElementById('ocupacion').value.trim();
      const ocupacionError = document.getElementById('ocupacion_error');

      if (ocupacion.length < 4) {
        ocupacionError.textContent = 'Por favor, ingrese su ocupación.';
        return false;
      } else {
        ocupacionError.textContent = '';
        return true;
      }
    }

    function validarLugarTrabajo() {
      const lugarTrabajo = document.getElementById('lugar_trabajo').value.trim();
      const lugarTrabajoError = document.getElementById('lugar_trabajo_error');

      if (lugarTrabajo.length < 4) {
        lugarTrabajoError.textContent = 'Por favor, ingrese su lugar de trabajo.';
        return false;
      } else {
        lugarTrabajoError.textContent = '';
        return true;
      }
    }

    function validarSueldo() {
      const sueldo = document.getElementById('sueldo');
      const sueldoError = document.getElementById('sueldo_error');

      if (sueldo.value === "") {
        sueldoError.textContent = 'Por favor, ingrese su sueldo.';
        return false;
      } else {
        sueldoError.textContent = '';
        return true;
      }
    }

    function validarCargaFamiliar() {
      const cargaFamiliarSi = document.getElementById('carga_familiar_si');
      const cargaFamiliarNo = document.getElementById('carga_familiar_no');
      const cargaFamiliarError = document.getElementById('carga_familiar_error');
      if (!cargaFamiliarSi.checked && !cargaFamiliarNo.checked) {
        cargaFamiliarError.textContent = 'Por favor, seleccione si tiene carga familiar.';
        return false;
      } else {
        cargaFamiliarError.textContent = '';
        return true;
      }
    }

    function validarHijos() {
      const hijos = document.getElementById('hijos');
      const hijosError = document.getElementById('hijos_error');

      if (hijos.value === "") {
        hijosError.textContent = 'Por favor, ingrese el número de hijos.';
        return false;
      }

      if (hijos.value >= 20) {
        hijosError.textContent = 'Introduzca un numero menor o igual a 20';
        return false;
      }

      hijosError.textContent = '';
      return true;

    }

    function validarDireccionHabitacion() {
      const dirHab = document.getElementById('dir_hab').value.trim();
      const dirHabError = document.getElementById('dir_hab_error');

      if (dirHab.length < 4) {
        dirHabError.textContent = 'Por favor, ingrese su dirección de habitación.';
        return false;
      } else {
        dirHabError.textContent = '';
        return true;
      }
    }

    function validarDireccionResidencia() {
      const dirRes = document.getElementById('dir_res').value.trim();
      const dirResError = document.getElementById('dir_res_error');

      if (dirRes.length < 4) {
        dirResError.textContent = 'Por favor, ingrese su dirección de residencia.';
        return false;
      } else {
        dirResError.textContent = '';
        return true;
      }
    }

    function validarEspecialidad() {
      const especialidad = document.getElementById('especialidad').value.trim();
      const especialidadError = document.getElementById('especialidad_error');

      if (especialidad.length < 4) {
        especialidadError.textContent = 'Por favor, ingrese la especialidad.';
        return false;
      } else {
        especialidadError.textContent = '';
        return true;
      }
    }

    function validarSemestre() {
      const semTra = document.getElementById('sem_tra');
      const semTraError = document.getElementById('sem_tra_error');

      if (semTra.value === "") {
        semTraError.textContent = 'Por favor, ingrese el semestre o trayecto.';
        return false;
      }

      if (semTra.value > 6 || semTra.value < 1) {
        semTraError.textContent = 'Por favor, ingrese un semestre o trayecto válido';
        return false;
      }
      semTraError.textContent = '';
      return true;

    }

    function validarTurno() {
      const turno = document.getElementById('turno');
      const turnoError = document.getElementById('turno_error');

      if (!turno.value) {
        turnoError.textContent = 'Por favor, ingrese el turno.';
        return false;
      } else {
        turnoError.textContent = '';
        return true;
      }
    }

    function validarSeccion() {
      const seccion = document.getElementById('seccion').value.trim();
      const seccionError = document.getElementById('seccion_error');

      if (!seccion) {
        seccionError.textContent = 'Por favor, ingrese la sección.';
        return false;
      }

      if (seccion.length <= 4) {
        seccionError.textContent = 'Por favor, ingrese la sección correcta'
        return false;
      }

      seccionError.textContent = '';
      return true;

    }

    function validarCorreo() {
      const correo = document.getElementById('correo');
      const correoError = document.getElementById('correo_error');
      const correoRegex = /^[a-zA-Z0-9._%+-]+@(hotmail|yahoo|gmail|outlook)\.(com|es|net|org)$/;

      if (correo.value === "") {
        correoError.textContent = 'Por favor, ingrese un correo electrónico.';
        return false;
      } else if (!correoRegex.test(correo.value)) {
        correoError.textContent = 'Por favor, ingrese un correo electrónico válido (hotmail, yahoo, gmail, outlook) y con terminación .com';
        return false;
      } else {
        correoError.textContent = '';
        return true;
      }
    }

    document.getElementById('imagen_se').addEventListener('change', validarImagen);
    document.getElementById('solicitud_renovacion').addEventListener('change', validarSolicitud);
    document.getElementById('solicitud_nueva').addEventListener('change', validarSolicitud);
    document.getElementById('beneficio').addEventListener('input', validarBeneficio);
    document.getElementById('fecha').addEventListener('input', validarFecha);
    document.getElementById('nombre').addEventListener('input', validarNombre);
    document.getElementById('nacimiento').addEventListener('input', validarNacimiento);
    document.getElementById('fecha_nacimiento').addEventListener('input', validarFechaNac);
    document.getElementById('edad').addEventListener('input', validarEdad);
    document.getElementById('estado_civil').addEventListener('input', validarEstadoCivil);
    document.getElementById('ci').addEventListener('input', validarCI);
    document.getElementById('telefono').addEventListener('input', validarTelefono);
    document.getElementById('trabaja_si').addEventListener('change', validarTrabaja);
    document.getElementById('trabaja_no').addEventListener('change', validarTrabaja);
    document.getElementById('ocupacion').addEventListener('input', validarOcupacion);
    document.getElementById('lugar_trabajo').addEventListener('input', validarLugarTrabajo);
    document.getElementById('sueldo').addEventListener('input', validarSueldo);
    document.getElementById('carga_familiar_si').addEventListener('change', validarCargaFamiliar);
    document.getElementById('carga_familiar_no').addEventListener('change', validarCargaFamiliar);
    document.getElementById('hijos').addEventListener('input', validarHijos);
    document.getElementById('dir_hab').addEventListener('input', validarDireccionHabitacion);
    document.getElementById('dir_res').addEventListener('input', validarDireccionResidencia);
    document.getElementById('especialidad').addEventListener('input', validarEspecialidad);
    document.getElementById('sem_tra').addEventListener('input', validarSemestre);
    document.getElementById('turno').addEventListener('input', validarTurno);
    document.getElementById('seccion').addEventListener('input', validarSeccion);
    document.getElementById('correo').addEventListener('input', validarCorreo);

    document.getElementById('FormularioExoneracion').addEventListener('submit', function(event) {
      const discapacitadoNoDos = document.getElementById('noRadioDiscapacitado');

      if (discapacitadoNoDos.checked && discapacitadoNoDos.value === 'no') {
        //------- LA SIGUIENTE FUNCION ES PARA CHEQUEAR TODAS LAS VALIDACIONES PARA CUANDO SE VAYA A ENVIAR EL FORMULARIO, SI SE AGREGAN ARRIBA MAS VALIDACIONES, HAY QUE AGREGARLAS EN ESTA FUNCION
        function validarFormularioExoneracion() {
          const solicitudValida = validarSolicitud();
          const beneficioValido = validarBeneficio();
          const fechaValida = validarFecha();
          const nombreValido = validarNombre();
          const nacimientoValido = validarNacimiento();
          const fechaNacimientoValida = validarFechaNac();
          const edadValida = validarEdad();
          const estadoCivilValido = validarEstadoCivil();
          const ciValido = validarCI();
          const telefonoValido = validarTelefono();
          const trabajaValido = validarTrabaja();
          const ocupacionValida = validarOcupacion();
          const lugarTrabajoValido = validarLugarTrabajo();
          const sueldoValido = validarSueldo();
          const cargaFamiliarValida = validarCargaFamiliar();
          const hijosValido = validarHijos();
          const direccionHabitacionValida = validarDireccionHabitacion();
          const direccionResidenciaValida = validarDireccionResidencia();
          const especialidadValida = validarEspecialidad();
          const semestreValido = validarSemestre();
          const turnoValido = validarTurno();
          const seccionValida = validarSeccion();
          const correoValido = validarCorreo();

          return solicitudValida &&
            beneficioValido &&
            fechaValida &&
            nombreValido &&
            nacimientoValido &&
            fechaNacimientoValida &&
            edadValida &&
            estadoCivilValido &&
            ciValido &&
            telefonoValido &&
            trabajaValido &&
            ocupacionValida &&
            lugarTrabajoValido &&
            sueldoValido &&
            cargaFamiliarValida &&
            hijosValido &&
            direccionHabitacionValida &&
            direccionResidenciaValida &&
            especialidadValida &&
            semestreValido &&
            turnoValido &&
            seccionValida &&
            correoValido;
        }

        if (!validarFormularioExoneracion()) {
          toastr.error("El formulario del Estudio Socio-Economico tiene errores.", "Error");
          event.preventDefault();
          return;
        }

      }
    });
  });

  //-----------------------------------------------------------------------------
  const form = document.getElementById('FormularioExoneracion');

  form.addEventListener('submit', function(event) {
    const idBenefValidar = validarBeneficiarioEx();
    const motivoValido = validarMotivoEx();
    const discapacidadValido = validarDiscapacitado();
    const cartaValida = validarCarta();

    if (!motivoValido || !discapacidadValido || !cartaValida || !idBenefValidar) {
      toastr.error("Formulario no enviado, revise los campos nuevamente.", "Error");
      event.preventDefault();
    }
  });

  document.getElementById('btnCancelarE').addEventListener('click', function() {
    form.reset();
    eliminarTodosErrores();
  });

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
  //------------------------------------------ FAMES---------------------------------

  function validarBeneficiarioFames() {
    const beneficiarioFames = document.getElementById('id_beneficiario_fames');
    const beneficiarioErrorFames = document.getElementById('beneficiario_error_fames');

    if (beneficiarioFames.value === "") {
      beneficiarioErrorFames.textContent = 'Por favor, ingrese un beneficiario.';
      return false;
    } else {
      beneficiarioErrorFames.textContent = '';
      return true;
    }
  }

  function validarPatologia() {
    const patologia = document.getElementById('patologia');
    const patologiaError = document.getElementById('patologia_error');

    if (patologia.value === "") {
      patologiaError.textContent = 'Por favor, ingrese una patologia.';
      return false;
    } else {
      patologiaError.textContent = '';
      return true;
    }
  }

  function validarTipoAyuda() {
    const tipoAyuda = document.getElementById('tipo_ayuda');
    const tipoAyudaError = document.getElementById('tipo_ayuda_error');

    if (tipoAyuda.value === "") {
      tipoAyudaError.textContent = 'Por favor, ingrese un tipo de ayuda.';
      return false;
    } else {
      tipoAyudaError.textContent = '';
      return true;
    }
  }

  function validarOtroTipo() {
    const otroTipo = document.getElementById('otro_tipo').value.trim();
    const otroTipoError = document.getElementById('otro_tipo_error');

    if (otroTipo.length < 3) {
      otroTipoError.textContent = 'Por favor, especifique el tipo de ayuda.';
      return false;
    } else {
      otroTipoError.textContent = '';
      return true;
    }
  }

  document.getElementById('nombre_beneficiario_fames').addEventListener('input', validarBeneficiarioFames);
  document.getElementById('patologia').addEventListener('input', validarPatologia);
  document.getElementById('tipo_ayuda').addEventListener('input', validarTipoAyuda);
  document.getElementById('otro_tipo').addEventListener('input', validarOtroTipo);

  const formFames = document.getElementById('formularioFames');

  formFames.addEventListener('submit', function(event) {

    const beneficiarioFamesValido = validarBeneficiarioFames();
    const patologiaValida = validarPatologia();
    const tipoAyudaValido = validarTipoAyuda();

    if (!beneficiarioFamesValido || !patologiaValida || !tipoAyudaValido) {
      toastr.error("Formulario no enviado, patologia o tipo de ayuda no seleccionados.", "Error");
      event.preventDefault();
    }
  });

  document.getElementById('btnCancelarF').addEventListener('click', function() {
    formFames.reset();
    eliminarTodosErrores();
  });