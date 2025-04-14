<?php
$title = "Orientacion - Editar";
$nivel1 = "diagnostico";
$nivel2 = "orientacion";
include 'template/head.php'; 
?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php 
    include 'template/header.php'; 
    include 'template/sidebar.php'; 
?>

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

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-navy">
                <h3 class="card-title">Editar consulta de orientación</h3>
            </div>
            <div class="card-body">
                <form action="index.php?action=orientacion_actualizar" id="formularioConsultaOrientacion" method="POST">
                    <input type="hidden" name="id_orientacion" value="<?php echo htmlspecialchars($datos['id_orientacion']); ?>">

                    <!-- Fila 1: Beneficiario y Servicio -->
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group row">
                                <label for="id_servicios" class="col-sm-3 col-form-label">Servicio de</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="id_servicios" value="<?php echo htmlspecialchars($datos['id_servicios']); ?>">
                                    <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_serv'] ?? ''); ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fila 2: Nombre Beneficiario y Motivo -->
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group row">
                                <label for="nombre_beneficiario" class="col-sm-3 col-form-label">Beneficiario</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nombre_beneficiario" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_beneficiario'] . ' ' . $datos['apellido_beneficiario']); ?>" disabled>
                                    <div id="nombre_beneficiario_error" class="text-danger"></div> <!-- Error para nombre -->
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group row">
                                <label for="motivo_orientacion" class="col-sm-3 col-form-label">Motivo</label>
                                <div class="col-sm-9">
                                    <input type="text" name="motivo_orientacion" class="form-control" value="<?php echo htmlspecialchars($datos['motivo_orientacion']); ?>">
                                    <div id="motivo_orientacion_error" class="text-danger"></div> <!-- Error para motivo -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fila 3: Descripción, Indicaciones y Observaciones -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="descripcion_orientacion" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea name="descripcion_orientacion" class="form-control" rows="3"><?php echo htmlspecialchars($datos['descripcion_orientacion']); ?></textarea>
                                    <div id="descripcion_orientacion_error" class="text-danger"></div> <!-- Error para descripción -->
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                                <label for="indicaciones_orientacion" class="col-sm-2 col-form-label">Tratamiento</label>
                                <div class="col-sm-10">
                                    <textarea name="indicaciones_orientacion" class="form-control" rows="3"><?php echo htmlspecialchars($datos['indicaciones_orientacion']); ?></textarea>
                                    <div id="indicaciones_orientacion_error" class="text-danger"></div> <!-- Error para tratamiento -->
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                                <label for="obs_adic_orientacion" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-10">
                                    <textarea name="obs_adic_orientacion" class="form-control" rows="3"><?php echo htmlspecialchars($datos['obs_adic_orientacion']); ?></textarea>
                                    <div id="obs_adic_orientacion_error" class="text-danger"></div> <!-- Error para observaciones -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-success w-50" id="btnActualizar">Actualizar</button>
                                <a class="btn btn-danger w-50" href="index.php?action=orientacion_consulta">Cancelar</a>
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
<script src="dist/js/diagnosticos/orientacion/editar.js"></script>

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
