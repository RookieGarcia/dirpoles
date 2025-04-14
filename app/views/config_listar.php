<?php
    $title = "Configuración - Consulta";
    $nivel1 = "configuracion";
    $nivel2 = "consultar";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

  <!-- CONTENIDO -->
  <div class="content-wrapper">
    <section class="content-header">
        <h1>Bienvenido al área de configuración</h1>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            <?php foreach ($registros as $tabla => $datos): ?>
                <div class="card">
                    <div class="card-header bg-navy">
                        <h3 class="card-title"> <?php echo ucfirst(str_replace('_', ' ', $tabla)); ?></h3>
                    </div>
                    <div class="card-body">
                        <table id="tabla_<?php echo $tabla; ?>" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr class="bg-navy">
                                    <?php if (!empty($datos)) : ?>
                                        <?php foreach (array_keys($datos[0]) as $columna): ?>
                                            <?php if (!preg_match('/^id_/', $columna)): ?>
                                                <th><?php echo ucfirst(str_replace('_', ' ', $columna)); ?></th>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <th>Acciones</th>
                                    <?php else: ?>
                                        <th>No hay registros</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datos as $fila): ?>
                                    <tr>
                                        <?php foreach ($fila as $columna => $valor): ?>
                                            <?php if (!preg_match('/^id_/', $columna)): ?>
                                                <td>
                                                    <?php 
                                                        if ($columna == 'estatus') {
                                                            echo ($valor == 1) ? 'Activo' : 'Inactivo';
                                                        } else {
                                                            echo htmlspecialchars($valor);
                                                        }
                                                    ?>
                                                </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <td>
                                            <a href="index.php?action=editar_config&tabla=<?php echo $tabla; ?>&id=<?php echo $fila[array_keys($fila)[0]]; ?>" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
  </div>

  <!-- CONTENIDO -->
  
  <?php include 'template/footer.php'; ?>
  
</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->

<script>
    $(function () {
        <?php foreach ($registros as $tabla => $datos): ?>
            $('#tabla_<?php echo $tabla; ?>').DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i> Exportar a Excel',
                        title: '<?php echo ucfirst(str_replace('_', ' ', $tabla)); ?>',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
                        title: '<?php echo ucfirst(str_replace('_', ' ', $tabla)); ?>',
                        className: 'btn btn-danger',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: { columns: ':visible' },
                        customize: function (doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                "dom": 'Bfrtip',
                "language": {
                    "sEmptyTable": "No hay registros disponibles",
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sLoadingRecords": "Cargando...",
                    "sProcessing": "Procesando...",
                    "sSearch": "Buscar:",
                    "sZeroRecords": "No se encontraron resultados",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        <?php endforeach; ?>
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
