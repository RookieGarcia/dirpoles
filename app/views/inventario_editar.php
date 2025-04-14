<?php
    $title = "Inventario - Editar";
    $nivel1 = "inventario";
    $nivel2 = "editar";
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
            <div class="card">
                <div class="card-header bg-navy">
                    <h5 class="card-title">Editar Insumo</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($_GET['desbloquear'])): ?>
                    <div class="alert alert-warning">
                        <strong>¡Atención!</strong> Para reactivar este insumo vencido, debes:
                        <ul>
                            <li>Ingresar una nueva fecha de vencimiento futura</li>
                            <li>Actualizar la cantidad disponible</li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <form id="formInsumo" action="index.php?action=inventario_actualizar" method="POST">
                        <!-- Campos ocultos para id_inventario e id_insumo -->  
                        <input type="hidden" name="id_insumo" value="<?php echo htmlspecialchars($detalles['id_insumo']); ?>">

                        <div class="row">
                            <!-- Nombre del insumo -->
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="nombre_insumo" class="col-sm-4 col-form-label">Nombre Insumo</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nombre_insumo" name="nombre_insumo" value="<?php echo htmlspecialchars($detalles['nombre_insumo']); ?>" placeholder="Nombre del insumo">
                                        <div id="nombre_insumoerror" class="text-danger"></div> <!-- Error para nombre insumo -->
                                    </div>
                                </div>
                            </div>

                            <!-- ID Presentación -->
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="id_presentacion" class="col-sm-4 col-form-label">Presentación</label>
                                    <div class="col-sm-8">
                                        <select name="id_presentacion" id="id_presentacion" class="form-control">
                                            <option value="" disabled>Seleccione una presentación</option>
                                            <?php foreach ($presentaciones as $presentacion): ?>
                                                <option value="<?php echo htmlspecialchars($presentacion['id_presentacion']); ?>" <?php echo $detalles['id_presentacion'] == $presentacion['id_presentacion'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($presentacion['nombre_presentacion']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div id="id_presentacionerror" class="text-danger"></div> <!-- Error para presentación -->
                                    </div>
                                </div>
                            </div>

                            
                        </div>

                        <div class="row">
                            <!-- Fecha de vencimiento -->
                            <div class="col-4">
                                <div class="form-group row">
                                <?php if(isset($_GET['desbloquear'])): ?>
                                <input type="hidden" name="desbloquear" value="1">
                                <?php endif; ?>
                                    <label for="fecha_vencimiento" class="col-sm-6 col-form-label">Fecha de Vencimiento</label>
                                    <div class="col-sm-6">
                                        <input type="date" 
                                            class="form-control" 
                                            id="fecha_vencimiento" 
                                            name="fecha_vencimiento" 
                                            value="<?= htmlspecialchars($detalles['fecha_vencimiento']) ?>" 
                                            <?= isset($_GET['desbloquear']) ? 'min="'.date('Y-m-d', strtotime('+1 day')).'"' : '' ?>
                                            required>
                                        <div id="fecha_vencimientoerror" class="text-danger"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo de insumo -->
                            <div class="col-4">
                                <div class="form-group row">
                                    <label for="tipo_insumo" class="col-sm-4 col-form-label">Tipo de Insumo</label>
                                    <div class="col-sm-8">
                                        <select name="tipo_insumo" id="tipo_insumo" class="form-control">
                                            <option value="" disabled>Seleccione un tipo</option>
                                            <option value="Quirurgico" <?php echo $detalles['tipo_insumo'] == 'Quirurgico' ? 'selected' : ''; ?>>Quirúrgico</option>
                                            <option value="Consumible" <?php echo $detalles['tipo_insumo'] == 'Consumible' ? 'selected' : ''; ?>>Consumible</option>
                                        </select>
                                        <div id="tipo_insumoerror" class="text-danger"></div> <!-- Error para tipo insumo -->
                                    </div>
                                </div>
                            </div>

                            <!-- Estatus -->
                            <div class="col-4">
                                <div class="form-group row">
                                    <label for="estatus" class="col-sm-4 col-form-label">Estatus</label>
                                    <div class="col-sm-8">
                                        <select name="estatus" id="estatus" class="form-control">
                                            <option value="Activo" <?php echo $detalles['estatus'] == 'Activo' ? 'selected' : ''; ?>>Activo</option>
                                            <option value="Inactivo" <?php echo $detalles['estatus'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                        <div id="estatuserror" class="text-danger"></div> <!-- Error para estatus -->
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <!-- Descripción -->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del insumo" rows="3"><?php echo htmlspecialchars($detalles['descripcion']); ?></textarea>
                                        <div id="descripcionerror" class="text-danger"></div> <!-- Error para descripción -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="btn-group w-100">
                                    <button type="submit" id="btnActualizar" class="btn btn-success w-50">Actualizar</button>
                                    <a href="index.php?action=inventario_consulta" id="btnCancelar" class="btn btn-danger w-50">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
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

<!-- VALIDACIONES CON JAVASCRIPT -->
<script src="dist/js/inventario/editar.js"></script>

<style>
[data-desbloqueo] #fecha_vencimiento {
    border: 2px solid #ffc107;
    font-weight: bold;
}

.alert-reactivo {
    animation: pulseWarning 1.5s infinite;
}

@keyframes pulseWarning {
    0% { box-shadow: 0 0 0 0 rgba(255,193,7,0.5); }
    70% { box-shadow: 0 0 0 10px rgba(255,193,7,0); }
    100% { box-shadow: 0 0 0 0 rgba(255,193,7,0); }
}
</style>

</body>
</html>
