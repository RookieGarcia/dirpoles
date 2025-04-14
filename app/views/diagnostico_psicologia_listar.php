<?php
$title = "Psicologia - Consulta";
$nivel1 = "diagnostico";
$nivel2 = "psicologia";
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
                            <h1>Bienvenido al área de Psicología</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Listado de consultas psicológicas</h3>
                        </div>
                        <div class="card-body">
                            <table id="tabla_psicologia" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr class="bg-navy">
                                        <th>Beneficiario</th>
                                        <th>Motivo</th>
                                        <th>Diagnóstico</th>
                                        <th>Tratamiento</th>
                                        <th>Observaciones</th>
                                        <th>Patología</th>
                                        <th>Fecha Creación</th>
                                        <th>Constancia</th>
                                        <th>Referencia</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($psicologias as $psicologia): ?>
                                        <tr>
                                            <!-- Beneficiario: Concatenación de nombre y apellido + cédula -->
                                            <td>
                                                <?php echo htmlspecialchars($psicologia['nombre_beneficiario'] . ' ' . $psicologia['apellido_beneficiario']); ?>
                                                <br>
                                                <?php echo htmlspecialchars($psicologia['cedula_beneficiario']); ?>
                                            </td>

                                            <!-- Motivo de la consulta psicológica -->
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($psicologia['motivo']); ?>
                                                </div>
                                            </td>

                                            <!-- Diagnóstico -->
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars(!empty($psicologia['diagnostico']) ? $psicologia['diagnostico'] : 'Sin diagnóstico'); ?>
                                                </div>
                                            </td>

                                            <!-- Tratamiento general -->
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars(!empty($psicologia['tratamiento_gen']) ? $psicologia['tratamiento_gen'] : 'Sin tratamiento'); ?>
                                                </div>
                                            </td>


                                            <!-- Observaciones -->
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    <?php echo htmlspecialchars($psicologia['observaciones']); ?>
                                                </div>
                                            </td>

                                            <!-- Patología: Si no hay patología, mostrar "Sin patología" -->
                                            <td>
                                                <?php echo !empty($psicologia['nombre_patologia']) ? htmlspecialchars($psicologia['nombre_patologia']) : 'Sin patología'; ?>
                                            </td>

                                            <!-- Fecha de creación -->
                                            <td>
                                                <?php echo isset($psicologia['fecha_psicologia']) ? date('d/m/Y', strtotime($psicologia['fecha_psicologia'])) : 'Fecha no disponible'; ?>
                                            </td>
                                            <td> 
                                                <a href="index.php?action=psicologia_constancia&id_psicologia=<?php echo $psicologia['id_psicologia']; ?>" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <a class="btn btn-info btn-sm" target="_blank" href="index.php?action=psicologia_referencia&id_psicologia=<?php echo $psicologia['id_psicologia']; ?>">
                                                    <i class="fas fa-share"></i>
                                                </a>
                                            </td>

                                            <!-- Acciones -->
                                            <td>
                                                <a href="index.php?action=psicologia_visualizar&id_psicologia=<?php echo $psicologia['id_psicologia']; ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?action=psicologia_editar&id_psicologia=<?php echo $psicologia['id_psicologia']; ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?action=psicologia_eliminar&id_psicologia=<?php echo $psicologia['id_psicologia']; ?>&id_solicitud_serv=<?php echo $psicologia['id_solicitud_serv']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta consulta psicológica?');">
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

<script src="dist/js/diagnosticos/psicologia/consulta.js"></script>

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