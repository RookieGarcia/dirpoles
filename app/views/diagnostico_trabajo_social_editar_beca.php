<?php
$title = "Becas - Editar";
$nivel1 = "diagnostico";
$nivel2 = "trabajo_social";
include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include 'template/header.php';
    include 'template/sidebar.php'; ?>

    <!-- CONTENIDO -->
    <div class="content-wrapper">
      <section class="content mb-4">
        <button class="btn btn-info ml-2 mt-4" onclick="window.location.href = 'index.php?action=vista_trabajo_social'"><i
            class="fas fa-home"></i> Inicio</button>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-header bg-navy">
              <h3 class="card-title text-center">Editar Beca</h3>
            </div>
            <form id="FormularioEditarBeca" method="POST" action="index.php?action=editar_beca"
              enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $bd['id_becas']; ?>">
              <input type="hidden" name="imagen_actual" value="<?php echo $bd['direccion_pdf']; ?>">
              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_beneficiario" class="form-label">Beneficiario:</label>
                      <input type="text" id="nombre_beneficiario"
                        value="<?php echo $bd['nombres'] . ' ' . $bd['apellidos'] . ' - ' . $bd['cedula']; ?>"
                        class="form-control" placeholder="Beneficiario seleccionado" disabled>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_servicios" class="form-label">Servicio de:</label>
                      <input type="text" id="id_servicios"
                        value="<?php echo htmlspecialchars($bd['nombre_serv']); ?>"
                        class="form-control" placeholder="Servicio seleccionado" disabled>
                    </div>
                  </div>
                </div>


                <div class="form-group">
                  <label for="planilla">Planilla de Inscripción:</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="planilla" id="planilla" accept="application/pdf"
                        class="custom-file-input">
                      <label class="custom-file-label" for="planilla">Seleccionar archivo</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="tipo_banco">Tipo de Banco:</label>
                  <select class="form-control" id="tipo_banco" name="tipo_banco" required>
                    <option value="" disabled>Seleccione un banco...</option>
                    <?php
                    $bancos = [
                      '0102' => 'BANCO DE VENEZUELA',
                      '0156' => '100% BANCO',
                      '0172' => 'BANCAMIGA BANCO MICROFINANCIERO C A',
                      '0114' => 'BANCARIBE',
                      '0171' => 'BANCO ACTIVO',
                      '0166' => 'BANCO AGRICOLA DE VENEZUELA',
                      '0175' => 'BANCO BICENTENARIO DEL PUEBLO',
                      '0128' => 'BANCO CARONI',
                      '0163' => 'BANCO DEL TESORO',
                      '0115' => 'BANCO EXTERIOR',
                      '0151' => 'BANCO FONDO COMUN',
                      '0173' => 'BANCO INTERNACIONAL DE DESARROLLO',
                      '0105' => 'BANCO MERCANTIL',
                      '0191' => 'BANCO NACIONAL DE CREDITO',
                      '0138' => 'BANCO PLAZA',
                      '0137' => 'BANCO SOFITASA',
                      '0104' => 'BANCO VENEZOLANO DE CREDITO',
                      '0168' => 'BANCRECER',
                      '0134' => 'BANESCO',
                      '0177' => 'BANFANB',
                      '0146' => 'BANGENTE',
                      '0174' => 'BANPLUS',
                      '0108' => 'BBVA PROVINCIAL',
                      '0157' => 'DELSUR BANCO UNIVERSAL',
                      '0169' => 'MI BANCO',
                      '0178' => 'N58 BANCO DIGITAL BANCO MICROFINANCIERO S.A',
                    ];

                    foreach ($bancos as $codigo => $nombre) {
                      $selected = ($bd['tipo_banco'] == $codigo) ? 'selected' : '';
                      echo "<option value=\"$codigo\" $selected>$nombre</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="ctabcv">Cuenta BCV:</label>
                  <input type="text" name="ctabcv" id="ctabcv_editar" value="<?php echo $bd['cta_bcv']; ?>"
                    class="form-control" required maxlength="16">
                  <div id="ctabcv-error" class="text-danger"></div>
                </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Actualizar</button>
                            <a href="index.php?action=consulta_trabajo_social&seleccion=becas" class="btn btn-danger w-50">Cancelar</a>
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
  <script src="dist/js/diagnosticos/trabajador_social/editar_beca.js"></script>
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
  <script src="dist/js/crear_ts.js" defer></script>


</body>

</html>