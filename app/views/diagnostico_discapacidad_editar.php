<?php
    $title = "Discapacidad - Editar";
    $nivel1 = "diagnostico";
    $nivel2 = "discapacidad";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

  <!-- CONTENIDO -->
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
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header bg-navy">
            <h3 class="card-title">Edición de consulta de Discapacidad</h3>
          </div>
          <form action="index.php?action=discapacidad_actualizar" method="POST" class="form-horizontal">
            <div class="card-body">
              <div class="w-100">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-start">
                        <input type="hidden" name="id_discapacidad" value="<?php echo htmlspecialchars($discapacidad['id_discapacidad']); ?>">
                        <a class="btn btn-primary w-100" href="index.php?action=discapacidad_listar">Regresar</a>
                    </div>

                    <div class="col-md-4 d-flex justify-content-start">
                      <input type="text" disabled value="Discapacidad" class="form-control w-100">
                    </div>

                    <div class="col-md-4 d-flex justify-content-start">
                        <div class="w-100">
                            <input type="text" id="nombre_beneficiario" class="form-control" value="<?php echo $discapacidad['nombre_beneficiario'] . ' ' . $discapacidad['apellido_beneficiario'] . ' - ' . $discapacidad['cedula']; ?>" disabled>
                            <div id="nombre_beneficiarioerror" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div id="nombre_beneficiarioerror" class="text-danger"></div>
              </div>

              <div class="form-group">
                <label for="Condicion_medica">Condición Médica</label>
                <textarea class="form-control" id="Condicion_medica" name="condicion_medica" rows="3" required><?php echo $discapacidad['condicion_medica']; ?></textarea>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label for="Cirugia_prev">¿Ha tenido cirugía previa?</label>
                    <select class="form-control" id="cirugia_prev" name="cirugia_prev" required>
                        <option value="No" <?php echo ($discapacidad['cirugia_prev'] == 'No') ? 'selected' : ''; ?>>No</option>
                        <option value="Sí" <?php echo ($discapacidad['cirugia_prev'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                    </select>
                </div>
                <div class="col-md-6">
                  <label for="Toma_medicamentos_regularmente">¿Toma medicamentos regularmente?</label>
                    <select class="form-control" id="toma_medicamentos_regularmente" name="toma_medicamentos_reg">
                        <option value="No" <?php echo ($discapacidad['toma_medicamentos_reg'] == 'No') ? 'selected' : ''; ?>>No</option>
                        <option value="Sí" <?php echo ($discapacidad['toma_medicamentos_reg'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                    </select>
                </div>
              </div>

              <div class="form-group">
                <label for="Naturaleza_discapacidad">Naturaleza de la Discapacidad</label>
                <textarea class="form-control" id="Naturaleza_discapacidad" name="naturaleza_discapacidad" rows="3" placeholder="Describa la naturaleza de la discapacidad" required><?php echo $discapacidad['naturaleza_discapacidad']; ?></textarea>
              </div>

              <div class="form-group">
                <label for="Impacto_disc">Impacto de la Discapacidad</label>
                <textarea class="form-control" id="Impacto_disc" name="impacto_disc" rows="3" placeholder="Describa el impacto de la discapacidad" required><?php echo $discapacidad['impacto_disc']; ?></textarea>
              </div>

              <div class="form-group">
                <label for="Habilidades_funcionales_beneficiario">Habilidades Funcionales del Beneficiario</label>
                <textarea class="form-control" id="Habilidades_funcionales_beneficiario" name="habilidades_funcionales_b" rows="3" placeholder="Describa las habilidades funcionales" required><?php echo $discapacidad['habilidades_funcionales_b']; ?></textarea>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label for="Requiere_asistencia">¿Requiere asistencia?</label>
                    <select class="form-control" id="Requiere_asistencia" name="requiere_asistencia">
                        <option value="No" <?php echo ($discapacidad['requiere_asistencia'] == 'No') ? 'selected' : ''; ?>>No</option>
                        <option value="Sí" <?php echo ($discapacidad['requiere_asistencia'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                    </select>
                </div>
              </div>

              <div class="form-group">
                <label for="Dispositivos_asistencia">Dispositivos de Asistencia</label>
                <textarea class="form-control" id="Dispositivos_asistencia" name="dispositivos_asistencia" rows="3" placeholder="Describa los dispositivos de asistencia" required><?php echo $discapacidad['dispositivo_asistencia']; ?></textarea>
              </div>

              <div class="form-group">
                <label for="Salud_mental">Salud Mental</label>
                <textarea class="form-control" id="Salud_mental" name="salud_mental" rows="3" placeholder="Describa la condición de salud mental" required><?php echo $discapacidad['salud_mental']; ?></textarea>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label for="Recibe_apoyo_psicologico">¿Recibe apoyo psicológico?</label>
                    <select class="form-control" id="Recibe_apoyo_psicologico" name="apoyo_psicologico">
                        <option value="No" <?php echo ($discapacidad['apoyo_psicologico'] == 'No') ? 'selected' : ''; ?>>No</option>
                        <option value="Sí" <?php echo ($discapacidad['apoyo_psicologico'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                    </select>

                </div>
                <div class="col-md-6">
                  <label for="carnet_discapacidad">Carnet de Discapacidad:</label>
                  <input type="text" class="form-control" value="<?php echo $discapacidad['carnet_discapacidad']; ?>" name="carnet_discapacidad">
                </div>
              </div>
              <div class="row">
                  <div class="col-md-6"></div>
                  <div class="col-md-6">
                      <div class="btn-group w-100">
                          <button type="submit" class="btn btn-success w-50">Actualizar</button>
                      </div>
                  </div>
              </div>
            </div>
          </form>
        </div>

      </div>
    </section>
  </div>
  <!-- CONTENIDO -->

  
  <?php include 'template/footer.php'; ?>
  
</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->

<script src="dist/js/diagnosticos/discapacidad/editar.js"></script>

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
