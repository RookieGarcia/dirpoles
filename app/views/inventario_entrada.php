<?php
    $title = "Inventario - Entrada";
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
                <div class="card-header bg-navy">
                    <h3 class="card-title">Registrar entrada de un Insumo</h3>
                </div>
                <form action="index.php?action=registrar_entrada" method="POST">
                    <div class="card-body">
                        <!-- Campos ocultos y de visualización -->
                        <input type="hidden" name="id_insumo" id="id_insumo">
                        <div class="form-group">
                            <label>Insumo seleccionado</label>
                            <input type="text" id="nombre_insumo" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Presentación</label>
                            <input type="text" id="presentacion" class="form-control" readonly>
                        </div>

                        <!-- Campos de entrada -->
                        <div class="form-group">
                            <label>Cantidad a ingresar</label>
                            <input type="number" name="cantidad" class="form-control" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Descripción/Razón de entrada</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>

                        <!-- Botón para abrir modal -->
                        <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#modalInsumos">
                            <i class="fas fa-medkit"></i> Seleccionar Insumo
                        </button>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-success w-50">Registrar</button>
                                    <input type="reset" class="btn btn-danger w-50" value="Limpiar">
                                    <a href="index.php?action=inventario_consulta" class="btn btn-primary w-50">Regresar</a>
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

<!-- Modal para Seleccionar Insumos -->
<div class="modal fade" id="modalInsumos" tabindex="-1" role="dialog" aria-labelledby="modalInsumosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h5 class="modal-title" id="modalInsumosLabel">Seleccionar Insumos Médicos</h5>
                <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tabla_insumos" class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-navy">
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Presentación</th>
                            <th>Existencia</th>
                            <th>Vencimiento</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($inventario)): ?>
                            <?php foreach ($inventario as $insumo): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($insumo['nombre_insumo']); ?></td>
                                    <td><?php echo htmlspecialchars($insumo['tipo_insumo']); ?></td>
                                    <td><?php echo htmlspecialchars($insumo['nombre_presentacion']); ?></td>
                                    <td><?php echo htmlspecialchars($insumo['cantidad']); ?></td>
                                    <td><?php echo htmlspecialchars($insumo['fecha_vencimiento']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-select-insumo" 
                                                data-id="<?php echo $insumo['id_insumo']; ?>"
                                                data-nombre="<?php echo htmlspecialchars($insumo['nombre_insumo']); ?>"
                                                data-cantidad="<?php echo htmlspecialchars($insumo['cantidad']); ?>"
                                                data-presentacion="<?php echo htmlspecialchars($insumo['nombre_presentacion']); ?>">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay insumos registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<?php include 'template/script.php'; ?>

<!-- SCRIPT PERSONALIZADOS -->
<script src="dist/js/inventario/entrada.js"></script>

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
