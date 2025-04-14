<?php
    $title = "Beneficiarios - Consulta";
    $nivel1 = "beneficiarios";
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
            <h1>Bienvenido al área de Beneficiarios</h1>
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
                            <table id="tabla_beneficiarios" class="table table-bordered table-striped" style="width: 100%; table-layout: auto;">
                                <thead>
                                    <tr class="bg-navy">
                                        <th>PNF</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Cédula</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Dirección</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beneficiarios as $beneficiario): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($beneficiario['nombre_pnf']); ?></td>
                                            <td><?php echo htmlspecialchars($beneficiario['nombres']); ?></td>
                                            <td><?php echo htmlspecialchars($beneficiario['apellidos']); ?></td>
                                            <td><?php echo htmlspecialchars($beneficiario['tipo_cedula'] . '-' . $beneficiario['cedula']); ?></td>
                                            <td><?php echo htmlspecialchars($beneficiario['fecha_nac']); ?></td>
                                            <td><?php echo htmlspecialchars($beneficiario['telefono']); ?></td>
                                            <td><?php echo htmlspecialchars($beneficiario['correo']); ?></td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($beneficiario['direccion']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $beneficiario['estatus'] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'; ?>
                                            </td>
                                            <td>
                                                <a href="index.php?action=beneficiarios_editar&id_beneficiario=<?php echo $beneficiario['id_beneficiario']; ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?action=beneficiarios_eliminar&id_beneficiario=<?php echo $beneficiario['id_beneficiario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este beneficiario?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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

<script src="dist/js/beneficiarios/consulta.js"></script>

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
