<?php
    $title = "Inventario - Crear";
    $nivel1 = "inventario";
    $nivel2 = "crear";
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
                <h1>Bienvenido al área del Inventario Médico</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <!-- Encabezado del formulario -->
                <div class="card-header bg-navy">
                    <h3 class="card-title">Registrar Insumo</h3>
                </div>

                <!-- Contenido del formulario -->
                <form id="formInsumo" action="index.php?action=inventario_registrar" method="POST">
                    <div class="card-body">
                        <!-- Fila 1: Nombre del insumo, Presentación, Tipo -->
                        <div class="row g-3">
                            <!-- Nombre del insumo -->
                            <div class="col-md-6">
                                <label for="nombre_insumo" class="form-label">Nombre del Insumo</label>
                                <input type="text" class="form-control" id="nombre_insumo" name="nombre_insumo" placeholder="Nombre del insumo">
                                <div id="nombre_insumoerror" class="text-danger"></div>
                            </div>

                            <!-- ID Presentación -->
                            <div class="col-md-6">
                                <label for="id_presentacion" class="form-label">Presentación</label>
                                <select name="id_presentacion" id="id_presentacion" class="form-control">
                                    <option value="" disabled selected>Seleccione una presentación</option>
                                    <?php foreach ($presentaciones as $presentacion): ?>
                                        <option value="<?php echo htmlspecialchars($presentacion['id_presentacion']); ?>">
                                            <?php echo htmlspecialchars($presentacion['nombre_presentacion']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="id_presentacionerror" class="text-danger"></div>
                            </div>

                            
                        </div>

                        <!-- Cantidad -->
                            <input type="hidden" class="form-control" id="cantidad" name="cantidad" value="0" min="1">
                        <!-- Fila 2: Cantidad y Fecha de vencimiento -->
                        <div class="row g-3 mt-3">
                            <!-- Fecha de vencimiento -->
                            <div class="col-md-6">
                                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
                                <div id="fecha_vencimientoerror" class="text-danger"></div>
                            </div>

                            <!-- Tipo de insumo -->
                            <div class="col-md-6">
                                <label for="tipo_insumo" class="form-label">Tipo de Insumo</label>
                                <select name="tipo_insumo" id="tipo_insumo" class="form-control">
                                    <option value="" disabled selected>Seleccione un tipo</option>
                                    <option value="Quirurgico">Quirúrgico</option>
                                    <option value="Medicamento">Medicamento</option>
                                </select>
                                <div id="tipo_insumoerror" class="text-danger"></div>
                            </div>
                        </div>

                        <!-- Fila 3: Descripción -->
                        <div class="row g-3 mt-3 mb-3">
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del insumo" rows="3"></textarea>
                                <div id="descripcionerror" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="btn-group w-100">
                                    <button type="submit" id="btnRegistrar" class="btn btn-success w-50">Registrar</button>
                                    <input type="reset" class="btn btn-danger w-50" value="Limpiar">
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

<!-- VALIDACIONES CON JAVASCRIPT -->
<script src="dist/js/inventario/crear.js"></script>

</body>
</html>
