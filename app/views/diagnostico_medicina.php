<?php
$title = "Diagnosticos - Medicina";
$nivel1 = "diagnostico";
$nivel2 = "medicina";
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
                            <h1>Bienvenido al área de Medicina</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content mt-2">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Registrar consulta Médica</h3>
                        </div>
                        <div class="card-body">
                            <form action="index.php?action=medicina_crear" id="formularioConsultaMedica" method="POST">
                                <!-- Primera fila con botones de Beneficiario, Insumo y campo ID de Servicio -->
                                <div class="row">
                                    <!-- Botón para seleccionar Beneficiario -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_beneficiario">Beneficiario</label>
                                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalBeneficiario">
                                                Seleccionar Beneficiario
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Botón para seleccionar Insumo -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_insumo">Insumo</label>
                                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalInsumo">
                                                Seleccionar Insumo
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Campo de ID de Servicio -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_servicios">Servicio</label>
                                            <input type="hidden" name="id_servicios" value="<?php echo $servicios['id_servicios']; ?>">
                                            <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Segunda fila: Nombre del Beneficiario e Insumo seleccionado -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre_beneficiario">Beneficiario</label>
                                            <input type="hidden" name="id_beneficiario" id="id_beneficiario">
                                            <input type="text" id="nombre_beneficiario" class="form-control" placeholder="Beneficiario seleccionado" disabled>
                                            <div id="nombre_beneficiarioerror" class="text-danger"></div> <!-- Error para nombre -->
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr class="bg-navy">
                                                        <th>Nombre del Insumo</th>
                                                        <th>Cantidad</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tablaInsumosSeleccionados"></tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <!-- Input hidden para enviar datos al servidor -->
                                    <input type="hidden" name="insumos" id="insumosInputHidden" value="[]">
                                </div>

                                <!-- Tercera fila: Datos adicionales -->
                                <div class="row">
                                    <!-- Campo de selección de Patología -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_patologia">Patología</label>
                                            <select name="id_patologia" id="id_patologia" class="custom-select form-control-border">
                                                <option value="" disabled selected>Seleccione una patología</option>
                                                <?php foreach ($patologias as $patologia): ?>
                                                    <option value="<?php echo htmlspecialchars($patologia['id_patologia']); ?>">
                                                        <?php echo htmlspecialchars($patologia['nombre_patologia']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div id="id_patologiaerror" class="text-danger"></div> <!-- Error para patología -->
                                        </div>
                                    </div>

                                    <!-- Campo de Estatura -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="estatura">Estatura (m)</label>
                                            <input type="text" step="0.01" name="estatura" id="estatura" class="form-control" placeholder="Estatura">
                                            <div id="estaturaerror" class="text-danger"></div> <!-- Error para estatura -->
                                        </div>
                                    </div>

                                    <!-- Campo de Peso -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="peso">Peso (kg)</label>
                                            <input type="text" step="0.01" name="peso" id="peso" class="form-control" placeholder="Peso">
                                            <div id="pesoerror" class="text-danger"></div> <!-- Error para peso -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Cuarta fila: Detalles médicos -->
                                <div class="row">
                                    <!-- Campo de Tipo de Sangre -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo_sangre">Tipo de Sangre</label>
                                            <select name="tipo_sangre" id="tipo_sangre" class="custom-select form-control-border">
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                            <div id="tipo_sangreerror" class="text-danger"></div> <!-- Error para sangre -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Campo de Motivo de la Visita -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="motivo_visita">Motivo de la Visita</label>
                                            <textarea name="motivo_visita" id="motivo_visita" class="form-control" placeholder="Motivo de la visita" rows="3"></textarea>
                                            <div id="motivo_visitaerror" class="text-danger"></div> <!-- Error para motivo -->
                                        </div>
                                    </div>

                                    <!-- Campo de Diagnóstico -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="diagnostico">Diagnóstico</label>
                                            <textarea name="diagnostico" id="diagnostico" class="form-control" placeholder="Diagnóstico" rows="3"></textarea>
                                            <div id="diagnosticoerror" class="text-danger"></div> <!-- Error para diagnóstico -->
                                        </div>
                                    </div>

                                    <!-- Campo de Tratamiento -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tratamiento">Tratamiento</label>
                                            <textarea name="tratamiento" id="tratamiento" class="form-control" placeholder="Tratamiento" rows="3"></textarea>
                                            <div id="tratamientoerror" class="text-danger"></div> <!-- Error para tratamiento -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Campo de Observaciones Adicionales -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="observaciones">Observaciones Adicionales</label>
                                            <textarea name="observaciones" id="observaciones" class="form-control" placeholder="Observaciones adicionales" rows="3"></textarea>
                                            <div id="observacioneserror" class="text-danger"></div> <!-- Error para observaciones -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Botones de acción -->
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="btn-group w-100">
                                            <button type="submit" class="btn btn-success w-50" id="btnRegistrar">Registrar</button>
                                            <a class="btn btn-info w-50" href="index.php?action=medicina_consulta">Consultar</a>
                                            <button type="button" id="btnCancelar" class="btn btn-danger w-50" onclick="limpiarFormulario()">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>



            <!-- Modal para seleccionar insumo -->
            <div class="modal fade" id="modalInsumo" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-navy">
                            <h5 class="modal-title">Seleccionar insumo del inventario médico</h5>
                            <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table id="tabla_inventario" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-navy">
                                                <th>Nombre</th>
                                                <th>Cantidad Disponible</th>
                                                <th>Presentación</th>
                                                <th>Seleccionar Cantidad</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($inventario as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['nombre_insumo']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['cantidad'] . ' unidades'); ?></td>
                                                    <td><?php echo htmlentities($item['nombre_presentacion']); ?></td>
                                                    <td>
                                                        <select class="custom-select" id="cantidad_<?php echo $item['id_insumo']; ?>">
                                                            <?php for ($i = 1; $i <= $item['cantidad']; $i++): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            onclick="seleccionarInsumo(
                                                        '<?php echo $item['id_insumo']; ?>', 
                                                        '<?php echo htmlspecialchars($item['nombre_insumo']); ?>', 
                                                        document.getElementById('cantidad_<?php echo $item['id_insumo']; ?>').value)">
                                                            Seleccionar
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

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
    <script src="dist/js/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="dist/css/sweetalert2.css">
    <?php include 'template/script.php'; ?>
    <!-- SCRIPT PERSONALIZADOS -->
    <script src="dist/js/diagnosticos/medicina/crear.js"></script>

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