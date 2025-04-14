<?php
    $title = "Citas - Editar";
    $nivel1 = "citas";
    $nivel2 = "editar";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

  <!-- CONTENIDO -->
  <div class="content-wrapper">
    <section class="content-header">
        <h1>Bienvenido al área de Citas</h1>
    </section>
    
    <section class="content">
        <div class="card">
            <div class="card-header bg-navy">
                <h3 class="card-title">Editar datos de la Cita</h3>
            </div>
            <form action="index.php?action=citas_actualizar" method="POST">
                <div class="card-body">
                    
                    <input type="hidden" name="id_cita" value="<?php echo $cita_id['id_cita']; ?>">

                    <div class="form-group">
                        <label for="id_empleado">Empleado</label>
                        <input type="hidden" name="id_empleado" value="<?php echo $cita_id['id_empleado']; ?>">
                        <input type="text" class="form-control" value="<?php echo $cita_id['nombre_empleado'] . ' ' . $cita_id['apellido_empleado']; ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_beneficiario">Beneficiario</label>
                        <input type="hidden" name="id_beneficiario" value="<?php echo $cita_id['id_beneficiario']; ?>">
                        <input type="text" class="form-control" value="<?php echo $cita_id['nombres_beneficiario'] . ' ' . $cita_id['apellidos_beneficiario'] . ' - ' . $cita_id['cedula'] . ' - ' . $cita_id['nombre_pnf']; ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $cita_id['fecha']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="hora">Hora</label>
                        <input type="time" name="hora" id="hora" class="form-control" value="<?php echo $cita_id['hora']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="estatus">Estatus</label>
                        <select name="estatus" id="estatus" class="form-control">
                            <option value="1" <?php echo ($cita_id['estatus'] == 1) ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo ($cita_id['estatus'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-success w-50">Actualizar</button>
                                <a href="index.php?action=citas_listar" class="btn btn-danger w-50">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
