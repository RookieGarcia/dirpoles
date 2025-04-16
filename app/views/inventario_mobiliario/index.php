<?php
$title = "Inventario";
$nivel1 = "inventario";
$nivel2 = "mobiliario";
include '../template/head.php';
?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include '../template/header.php';
        include '../template/sidebar.php'; ?>

        <!-- CONTENIDO -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1>Inventario de Mobiliario y Equipos</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Gestión de Inventario</h3>
                            <div class="card-tools">
                                <a href="index.php?action=inventario_mobiliario_registrar" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Registrar Item
                                </a>
                                <a href="index.php?action=inventario_mobiliario_ficha" class="btn btn-primary btn-sm">
                                    <i class="fas fa-file-alt"></i> Crear Ficha
                                </a>
                                <a href="index.php?action=inventario_mobiliario_historial" class="btn btn-info btn-sm">
                                    <i class="fas fa-history"></i> Ver Historial
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="mobiliario-tab" data-toggle="tab" href="#mobiliario" role="tab">Mobiliario</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="equipos-tab" data-toggle="tab" href="#equipos" role="tab">Equipos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="fichas-tab" data-toggle="tab" href="#fichas" role="tab">Fichas Técnicas</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="mobiliario" role="tabpanel">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered" id="dataTableMobiliario" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Marca/Modelo</th>
                                                    <th>Color</th>
                                                    <th>Estado</th>
                                                    <th>Cantidad</th>
                                                    <th>Disponible</th>
                                                    <th>Ubicación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($mobiliario as $item): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($item['tipo_mobiliario']) ?></td>
                                                    <td><?= htmlspecialchars($item['marca']) ?> <?= htmlspecialchars($item['modelo']) ?></td>
                                                    <td><?= htmlspecialchars($item['color']) ?></td>
                                                    <td><?= htmlspecialchars($item['estado']) ?></td>
                                                    <td><?= htmlspecialchars($item['cantidad']) ?></td>
                                                    <td><?= htmlspecialchars($item['disponible']) ?></td>
                                                    <td><?= htmlspecialchars($item['servicio']) ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-info btn-sm" title="Ver historial">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="equipos" role="tabpanel">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered" id="dataTableEquipos" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Nombre</th>
                                                    <th>Marca/Modelo</th>
                                                    <th>Serial</th>
                                                    <th>Estado</th>
                                                    <th>Ubicación</th>
                                                    <th>Disponible</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($equipos as $item): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($item['tipo_equipo']) ?></td>
                                                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                                                    <td><?= htmlspecialchars($item['marca']) ?> <?= htmlspecialchars($item['modelo']) ?></td>
                                                    <td><?= htmlspecialchars($item['serial']) ?></td>
                                                    <td><?= htmlspecialchars($item['estado']) ?></td>
                                                    <td><?= htmlspecialchars($item['servicio']) ?></td>
                                                    <td><?= $item['disponible'] ? 'Sí' : 'No' ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-info btn-sm" title="Ver historial">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="fichas" role="tabpanel">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered" id="dataTableFichas" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Servicio</th>
                                                    <th>Responsable</th>
                                                    <th>Fecha</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fichas as $ficha): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($ficha['nombre_ficha']) ?></td>
                                                    <td><?= htmlspecialchars($ficha['servicio']) ?></td>
                                                    <td><?= htmlspecialchars($ficha['responsable']) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($ficha['fecha_creacion'])) ?></td>
                                                    <td>
                                                        <a href="index.php?action=inventario_mobiliario_ver_ficha&id=<?= $ficha['id_ficha'] ?>" 
                                                           class="btn btn-primary btn-sm" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="index.php?action=inventario_mobiliario_imprimir_ficha&id=<?= $ficha['id_ficha'] ?>" 
                                                           class="btn btn-success btn-sm" title="Imprimir" target="_blank">
                                                            <i class="fas fa-print"></i>
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

        <?php include '../template/footer.php'; ?>
    </div>

    <?php include '../template/script.php'; ?>

    <!-- DataTables JS -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTableMobiliario, #dataTableEquipos, #dataTableFichas').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });
        });
    </script>

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