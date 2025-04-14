<?php
$title = "Medicina - Consulta";
$nivel1 = "diagnostico";
$nivel2 = "medicina";
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
                            <h1>Bienvenido al área de Medicina</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Listado de consultas de Medicina</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla_diagnosticos" class="table table-bordered table-striped" style="width: 100%;">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th>Beneficiario</th>
                                            <th>Patología</th>
                                            <th>Motivo de visita</th>
                                            <th>Insumos utilizados</th>
                                            <th>Diagnóstico</th>
                                            <th>Tratamiento</th>
                                            <th>Observaciones</th>
                                            <th>Fecha</th>
                                            <th>Descargables</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($medicina as $diagnostico): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($diagnostico['beneficiario']); ?></td>
                                                <td><?php echo htmlspecialchars($diagnostico['nombre_patologia']); ?></td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 150px;">
                                                        <?php echo htmlspecialchars($diagnostico['motivo_visita']); ?>
                                                    </div>

                                                </td>
                                                <td><?php echo htmlspecialchars($diagnostico['insumos_usados']); ?></td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 150px;">
                                                        <?php echo htmlspecialchars($diagnostico['diagnostico']); ?>
                                                    </div>
                                                </td>
                                            <td>
                                                <div class="text-truncate " style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($diagnostico['tratamiento']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate " style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($diagnostico['observaciones']); ?>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($diagnostico['fecha_creacion']); ?></td>
                                            <td class="text-center"> 
                                                <a href="index.php?action=medicina_constancia&id_consulta_med=<?php echo $diagnostico['id_consulta_med']; ?>" target="_blank" class="btn btn-info btn-sm mb-1">
                                                    <i class="fas fa-file-pdf"></i> Constancia
                                                </a>
                                                <br>
                                                <a class="btn btn-info btn-sm mb-1" href="index.php?action=medicina_referencia&id_consulta_med=<?php echo $diagnostico['id_consulta_med']; ?>" target="_blank">
                                                    <i class="fas fa-share"></i> Referencia
                                                </a>
                                                <br>
                                                <a class="btn btn-info btn-sm" target="_blank" href="index.php?action=medicina_recipe&id_consulta_med=<?php echo $diagnostico['id_consulta_med']; ?>">
                                                    <i class="fas fa-print"></i> Récipe
                                                </a>
                                            </td>
                                            <td>
                                                <a href="index.php?action=medicina_visualizar&id_consulta_med=<?php echo $diagnostico['id_consulta_med']; ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?action=medicina_editar&id_consulta_med=<?php echo $diagnostico['id_consulta_med']; ?>&id_detalle_patologia=<?php echo $diagnostico['id_detalle_patologia']; ?>"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?action=medicina_eliminar&id_consulta_med=<?php echo $diagnostico['id_consulta_med']; ?>&id_solicitud_serv=<?php echo $diagnostico['id_solicitud_serv']; ?>&id_detalle_patologia=<?php echo $diagnostico['id_detalle_patologia']; ?>&id_detalle_insumo=<?php echo $diagnostico['id_detalle_insumo']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta consulta?');">
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
        </section>

        <?php include 'template/footer.php'; ?>
    </div>

    </div>


    <?php include 'template/script.php'; ?>
    <!-- SCRIPT PERSONALIZADOS -->

    <script src="dist/js/diagnosticos/medicina/consulta.js"></script>

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