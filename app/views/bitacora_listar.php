<?php
    $title = "Bitácora - Consulta";
    $nivel1 = "bitacora";
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
            <h1>Bienvenido al área de Bitácora</h1>
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
                            <table id="tabla_bitacora" class="table table-bordered table-striped" style="width: 100%; table-layout: auto;">
                                <thead>
                                    <tr class="bg-navy">
                                        <th>Empleado</th>
                                        <th>Modulo</th>
                                        <th>Acción</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bitacora as $registro): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($registro['nombre'] . ' ' . $registro['apellido']); ?></td>
                                            <td><?php echo htmlspecialchars($registro['modulo']); ?></td>
                                            <td><?php echo htmlspecialchars($registro['accion']); ?></td>
                                            <td><?php echo htmlspecialchars($registro['descripcion']); ?></td>
                                            <td><?php echo htmlspecialchars($registro['fecha_format']); ?></td>
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
<!-- CONTENIDO -->

<?php include 'template/footer.php'; ?>

</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->

<script src="dist/js/bitacora/consulta.js"></script>

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
