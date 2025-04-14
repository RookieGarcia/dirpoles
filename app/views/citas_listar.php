<?php
    $title = "Citas - Consulta";
    $nivel1 = "citas";
    $nivel2 = "consultar";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Bienvenido al área de Citas</h1>
    </section>
    
    <section class="content">
        <div class="card">
            <div class="card-header bg-navy">
                <h3 class="card-title">Listado de Registros</h3>
            </div>
            <div class="card-body">
                <table id="tabla_citas" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                        <tr class="bg-navy">
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Beneficiario</th>
                            <th>Empleado</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                                <td><?php echo htmlspecialchars($cita['beneficiario_nombres'] . ' ' . $cita['beneficiario_apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($cita['empleado_nombre'] . ' ' . $cita['empleado_apellido']); ?></td>
                                <td>
                                    <?php echo $cita['estatus'] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'; ?>
                                </td>
                                <td>
                                    <a href="index.php?action=citas_editar&id_cita=<?php echo $cita['id_cita']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?action=citas_eliminar&id_cita=<?php echo $cita['id_cita']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta cita?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include 'template/footer.php'; ?>

</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->

<script src="dist/js/citas/consulta.js"></script>

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
