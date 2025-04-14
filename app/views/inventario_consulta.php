<?php
    $title = "Inventario - Consulta";
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
                    <h3 class="card-title">Listado de insumos del inventario médico</h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla_inventario" class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-navy">
                                    <th>Estatus</th>
                                    <th>Stock</th>
                                    <th>Nombre</th>
                                    <th>Tipo de insumo</th>
                                    <th>Presentación</th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $hoy = date('Y-m-d');
                                foreach ($insumos as $item): 
                                    $vencido = $item['fecha_vencimiento'] < $hoy;
                                ?>
                                <tr class="<?php echo $vencido ? 'bg-vencido' : '' ?>">
                                    <td class="text-center">
                                        <?php if ($item['estatus'] == 'Activo'): ?>
                                            <i class="fa fa-check-circle" style="color: green;" title="Activo"></i>
                                        <?php else: ?>
                                            <i class="fa fa-times-circle" style="color: red;" title="Inactivo"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($vencido): ?>
                                            <i class="fa fa-skull-crossbones" style="color: #dc3545;" title="Producto Vencido"> Vencido</i> 
                                        <?php else: ?>
                                            <?php if ($item['cantidad'] > 0 && $item['cantidad'] < 10): ?>
                                                <i class="fa fa-exclamation-triangle" style="color: orange;" title="Bajo Stock"> Bajo Stock</i> 
                                            <?php elseif ($item['cantidad'] > 0): ?>
                                                <i class="fa fa-check-circle" style="color: green;" title="Disponible"> Disponible</i> 
                                            <?php else: ?>
                                                <i class="fa fa-times-circle" style="color: red;" title="Agotado"> Agotado</i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['nombre_insumo']); ?></td>
                                    <td><?php echo htmlspecialchars($item['tipo_insumo']); ?></td>
                                    <td><?php echo htmlspecialchars($item['nombre_presentacion']); ?></td>
                                    <td class="<?php echo $vencido ? 'text-danger fw-bold' : '' ?>">
                                        <?php echo htmlspecialchars($item['fecha_vencimiento']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                                    <td>
                                        <?php if(!$vencido): ?>
                                            <a href="index.php?action=inventario_editar&id_insumo=<?php echo $item['id_insumo'];?>" 
                                            class="btn btn-primary btn-sm"
                                            title="Editar insumo">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="index.php?action=inventario_eliminar&id_insumo=<?php echo $item['id_insumo']?>" 
                                        class="btn btn-sm btn-danger <?php echo $vencido ? 'disabled' : '' ?>"
                                        title="<?php echo $vencido ? 'Eliminar producto vencido' : 'Eliminar insumo' ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        
                                        <?php if($vencido): ?>
                                        <a href="index.php?action=inventario_editar&id_insumo=<?= $item['id_insumo'] ?>&desbloquear=1" 
                                        class="btn btn-sm btn-warning"
                                        title="Reestablecer insumo (requiere ajustar fecha)">
                                            <i class="fa fa-unlock"></i>
                                        </a>
                                        <?php endif; ?>
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
  <!-- CONTENIDO -->
  
  <?php include 'template/footer.php'; ?>
  
</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->
<script src="dist/js/inventario/consulta.js"></script>

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

<style>
.bg-vencido {
    background-color: #fff5f5 !important;
    position: relative;
}
.bg-vencido::after {
    content: "VENCIDO";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-15deg);
    font-size: 2.5em;
    color: rgba(220, 53, 69, 0.15);
    font-weight: bold;
    pointer-events: none;
    z-index: 1;
}
</style>

</body>
</html>
