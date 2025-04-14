<?php
    $title = "Diagnosticos - Discapacidad";
    $nivel1 = "diagnostico";
    $nivel2 = "discapacidad";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>


  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Bienvenido al área de Discapacidad</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content mt-2">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header bg-navy">
            <h3 class="card-title">Registro de consulta de Discapacidad</h3>
          </div>
          <form action="index.php?action=discapacidad_registrar" method="POST" class="form-horizontal" onsubmit="return validarFormulario()">
          <div class="card-body">
              
                <div class="row mb-3">
                    <div class="col-md-4 d-flex justify-content-start">
                        <input type="hidden" name="id_servicios" value="<?php echo htmlspecialchars($servicios['id_servicios']); ?>">
                        <a class="btn btn-primary w-100" href="index.php?action=discapacidad_listar">Consultar</a>
                    </div>
                    <div class="col-md-4 d-flex justify-content-start">
                        <button type="button" class="btn btn-info w-100" data-toggle="modal" data-target="#modalBeneficiario">Seleccionar Beneficiario</button>
                    </div>
                    <div class="col-md-4 d-flex justify-content-start">
                        <input type="hidden" name="id_beneficiario" id="id_beneficiario">
                        <div class="w-100">
                            <input type="text" id="nombre_beneficiario" class="form-control" placeholder="Beneficiario seleccionado" disabled>
                            <div id="nombre_beneficiarioerror" class="text-danger"></div>
                        </div>
                    </div>
                </div>

              
                <div class="form-group">
                    <label for="Condicion_medica">Condición Médica</label>
                    <textarea class="form-control" id="Condicion_medica" name="condicion_medica" rows="3" placeholder="Describa la condición médica"></textarea>
                    <div id="Condicion_medicaerror" class="text-danger"></div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="cirugia_prev">¿Ha tenido cirugía previa?</label>
                        <select class="form-control" id="cirugia_prev" name="cirugia_prev">
                            <option value="">Seleccione</option>
                            <option value="No" selected>No</option>
                            <option value="Sí">Sí</option>
                        </select>
                        <div id="cirugia_preverror" class="text-danger"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="toma_medicamentos_regularmente">¿Toma medicamentos regularmente?</label>
                        <select class="form-control" id="toma_medicamentos_regularmente" name="toma_medicamentos_reg">
                            <option value="">Seleccione</option>
                            <option value="No" selected>No</option>
                            <option value="Sí">Sí</option>
                        </select>
                        <div id="toma_medicamentos_regularmenteerror" class="text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Naturaleza_discapacidad">Naturaleza de la Discapacidad</label>
                    <textarea class="form-control" id="Naturaleza_discapacidad" name="naturaleza_discapacidad" rows="3" placeholder="Describa la naturaleza de la discapacidad"></textarea>
                    <div id="Naturaleza_discapacidaderror" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <label for="Impacto_disc">Impacto de la Discapacidad</label>
                    <textarea class="form-control" id="Impacto_disc" name="impacto_disc" rows="3" placeholder="Describa el impacto de la discapacidad"></textarea>
                    <div id="Impacto_discerror" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <label for="Habilidades_funcionales_beneficiario">Habilidades Funcionales del Beneficiario</label>
                    <textarea class="form-control" id="Habilidades_funcionales_beneficiario" name="habilidades_funcionales_b" rows="3" placeholder="Describa las habilidades funcionales"></textarea>
                    <div id="Habilidades_funcionales_beneficiarioerror" class="text-danger"></div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="Requiere_asistencia">¿Requiere asistencia?</label>
                        <select class="form-control" id="Requiere_asistencia" name="requiere_asistencia">
                            <option value="">Seleccione</option>
                            <option value="No" selected>No</option>
                            <option value="Sí">Sí</option>
                        </select>
                        <div id="Requiere_asistenciaerror" class="text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Dispositivos_asistencia">Dispositivos de Asistencia</label>
                    <textarea class="form-control" id="Dispositivos_asistencia" name="dispositivos_asistencia" rows="3" placeholder="Describa los dispositivos de asistencia"></textarea>
                    <div id="Dispositivos_asistenciaerror" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <label for="Salud_mental">Salud Mental</label>
                    <textarea class="form-control" id="Salud_mental" name="salud_mental" rows="3" placeholder="Describa la condición de salud mental"></textarea>
                    <div id="Salud_mentalerror" class="text-danger"></div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="Recibe_apoyo_psicologico">¿Recibe apoyo psicológico?</label>
                        <select class="form-control" id="Recibe_apoyo_psicologico" name="apoyo_psicologico">
                            <option value="">Seleccione</option>
                            <option value="No" selected>No</option>
                            <option value="Sí">Sí</option>
                        </select>
                        <div id="Recibe_apoyo_psicologicoerror" class="text-danger"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="carnet_discapacidad">Carnet de Discapacidad:</label>
                          <input type="text" name="carnet_discapacidad" value="D- " id="carnet_discapacidad" class="form-control" oninput="mantenerPrefijo(event)" onkeypress="soloNumeros(event)">
                        <div id="carnet_discapacidad_error" class="text-danger"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Registrar</button>
                            <input type="reset" class="btn btn-danger w-50" value="Limpiar">
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>

      </div>
    </section>
  </div>



<div class="modal fade" id="modalBeneficiario" tabindex="-1" role="dialog" aria-labelledby="modalBeneficiarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header bg-navy">
              <h5 class="modal-title" id="modalBeneficiarioLabel">Seleccionar Beneficiario</h5>
              <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            
              <table id="tabla_beneficiarios" class="table table-bordered table-hover">
                  <thead>
                      <tr class="bg-navy"> 
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Cédula</th>
                          <th>PNF</th>
                          <th>Acción</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($beneficiarios as $beneficiario): ?>
                          <tr>
                              <td><?php echo htmlspecialchars($beneficiario['nombres']); ?></td>
                              <td><?php echo htmlspecialchars($beneficiario['apellidos']); ?></td>
                              <td><?php echo htmlspecialchars($beneficiario['cedula']); ?></td>
                              <td><?php echo htmlspecialchars($beneficiario['nombre_pnf']); ?></td>
                              <td>
                                  <button type="button" class="btn btn-primary btn-select-beneficiario" 
                                          data-id="<?php echo $beneficiario['id_beneficiario']; ?>" 
                                          data-nombre="<?php echo htmlspecialchars($beneficiario['nombres']); ?>" data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>">
                                      Seleccionar
                                  </button>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
  </div>
</div>

  
  <?php include 'template/footer.php'; ?>
  
</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->

<script src="dist/js/diagnosticos/discapacidad/crear.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelectorAll('.btn-select-beneficiario').forEach(button => {
        button.addEventListener('click', function() {
          
            const idBeneficiario = this.getAttribute('data-id');
            const nombreBeneficiario = this.getAttribute('data-nombre') + ' ' + this.getAttribute('data-apellido');

        
            document.getElementById('id_beneficiario').value = idBeneficiario;
            document.getElementById('nombre_beneficiario').value = nombreBeneficiario;

         
            document.getElementById('nombre_beneficiarioerror').innerHTML = '';

            $('#modalBeneficiario').modal('hide');
        });
    });
});
</script>

<?php if (isset($_SESSION['mensaje'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($_SESSION['tipo_mensaje'] === 'error'): ?>
                toastr.error("<?php echo $_SESSION['mensaje']; ?>", "Error");
            <?php elseif ($_SESSION['tipo_mensaje'] === 'exito'): ?>
                toastr.success("<?php echo $_SESSION['mensaje']; ?>", "Excelente");
            <?php endif; ?>
        });

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "3000"
        }
    </script>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
<?php endif; ?>

</body>
</html>
