<?php
$title = "Reportes - General";
$nivel1 = "reportes";
$nivel2 = "general";
include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include 'template/header.php';
    include 'template/sidebar.php'; ?>

    <!-- CONTENIDO -->
    <div class="content-wrapper">
      <!-- Título de la sección -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1>Bienvenio al área de reportes</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Formulario para generar reportes dentro de una tarjeta (card) -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-navy">
                  <h3 class="card-title">Reporte general del sistema</h3>
                </div>
                <div class="card-body">
                  <form id="form-reporte" class="form-horizontal" novalidate>
                    <div class="form-group row">
                      <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha de inicio:</label>
                      <div class="col-sm-10">
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                        <div id="error_fecha_inicio" class="text-danger"></div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha fin:</label>
                      <div class="col-sm-10">
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                        <div id="error_fecha_fin" class="text-danger"></div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Botones de exportación dentro de una tarjeta -->
          <div id="botones-exportacion" class="mb-3"></div>

          <div id="contenedor_general" class="row" style="display:none;">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-navy">
                  <h3 class="card-title">Resultados del Reporte</h3>
                </div>
                <div class="card-body">
                  <table id="tabla_general" class="table table-bordered table-striped table-hover text-center">
                    <thead>
                      <tr class="bg-navy">
                        <th>Fecha</th>
                        <th>Nombres</th>
                        <th>Cedula</th>
                        <th>PNF</thd>
                        <th>Area</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>

      <div class="modal fade" id="modalBeneficiario" tabindex="-1" role="dialog"
        aria-labelledby="modalBeneficiarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-navy">
              <h5 class="modal-title" id="modalBeneficiarioLabel">Seleccionar Beneficiario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Tabla de Beneficiarios -->
              <table class="table table-bordered table-hover">
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
                          data-nombre="<?php echo htmlspecialchars($beneficiario['nombres']); ?>"
                          data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>">
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

    </div>

    <!-- CONTENIDO -->

    <?php include 'template/footer.php'; ?>

  </div>

  <?php include 'template/script.php'; ?>
  <!-- SCRIPT PERSONALIZADOS -->
  <script src="dist/js/reportes/general.js"></script>

</body>

</html>