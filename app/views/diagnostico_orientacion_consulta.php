<?php
$title = "Orientacion - Consulta";
$nivel1 = "diagnostico";
$nivel2 = "orientacion";
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
                            <h1>Bienvenido al área de Orientación</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Listado de consultas de orientación</h3>
                        </div>
                        <div class="card-body">
                            <table id="tabla_diagnosticos" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr class="bg-navy">
                                        <th>Beneficiario</th>
                                        <th>Motivo</th>
                                        <th>Descripción</th>
                                        <th>Indicaciones</th>
                                        <th>Observaciones</th>
                                        <th>Fecha</th>
                                        <th>Constancia</th>
                                        <th>Referencia</th>
                                        <th>Acciones</th> <!-- Asegúrate de que esta columna esté al final -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orientacion as $diagnostico): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(isset($diagnostico['nombre_beneficiario']) ? $diagnostico['nombre_beneficiario'] : ''); ?></td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($diagnostico['motivo_orientacion']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($diagnostico['descripcion_orientacion']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate">
                                                    <?php echo htmlspecialchars($diagnostico['indicaciones_orientacion']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate">
                                                    <?php echo htmlspecialchars($diagnostico['obs_adic_orientacion']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo isset($diagnostico['fecha_creacion']) ? date('d/m/Y', strtotime($diagnostico['fecha_creacion'])) : 'Fecha no disponible'; ?>
                                            </td>
                                            <td> <a href="index.php?action=orientacion_constancia&id_orientacion=<?php echo $diagnostico['id_orientacion']; ?>" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="index.php?action=orientacion_referencia&id_orientacion=<?php echo $diagnostico['id_orientacion']; ?>" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-share"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="index.php?action=orientacion_visualizar&id_orientacion=<?php echo $diagnostico['id_orientacion']; ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?action=orientacion_editar&id_orientacion=<?php echo $diagnostico['id_orientacion']; ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?action=orientacion_eliminar&id_orientacion=<?php echo htmlspecialchars($diagnostico['id_orientacion'] ?? ''); ?>&id_solicitud_serv=<?php echo htmlspecialchars($diagnostico['id_solicitud_serv'] ?? ''); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta consulta?');">
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
            </section>
        </div>
        <?php include 'template/footer.php'; ?>

    </div>


    <?php include 'template/script.php'; ?>
    <!-- SCRIPT PERSONALIZADOS -->

    <script src="dist/js/diagnosticos/orientacion/consulta.js"></script>

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