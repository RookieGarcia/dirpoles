<?php
    $title = "Medicina - Editar";
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
<section class="content">
    <div class="container-fluid">
        <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Editar consulta médica</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=medicina_actualizar" id="formularioConsultaMedica" method="POST">
                        <input type="hidden" name="id_consulta_med" value="<?php echo htmlspecialchars($datos['id_consulta_med']); ?>">
                        <input type="hidden" name="id_detalle_patologia" value="<?php echo htmlspecialchars($datos['id_detalle_patologia']); ?>">


                    <!-- Fila de Beneficiario, Servicio -->
                    <div class="row">
                        <!-- Servicio de -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_servicios">Servicio de</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_serv']); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Fila de Beneficiario e Insumo -->
                    <div class="row">
                        <!-- Nombre del Beneficiario -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_beneficiario">Beneficiario</label>
                                <input type="text" class="form-control" id="nombre_beneficiario" name="nombre_beneficiario" value="<?php echo htmlspecialchars($datos['nombre_beneficiario']); ?>" disabled>
                                <div id="nombre_beneficiarioerror" class="text-danger"></div> <!-- Error para nombre -->
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_insumo">Insumos utilizados</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['insumos_utilizados']); ?>" disabled>
                                <div id="nombre_insumoerror" class="text-danger"></div> <!-- Error para insumo -->
                            </div>
                        </div>
                    </div>

                    <!-- Resto del formulario -->
                    <div class="row">
                        <!-- Patología -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_patologia">Patología</label>
                                <select name="id_patologia" class="form-control">
                                    <option value="" selected disabled>Seleccione una patología</option>
                                    <?php foreach ($patologias as $patologia): ?>
                                        <option value="<?php echo htmlspecialchars($patologia['id_patologia']); ?>" <?php echo ($patologia['id_patologia'] == $datos['id_patologia']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($patologia['nombre_patologia']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="id_patologiaerror" class="text-danger"></div> <!-- Error para patología -->
                            </div>
                        </div>


                        <!-- Estatura -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estatura">Estatura (m)</label>
                                <input type="text" step="0.01" name="estatura" class="form-control" value="<?php echo htmlspecialchars($datos['estatura']); ?>">
                                <div id="estaturaerror" class="text-danger"></div> <!-- Error para estatura -->
                            </div>
                        </div>

                        <!-- Peso -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="peso">Peso (kg)</label>
                                <input type="text" step="0.01" name="peso" class="form-control" value="<?php echo htmlspecialchars($datos['peso']); ?>">
                                <div id="pesoerror" class="text-danger"></div> <!-- Error para peso -->
                            </div>
                        </div>
                    </div>

                    <!-- Continuación de los campos del formulario -->
                    <div class="row">
                        <!-- Tipo de Sangre -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_sangre">Tipo de Sangre</label>
                                <select name="tipo_sangre" class="form-control">
                                    <option value="A+" <?php echo ($datos['tipo_sangre'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                                    <option value="A-" <?php echo ($datos['tipo_sangre'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                                    <option value="B+" <?php echo ($datos['tipo_sangre'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                                    <option value="B-" <?php echo ($datos['tipo_sangre'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                                    <option value="AB+" <?php echo ($datos['tipo_sangre'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                    <option value="AB-" <?php echo ($datos['tipo_sangre'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                    <option value="O+" <?php echo ($datos['tipo_sangre'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                                    <option value="O-" <?php echo ($datos['tipo_sangre'] == 'O-') ? 'selected' : ''; ?>>O-</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Motivo de Visita, Diagnóstico y Tratamiento -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="motivo_visita">Motivo de la Visita</label>
                                <textarea name="motivo_visita" class="form-control" rows="3"><?php echo htmlspecialchars($datos['motivo_visita']); ?></textarea>
                                <div id="motivo_visitaerror" class="text-danger"></div> <!-- Error para motivo -->
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="diagnostico">Diagnóstico</label>
                                <textarea name="diagnostico" class="form-control" rows="3"><?php echo htmlspecialchars($datos['diagnostico']); ?></textarea>
                                <div id="diagnosticoerror" class="text-danger"></div> <!-- Error para diagnóstico -->
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tratamiento">Tratamiento</label>
                                <textarea name="tratamiento" class="form-control" rows="3"><?php echo htmlspecialchars($datos['tratamiento']); ?></textarea>
                                <div id="tratamientoerror" class="text-danger"></div> <!-- Error para tratamiemto -->
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones Adicionales -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="3"><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                                <div id="observacioneserror" class="text-danger"></div> <!-- Error para observaciones -->
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-success w-50">Actualizar</button>
                                <a href="index.php?action=medicina_consulta" class="btn btn-danger w-50">Cancelar</a>
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
<!-- SCRIPT PERSONALIZADOS -->

<script src="dist/js/diagnosticos/medicina/editar.js"></script>


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
