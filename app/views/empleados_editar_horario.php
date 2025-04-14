<?php
    $title = "Empleados - Horario";
    $nivel1 = "beneficiarios";
    $nivel2 = "editar";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

<?php
$diaSemana = $horario['dia_semana'];
$horaInicio = $horario['hora_inicio'];
$horaFin = $horario['hora_fin'];
?>

  <!-- CONTENIDO -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Bienvenido al área de Empleados</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Tarjeta para el formulario -->
                <div class="card">
                    <div class="card-header bg-navy">
                        <h3 class="card-title">Editar datos del Horario</h3>
                    </div>
                    <div class="card-body">
                        <form action="index.php?action=horario_actualizar" method="POST">
                            <input type="hidden" name="id_horario" value="<?= htmlspecialchars($id_horario); ?>">
                            <input type="hidden" name="id_empleado" value="<?= htmlspecialchars($empleado['id_empleado']); ?>">

                            <div class="form-group">
                                <label for="dia_semana">Día de la semana:</label>
                                <select name="dia_semana" id="dia_semana" class="form-control" required>
                                    <option value="Lunes" <?= ($diaSemana == 'Lunes') ? 'selected' : ''; ?>>Lunes</option>
                                    <option value="Martes" <?= ($diaSemana == 'Martes') ? 'selected' : ''; ?>>Martes</option>
                                    <option value="Miércoles" <?= ($diaSemana == 'Miércoles') ? 'selected' : ''; ?>>Miércoles</option>
                                    <option value="Jueves" <?= ($diaSemana == 'Jueves') ? 'selected' : ''; ?>>Jueves</option>
                                    <option value="Viernes" <?= ($diaSemana == 'Viernes') ? 'selected' : ''; ?>>Viernes</option>
                                    <option value="Sábado" <?= ($diaSemana == 'Sábado') ? 'selected' : ''; ?>>Sábado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="hora_inicio">Hora de inicio:</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="<?= htmlspecialchars($horaInicio); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="hora_fin">Hora de fin:</label>
                                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="<?= htmlspecialchars($horaFin); ?>" required>
                            </div>

                            <div class="form-group row gap-2">
                                <button type="submit" class="btn btn-success btn-block w-50">Guardar cambios</button>
                                <a href="index.php?action=empleados_editar&id_empleado=<?php echo $empleado['id_empleado']; ?>" class="btn btn-danger w-50"><b>Regresar</b></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!-- CONTENIDO -->

<script src="dist/js/empleados/editar_horarios.js"></script>

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
