<?php
    if (!function_exists('htmlspecialchars')) {
        require_once 'functions.php';
    }
    $title = "Inventario - Movimientos";
    $nivel1 = "inventario";
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
            <h1>Bienvenido al área del Inventario Médico</h1>
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
                            <h3 class="card-title">Listado de movimientos del inventario médico</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla_movimientos" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th>Insumo</th>
                                            <th>Empleado</th>
                                            <th>Fecha del movimiento</th>
                                            <th>Tipo de Movimiento</th>
                                            <th>Cantidad</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($movimientos as $item): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($item['nombre_insumo']); ?></td>
                                                <td><?php echo htmlspecialchars($item['nombre_empleado']); ?></td>
                                                <td><?php echo htmlspecialchars($item['fecha_format']); ?></td>
                                                <td>
                                                    <?php if($item['tipo_movimiento'] == 'Entrada'): ?>
                                                        <span class="badge badge-success">Entrada</span>
                                                    <?php elseif($item['tipo_movimiento'] == 'Salida'): ?>
                                                        <span class="badge badge-danger">Salida</span>
                                                    <?php elseif($item['tipo_movimiento'] == 'Registro'): ?>
                                                        <span class="badge badge-warning">Nuevo Registro</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                                                <td style="max-width: 300px;"><?php echo htmlspecialchars($item['descripcion']); ?></td>
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

<script src="dist/js/inventario/movimientos.js"></script>
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
