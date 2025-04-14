<?php
$title = "Orientacion - Ver";
$nivel1 = "diagnostico";
$nivel2 = "orientacion";
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
                <h1>Bienvenido al área de Orientación</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header bg-navy">
                <h3 class="card-title">Detalles de la Consulta de Orientación</h3>
            </div>
            <div class="card-body">
                
                <!-- Fila de Servicio y Beneficiario -->
                <div class="row">
                    <!-- Servicio -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Servicio</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_serv'] ?? ''); ?>" disabled>
                        </div>
                    </div>
                    <!-- Beneficiario -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Beneficiario</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($datos['nombre_beneficiario'] . ' ' . $datos['apellido_beneficiario'] ?? ''); ?>" disabled>
                        </div>
                    </div>
                </div>

                <!-- Fila de Motivo de Visita, Diagnóstico y Tratamiento -->
                <div class="row">
                    <!-- Motivo de Visita -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Motivo</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['motivo_orientacion'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <!-- Diagnóstico -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Descripcion</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['descripcion_orientacion'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <!-- Tratamiento -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Indicaciones</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['indicaciones_orientacion'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Observaciones Adicionales -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($datos['obs_adic_orientacion'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <a href="index.php?action=orientacion_consulta" class="btn btn-primary">Regresar</a>
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
