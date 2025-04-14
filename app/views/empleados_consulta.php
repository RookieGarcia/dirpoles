<?php
    $title = "Empleados - Consulta";
    $nivel1 = "empleados";
    $nivel2 = "consulta";
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
            <h1>Bienvenido al área de Empleados</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                      <div class="card-header bg-navy">
                          <h3 class="card-title">Listado de Registros</h3>
                      </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla_empleados" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-navy">
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Cédula</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Cargo</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleados as $empleado): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($empleado['apellido']); ?></td>
                                            <td><?php echo htmlspecialchars($empleado['tipo_cedula'] . '-' . $empleado['cedula']); ?></td>
                                            <td><?php echo htmlspecialchars($empleado['correo']); ?></td>
                                            <td><?php echo htmlspecialchars($empleado['telefono']); ?></td>
                                            <td><?php echo htmlspecialchars($empleado['tipo']); ?></td>
                                            <td>
                                                <?php echo $empleado['estatus'] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Bloqueado</span>'; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="index.php?action=empleados_editar&id_empleado=<?php echo $empleado['id_empleado']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="index.php?action=empleado_eliminar&id_empleado=<?php echo $empleado['id_empleado']; ?>" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('¿Estás seguro de eliminar este empleado?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </section>
  </div>
  <?php include 'template/footer.php'; ?>
  
</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->
<script src="dist/js/empleados/consulta.js"></script>
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
