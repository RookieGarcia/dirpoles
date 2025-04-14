<?php
$title = "Diagnosticos - Orientación";
$nivel1 = "diagnostico";
$nivel2 = "orientacion";
include 'template/head.php';
?>

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
                            <h1>Bienvenido al área de Orientación</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content mt-2">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Diagnóstico de Orientación</h3>
                        </div>
                        <div class="card-body">
                            <form action="index.php?action=orientacion_crear" id="formularioConsultaOrientacion" method="POST">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="id_beneficiario" class="col-sm-3 col-form-label">Beneficiario</label>
                                            <div class="col-sm-9">
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBeneficiario">Seleccionar Beneficiario</button>
                                                <div id="id_beneficiario_error" class="text-danger"></div> <!-- Error para beneficiario -->
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Campo de ID de Servicio -->
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="id_servicios" class="col-sm-3 col-form-label">Servicio de</label>
                                            <div class="col-sm-9">
                                                <input type="hidden" name="id_servicios" value="<?php echo $servicios['id_servicios']; ?>">
                                                <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Segunda fila: Nombre del Beneficiario -->
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="nombre_beneficiario" class="col-sm-3 col-form-label">Beneficiario</label>
                                            <input type="hidden" name="id_beneficiario" id="id_beneficiario">
                                            <div class="col-sm-9">
                                                <input type="text" id="nombre_beneficiario" class="form-control" placeholder="Beneficiario seleccionado" disabled>
                                                <div id="nombre_beneficiario_error" class="text-danger"></div> <!-- Error para nombre -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campo de Motivo de la Orientación -->
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="motivo_orientacion" class="col-sm-3 col-form-label">Motivo</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="motivo_orientacion" id="motivo_orientacion" class="form-control">
                                                <div id="motivo_orientacion_error" class="text-danger"></div> <!-- Error para motivo -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Campo de Descripción de la Orientación -->
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="descripcion_orientacion" class="col-sm-2 col-form-label">Descripción</label>
                                            <div class="col-sm-10">
                                                <textarea name="descripcion_orientacion" id="descripcion_orientacion" class="form-control" rows="3"></textarea>
                                                <div id="descripcion_orientacion_error" class="text-danger"></div> <!-- Error para descripción -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Campo de Indicaciones de la Orientación -->
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="indicaciones_orientacion" class="col-sm-2 col-form-label">Indicaciones</label>
                                            <div class="col-sm-10">
                                                <textarea name="indicaciones_orientacion" id="indicaciones_orientacion" class="form-control" rows="3"></textarea>
                                                <div id="indicaciones_orientacion_error" class="text-danger"></div> <!-- Error para indicaciones -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Campo de Observaciones Adicionales -->
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="obs_adic_orientacion" class="col-sm-2 col-form-label">Observaciones</label>
                                            <div class="col-sm-10">
                                                <textarea name="obs_adic_orientacion" id="obs_adic_orientacion" class="form-control" rows="3"></textarea>
                                                <div id="obs_adic_orientacion_error" class="text-danger"></div> <!-- Error para observaciones -->
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <!-- Botones de acción -->
                                    <div class="col-6"></div>
                                    <div class="col-6">
                                        <div class="btn-group w-100">
                                            <button type="submit" class="btn btn-success w-50" id="btnRegistrar">Registrar</button>
                                            <a class="btn btn-info w-50" href="index.php?action=orientacion_consulta">Consultar</a>
                                            <button type="button" id="btnCancelar" class="btn btn-danger w-50" onclick="limpiarFormulario()">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modal para Seleccionar Beneficiario -->
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
                            <!-- Tabla de Beneficiarios -->
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

    <script src="dist/js/diagnosticos/orientacion/crear.js"></script>

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