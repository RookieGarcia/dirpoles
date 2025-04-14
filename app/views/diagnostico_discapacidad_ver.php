<?php
$title = "Discapacidad - Ver";
$nivel1 = "diagnostico";
$nivel2 = "discapacidad";
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
                <h1>Bienvenido al área de Discapacidad</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
    <?php if ($datos['motivo'] === 'general'): ?>
        <div id="formDiagnosticoGeneral" class="form-section">
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Formulario Diagnóstico General</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <!-- Primera Columna -->
                        <input type="hidden" name="motivo_otro" value="Sin motivo">
                        <div class="col-4">
                            <label for="id_beneficiario" class="col-form-label">Beneficiario</label>
                            <input type="text" class="form-control" id="id_beneficiario" value="<?php echo htmlspecialchars($datos['nombre_beneficiario'] . ' ' . $datos['apellido_beneficiario'] . ' - ' . $datos['cedula_beneficiario']); ?>" disabled style="margin-bottom: 0;">
                        </div>
                        <div class="col-4">
                            <label for="motivo" class="col-form-label">Motivo</label>
                            <input type="text" class="form-control" id="motivo" placeholder="Motivo" value="Diagnóstico General" disabled style="margin-bottom: 0;">
                        </div>

                        <!-- Segunda Columna -->
                        <div class="col-4">
                            <label for="id_servicios" class="col-form-label">Servicio de:</label>
                            <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_serv']); ?>" disabled style="margin-bottom: 0;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_patologia" class="col-sm-2 col-form-label">Patología</label>
                        <div class="col-sm-10">
                            <select name="id_patologia" id="id_patologia" class="custom-select form-control-border" disabled>
                                <option value="" disabled>Seleccione una patología</option>
                                <?php foreach ($patologias as $patologia): ?>
                                    <option value="<?php echo htmlspecialchars($patologia['id_patologia']); ?>"
                                        <?php echo ($datos['nombre_patologia'] == $patologia['nombre_patologia']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($patologia['nombre_patologia']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diagnostico" class="col-sm-2 col-form-label">Diagnóstico General</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" disabled><?php echo htmlspecialchars($datos['diagnostico']); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tratamiento_gen" class="col-sm-2 col-form-label">Tratamiento General</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="tratamiento_gen" name="tratamiento_gen" rows="3" disabled><?php echo htmlspecialchars($datos['tratamiento_gen']); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="observaciones" class="col-sm-2 col-form-label">Observaciones Generales</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" disabled><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="index.php?action=psicologia_listar" class="btn btn-danger">Regresar</a>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if ($datos['motivo'] === 'cambio'): ?>
        <div id="formCambioCarrera" class="form-section">
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Formulario Cambio de Carrera</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <!-- Primera Columna -->
                        <div class="col-6">
                            <label for="motivo" class="col-form-label">Motivo del cambio de carrera</label>
                            <input type="text" class="form-control" id="motivo" placeholder="Motivo" value="Cambio de Carrera" disabled style="margin-bottom: 0;">
                        </div>

                        <!-- Segunda Columna -->
                        <div class="col-6">
                            <label for="id_servicios" class="col-form-label">Servicio de:</label>
                            <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled style="margin-bottom: 0;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="motivo_otro" class="col-sm-2 col-form-label">Motivo del Cambio de Carrera</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="motivo_otro" name="motivo_otro" rows="3" disabled><?php echo htmlspecialchars($datos['motivo_otro']); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="observacionesCambio" class="col-sm-2 col-form-label">Observaciones</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="observacionesCambio" name="observaciones" rows="3" disabled><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <input type="text" id="nombre_beneficiario_cambio" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_beneficiario'] . ' ' . $datos['apellido_beneficiario'] . ' - ' . $datos['cedula_beneficiario']); ?>" disabled style="margin-bottom: 0;" style="flex: 1;">
                    </div>
                    
                </div>
                <div class="card-footer text-right">
                    <a href="index.php?action=psicologia_listar" class="btn btn-danger" id="btnCancelar">Regresar</a>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if ($datos['motivo'] === 'retiro'): ?>
        <!-- Formulario Retiro Temporal -->
        <div id="formRetiroTemporal" class="form-section">
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Formulario Retiro Temporal</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <!-- Primera Columna -->
                        <div class="col-6">
                            <label for="motivo" class="col-form-label">Motivo del retiro temporal</label>
                            <input type="text" class="form-control" id="motivo" placeholder="Motivo" value="Retiro Temporal" disabled style="margin-bottom: 0;">
                        </div>

                        <!-- Segunda Columna -->
                        <div class="col-6">
                            <label for="id_servicios" class="col-form-label">Servicio de:</label>
                            <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled style="margin-bottom: 0;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="motivo_otro_retiro" class="col-sm-2 col-form-label">Motivo por el Retiro Temporal</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="motivo_otro_retiro" name="motivo_otro" rows="3" disabled><?php echo htmlspecialchars($datos['motivo_otro']); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="observacionesRetiro" class="col-sm-2 col-form-label">Observaciones</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="observacionesRetiro" name="observaciones" rows="3" disabled><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <!-- Input Disabled para mostrar los detalles del beneficiario -->
                        <input type="text" id="nombre_beneficiario_retiro" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_beneficiario'] . ' ' . $datos['apellido_beneficiario'] . ' - ' . $datos['cedula_beneficiario']); ?>" disabled style="margin-bottom: 0;" style="flex: 1;">
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="index.php?action=psicologia_listar" class="btn btn-danger" id="btnCancelar">Regresar</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    </div>
    
    
</section>

</div>
<!-- CONTENIDO -->

<?php include 'template/footer.php'; ?>

</div>

<?php include 'template/script.php'; ?>

<!-- SCRIPT PERSONALIZADOS -->


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
