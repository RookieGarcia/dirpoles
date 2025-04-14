<?php
$title = "Diagnosticos - Trabajo Social";
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
              <h1>Bienvenido al área de Trabajo Social</h1>
            </div>
          </div>
        </div>
      </section>

      <section>
        <button class="btn btn-info ml-3" onclick="window.location.href = 'index.php?action=consulta_trabajo_social'">
          <i class="fas fa-user-plus"></i> Consultas
        </button>
      </section>

      <section class="content mt-3">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-md-5">
              <div class="form-group">
                <label for="ts">Selecciona una opción:</label>
                <select id="ts" name="ts" class="form-control" onchange="mostrarFormularioCrear(this.value)">
                  <option value="" selected disabled>Selecciona una opción</option>
                  <option value="becas">Becas</option>
                  <option value="exoneracion">Exoneración</option>
                  <option value="fames">F.A.M.E.S</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="content" id="formulario-becas" style="display: none;">
        <div class="form-section">
          <form id="FormularioBecas" action="index.php?action=crear_beca" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="formulario" value="becas">
            <div class="card">
              <div class="card-header bg-navy">
                <h3 class="card-title">Formulario Becas</h3>
              </div>
              <div class="card-body">

                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="id_beneficiario" class="col-form-label">Beneficiario</label>
                    <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalBeneficiarioBecas">
                      Seleccionar Beneficiario
                    </button>
                    <input type="hidden" name="id_beneficiario_becas" id="id_beneficiario_becas">
                    <input type="text" id="nombre_beneficiario_becas" class="form-control mt-2"
                      placeholder="Beneficiario seleccionado" disabled>
                    <div id="id_beneficiario_error" class="text-danger"></div>
                  </div>

                  <div class="col-md-4">
                    <label for="id_servicios" class="col-form-label">Servicio de:</label>
                    <input type="hidden" name="id_servicios_beca" value="<?php echo $servicios['id_servicios']; ?>">
                    <input type="text" id="id_servicios" class="form-control"
                      value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled>
                  </div>

                  <div class="col-md-4">
                    <label for="planilla" class="col-form-label">Planilla</label>
                    <input type="file" name="planilla" id="planilla" class="form-control" accept="application/pdf">
                    <div id="planilla_error" class="text-danger"></div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="tipo_banco" class="col-form-label">Tipo de Banco</label>
                    <select class="form-control" id="tipo_banco" name="tipo_banco">
                      <option value="" disabled selected>Seleccione un banco...</option>
                      <option value="0102">BANCO DE VENEZUELA</option>
                      <option value="0156">100% BANCO</option>
                      <option value="0172">BANCAMIGA BANCO MICROFINANCIERO C A</option>
                      <option value="0114">BANCARIBE</option>
                      <option value="0171">BANCO ACTIVO</option>
                      <option value="0166">BANCO AGRICOLA DE VENEZUELA</option>
                      <option value="0175">BANCO BICENTENARIO DEL PUEBLO</option>
                      <option value="0128">BANCO CARONI</option>
                      <option value="0163">BANCO DEL TESORO</option>
                      <option value="0115">BANCO EXTERIOR</option>
                      <option value="0151">BANCO FONDO COMUN</option>
                      <option value="0173">BANCO INTERNACIONAL DE DESARROLLO</option>
                      <option value="0105">BANCO MERCANTIL</option>
                      <option value="0191">BANCO NACIONAL DE CREDITO</option>
                      <option value="0138">BANCO PLAZA</option>
                      <option value="0137">BANCO SOFITASA</option>
                      <option value="0104">BANCO VENEZOLANO DE CREDITO</option>
                      <option value="0168">BANCRECER</option>
                      <option value="0134">BANESCO</option>
                      <option value="0177">BANFANB</option>
                      <option value="0146">BANGENTE</option>
                      <option value="0174">BANPLUS</option>
                      <option value="0108">BBVA PROVINCIAL</option>
                      <option value="0157">DELSUR BANCO UNIVERSAL</option>
                      <option value="0169">MI BANCO</option>
                      <option value="0178">N58 BANCO DIGITAL BANCO MICROFINANCIERO S A</option>
                    </select>
                    <div id="tipo_banco_error" class="text-danger"></div>
                  </div>

                  <div class="col-md-6">
                    <label for="ctabcv" class="col-form-label">Número de Cuenta</label>
                    <input type="text" name="ctabcv" id="ctabcv" class="form-control" maxlength="16" onkeypress="soloNumeros(event)">
                    <div id="ctabcv_error" class="text-danger"></div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Registrar</button>
                            <input type="reset" class="btn btn-danger w-50" id="btnCancelarB" value="Limpiar">
                        </div>
                    </div>
                </div>

              </div>
          </form>
        </div>
      </section>

      <div class="modal fade" id="modalBeneficiarioBecas" tabindex="-1" role="dialog"
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
                          data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>"
                          data-formulario="formularioB">
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

      <section id="formulario-exoneracion" style="display: none;">
        <div class="container-fluid">
          <form id="FormularioExoneracion" action="index.php?action=crear_exoneracion" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="formulario" value="exoneracion">

            <div class="card">
              <div class="card-header bg-navy">
                <h3 class="card-title">Formulario Exoneración</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="id_beneficiario" class="col-form-label">Beneficiario</label>
                      <button type="button" class="btn btn-info w-100 mb-2" data-toggle="modal" data-target="#modalBeneficiarioEx">
                        Seleccionar Beneficiario
                      </button>
                      <input type="hidden" name="id_beneficiario_ex" id="id_beneficiario_ex">
                      <input type="text" id="nombre_beneficiario_ex" class="form-control" placeholder="Beneficiario seleccionado" disabled>
                      <div id="id_beneficiario_error_ex" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="id_servicios" class="col-form-label">Servicio de</label>
                      <input type="hidden" name="id_servicios_ex" value="<?php echo $servicios['id_servicios']; ?>">
                      <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="motivo_ex" class="col-form-label">Motivo</label>
                      <select id="motivo_ex" name="motivo_ex" class="form-control">
                        <option value="" disabled selected>Seleccione un motivo</option>
                        <option value="inscripcion">Inscripción</option>
                        <option value="pqt_grado">Paquete de Grado</option>
                      </select>
                      <div id="motivo_ex_error" class="text-danger"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="carta" class="col-form-label">Carta</label>
                      <input type="file" id="carta" name="carta" class="form-control" accept="application/pdf">
                      <div id="carta_error" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group text-center">
                      <label class="col-form-label">Discapacitado</label>
                      <div class="d-flex justify-content-center">
                        <div class="form-check mr-3">
                          <input type="radio" value="si" name="discapacitado" id="siRadioDiscapacitado" class="form-check-input">
                          <label class="form-check-label" for="siRadioDiscapacitado">Sí</label>
                        </div>
                        <div class="form-check">
                          <input type="radio" value="no" name="discapacitado" id="noRadioDiscapacitado" class="form-check-input">
                          <label class="form-check-label" for="noRadioDiscapacitado">No</label>
                        </div>
                      </div>
                      <div id="discapacitado_error" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="col-md-4" id="carnetDiscapacitado" style="display: none;">
                    <div class="form-group">
                      <label class="col-form-label">Carnet de Discapacidad</label>
                      <div class="form-group">
                        <input type="text" name="carnet_discapacidad" value="D- " id="carnet_discapacidad" class="form-control" oninput="mantenerPrefijoCE(event)" onkeypress="soloNumeros(event)">
                      </div>
                      <div id="carnet_discapacidad_error" class="text-danger"></div>
                    </div>
                  </div>
                </div>

                <div class="col-12" id="seleccionEstudioSE" style="display: none;">
                  <div class="form-group">
                    <?php require_once("PDF/EstudioSE/Formulario.php"); ?>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Registrar</button>
                            <input type="reset" class="btn btn-danger w-50" id="btnCancelarE" value="Limpiar">
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </section>

      <div class="modal fade" id="modalBeneficiarioEx" tabindex="-1" role="dialog"
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
                          data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>"
                          data-formulario="formularioEx">
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

      <section id="formulario-fames" style="display: none;">
        <div class="container-fluid">
          <form id="formularioFames" action="index.php?action=crear_fames" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="formulario" value="fames">

            <div class="card">
              <div class="card-header bg-navy">
                <h3 class="card-title">Formulario FAMES</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="id_beneficiario" class="col-form-label">Beneficiario</label>
                      <button type="button" class="btn btn-info w-100 mb-2" data-toggle="modal" data-target="#modalBeneficiarioF">
                        Seleccionar Beneficiario
                      </button>
                      <input type="hidden" name="id_beneficiario_fames" id="id_beneficiario_fames">
                      <input type="text" id="nombre_beneficiario_fames" class="form-control" placeholder="Beneficiario seleccionado" disabled>
                      <div id="beneficiario_error_fames" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="id_servicios" class="col-form-label">Servicio de</label>
                      <input type="hidden" name="id_servicios_fames" value="<?php echo $servicios['id_servicios']; ?>">
                      <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="patologia" class="col-form-label">Patología</label>
                      <select id="patologia" name="patologia" class="form-control">
                        <option value="" disabled selected>Selecciona una patología</option>
                        <?php foreach ($funcion as $tipo): ?>
                          <option value="<?php echo $tipo['id_patologia']; ?>"><?php echo $tipo['nombre_patologia']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <div id="patologia_error" class="text-danger"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="tipo_ayuda" class="col-form-label">Tipo de ayuda</label>
                      <select id="tipo_ayuda" name="tipo_ayuda" class="form-control">
                        <option value="" disabled selected>Seleccione un tipo de ayuda</option>
                        <option value="economica">Económica</option>
                        <option value="operaciones">Operaciones</option>
                        <option value="examenes">Exámenes</option>
                        <option value="otros">Otros</option>
                      </select>
                      <div id="tipo_ayuda_error" class="text-danger"></div>
                    </div>
                  </div>

                  <div class="col-md-4" id="campoOtros" style="display: none;">
                    <div class="form-group">
                      <label for="otro_tipo" class="col-form-label">Especifique</label>
                      <input type="text" class="form-control" id="otro_tipo" name="otro_tipo">
                      <div id="otro_tipo_error" class="text-danger"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-success w-50">Registrar</button>
                            <input type="reset" class="btn btn-danger w-50" id="btnCancelarF" value="Limpiar">
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </section>

      <div class="modal fade" id="modalBeneficiarioF" tabindex="-1" role="dialog"
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
                          data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>"
                          data-formulario="formularioF">
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

  <script src="dist/js/diagnosticos/trabajador_social/crear.js"></script>

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