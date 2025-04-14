<?php
$title = "FAMES - Editar";
$nivel1 = "diagnostico";
$nivel2 = "trabajo_social";
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
              <h1>FAMES: Editar</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content mb-4">
        <button class="btn btn-info ml-3" onclick="window.location.href = 'index.php?action=vista_trabajo_social'"><i
            class="fas fa-home"></i> Inicio</button>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-header bg-navy">
              <h3 class="card-title text-center">Editar FAMES</h3>
            </div>
            <form method="POST" action="index.php?action=editar_fames" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $bd['id_fames']; ?>">
              <input type="hidden" name="id_detalle_patologia" value="<?php echo htmlspecialchars($bd['id_detalle_patologia']); ?>">

              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_beneficiario" class="form-label">Beneficiario:</label>
                      <input type="text" id="nombre_beneficiario"
                        value="<?php echo $bd['nombres'] . ' ' . $bd['apellidos'] . ' - ' . $bd['cedula']; ?>"
                        class="form-control input-ajustado" placeholder="Beneficiario seleccionado" disabled>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_servicios" class="form-label">Servicio de:</label>
                      <input type="text" id="id_servicios" class="form-control"
                        value="<?php echo htmlspecialchars($bd['nombre_serv']); ?>" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="patologia" class="form-label">Patología:</label>
                      <select name="patologia" id="patologia" class="form-control" required>
                        <?php foreach ($funcion as $tipo): ?>
                          <option value="<?php echo $tipo['id_patologia']; ?>" <?php echo ($bd['id_patologia'] == $tipo['id_patologia']) ? 'selected' : ''; ?>>
                            <?php echo $tipo['nombre_patologia']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <div id="patologia_error" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tipo_ayuda" class="form-label">Tipo de Ayuda:</label>
                      <select id="tipo_ayuda" name="tipo_ayuda" class="form-control">
                        <option disabled>Seleccione un tipo de ayuda:</option>
                        <option value="economica" <?php if ($bd['tipo_ayuda'] == 'economica') echo 'selected'; ?>>Económica</option>
                        <option value="operaciones" <?php if ($bd['tipo_ayuda'] == 'operaciones') echo 'selected'; ?>>Operaciones</option>
                        <option value="examenes" <?php if ($bd['tipo_ayuda'] == 'examenes') echo 'selected'; ?>>Exámenes</option>
                        <option value="otros" <?php if ($bd['tipo_ayuda'] == 'otros') echo 'selected'; ?>>Otros</option>
                      </select>
                      <div id="tipo_ayuda_error" class="text-danger"></div>
                    </div>
                  </div>
                </div>

                <div class="row"  id="campoOtros" style="display: none;">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="otro_tipo" class="form-label">Especifique:</label>
                      <input type="text" name="otro_tipo" id="otro_tipo" value="<?php echo $bd['otro_tipo']; ?>" class="form-control">
                      <div id="otro_tipo_error" class="text-danger"></div>
                    </div>
                  </div>

                </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Actualizar</button>
                            <a href="index.php?action=consulta_trabajo_social&seleccion=fames" class="btn btn-danger w-50">Cancelar</a>
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
  <script src="dist/js/diagnosticos/trabajador_social/editar_fames.js"></script>


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