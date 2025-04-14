<?php
    $title = "Medicina - Ver";
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
        <div class="card card-primary">
            <div class="card-header bg-navy">
                <h3 class="card-title">Detalles de la Consulta Médica</h3>
            </div>
            <div class="card-body">
                
                <!-- Fila de Servicio y Beneficiario -->
                <div class="row">
                    <!-- Servicio -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Servicio</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_serv']); ?>" disabled>
                        </div>
                    </div>
                    <!-- Beneficiario -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Beneficiario</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_beneficiario']); ?>" disabled>
                        </div>
                    </div>
                </div>

                <!-- Fila de Insumo, Patología, Estatura, Peso y Tipo de Sangre -->
                <div class="row">
                    <!-- Insumo -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Insumo</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['insumos_utilizados']); ?>" disabled>
                        </div>
                    </div>
                    <!-- Patología -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Patología</label>
                            <select class="form-control" disabled>
                                <?php foreach ($patologias as $patologia): ?>
                                    <option value="<?php echo htmlspecialchars($patologia['id_patologia']); ?>"
                                        <?php echo ($patologia['id_patologia'] == $datos['id_patologia']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($patologia['nombre_patologia']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Estatura -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Estatura (m)</label>
                            <input type="number" class="form-control" value="<?php echo htmlspecialchars($datos['estatura']); ?>" disabled>
                        </div>
                    </div>
                    <!-- Peso -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Peso (kg)</label>
                            <input type="number" class="form-control" value="<?php echo htmlspecialchars($datos['peso']); ?>" disabled>
                        </div>
                    </div>
                    <!-- Tipo de Sangre -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo de Sangre</label>
                            <select class="form-control" disabled>
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

                <!-- Fila de Motivo de Visita, Diagnóstico y Tratamiento -->
                <div class="row">
                    <!-- Motivo de Visita -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Motivo de la Visita</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['motivo_visita']); ?></textarea>
                        </div>
                    </div>
                    <!-- Diagnóstico -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Diagnóstico</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['diagnostico']); ?></textarea>
                        </div>
                    </div>
                    <!-- Tratamiento -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tratamiento</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['tratamiento']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Observaciones Adicionales -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <a href="index.php?action=medicina_consulta" class="btn btn-primary">Regresar</a>
            </div>
        </div>
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
