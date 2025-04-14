<?php
$title = "Exoneracion - Editar";
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
              <h1>Exoneracion: Editar</h1>
            </div>
          </div>
        </div>
      </section>
      <section>
        <button class="btn btn-info ml-3" onclick="window.location.href = 'index.php?action=vista_trabajo_social'"><i
            class="fas fa-home"></i> Inicio</button><br><br><br><br>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-header bg-navy">
              <h3 class="card-title text-center">Editar Exoneración</h3>
            </div>

            <form id="FormularioExoneracion" method="POST" action="index.php?action=editar_ex" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $bd['id_exoneracion']; ?>">
              <input type="hidden" name="direccion_carta" value="<?php echo $bd['direccion_carta']; ?>">
              <input type="hidden" name="direccion_estudiose" value="<?php echo $bd['direccion_estudiose']; ?>">
              <input type="hidden" name="otro_motivo" value="<?php echo $bd['otro_motivo']; ?>">

              <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_beneficiario" class="form-label">Beneficiario:</label>
                      <input type="text" id="nombre_beneficiario" value="<?php echo $bd['nombres'] . ' ' . $bd['apellidos'] . ' - ' . $bd['cedula']; ?>"
                        class="form-control" placeholder="Beneficiario seleccionado" disabled>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_servicios" class="form-label">Servicio de:</label>
                      <input type="text" id="id_servicios" value="<?php echo htmlspecialchars($bd['nombre_serv']); ?>"
                        class="form-control" placeholder="Servicio seleccionado" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="motivo_ex">Motivo:</label>
                      <select id="motivo_ex" name="motivo_ex" class="form-control">
                        <option disabled>Seleccione un motivo:</option>
                        <option value="inscripcion" <?php if ($bd['motivo'] == 'inscripcion') echo 'selected'; ?>>Inscripción</option>
                        <option value="pqt_grado" <?php if ($bd['motivo'] == 'pqt_grado') echo 'selected'; ?>>Paquete de Grado</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="carta">Carta:</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="carta" id="carta" accept="application/pdf" class="custom-file-input">
                          <label class="custom-file-label" for="carta">Seleccionar archivo</label>
                        </div>
                      </div>
                      <div id="carta_error" class="text-danger"></div>
                    </div>
                  </div>

                  <?php if ($bd['otro_motivo'] == 'si') { ?>
                  <div class="col-md-4" id="carnetDiscapacitado">
                    <div class="form-group">
                      <label>Carnet de Discapacidad:</label>
                      <div class="input-group">
                        <input type="text" name="carnet_discapacidad" id="carnet_discapacidad" class="form-control" oninput="mantenerPrefijo(event)" onkeypress="soloNumeros(event)" value="<?php echo 'D- ' . str_replace('D- ', '', $bd['carnet_discapacidad']); ?>">
                      </div>
                      <div id="carnet_discapacidad_error" class="text-danger"></div>
                    </div>
                  </div>
                </div>
                <?php }?>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Actualizar</button>
                            <a href="index.php?action=consulta_trabajo_social&seleccion=exoneracion" class="btn btn-danger w-50">Cancelar</a>
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

  <script src="dist/js/diagnosticos/trabajador_social/editar_ex.js"></script>
  
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