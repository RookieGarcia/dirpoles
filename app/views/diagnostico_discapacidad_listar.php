<?php
$title = "Discapacidad - Consulta";
$nivel1 = "diagnostico";
$nivel2 = "discapacidad";
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
                            <h1>Bienvenido al área de Discapacidad</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Listado de consultas de Discapacidad</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tabla_discapacidad">
                                    <thead>
                                        <tr class="bg-navy">
                                            <th scope="col">Beneficiario</th>
                                            <th scope="col">Condición Médica</th>
                                            <th scope="col">Naturaleza de la Discapacidad</th>
                                            <th scope="col">Salud Mental</th>
                                            <th scope="col">Recibe Apoyo Psicológico</th>
                                            <th scope="col">Constancia</th>
                                            <th scope="col">Referencia</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($discapacidad): ?>
                                            <?php foreach ($discapacidad as $disc): ?>
                                                <tr>
                                                    <td><?php echo $disc['nombre_beneficiario'] . ' ' . $disc['apellido_beneficiario'] . ' - ' . $disc['cedula']; ?></td>
                                                    <td><?php echo $disc['condicion_medica']; ?></td>
                                                    <td><?php echo $disc['naturaleza_discapacidad']; ?></td>
                                                    <td><?php echo $disc['salud_mental']; ?></td>
                                                    <td><?php echo $disc['apoyo_psicologico']; ?></td>
                                                    <td> <a href="index.php?action=discapacidad_constancia&id_discapacidad=<?php echo $disc['id_discapacidad'];?>" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    </td>
                                                    <td> <a href="index.php?action=discapacidad_referencia&id_discapacidad=<?php echo $disc['id_discapacidad'];?>" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fas fa-share"></i>
                                                        </a>
                                                    </td>
                                                    <th>
                                                        <a class="btn btn-warning btn-sm" href="index.php?action=discapacidad_editar&id_discapacidad=<?php echo $disc['id_discapacidad']; ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="index.php?action=discapacidad_eliminar&id_discapacidad=<?php echo $disc['id_discapacidad']; ?>&id_solicitud_serv=<?php echo $disc['id_solicitud_serv']; ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="12" class="text-center">No hay registros disponibles.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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

    <script src="dist/js/diagnosticos/discapacidad/consulta.js"></script>

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