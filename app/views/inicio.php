<?php
    $title = "Inicio";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <div class="row">
                <!-- Header Mejorado -->
                <div class="col-12">
                    <div class="card bg-gradient-info mb-4">
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-1"><i class="fas fa-user-shield mr-2"></i>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h2>
                                    <p class="mb-0">Sistema de Gestión Administrativa DIRPOLES - UPTAEB</p>
                                </div>
                                <h2 class="text-white"><?php echo $_SESSION['tipo_empleado']; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjetas de Estadísticas -->
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-gradient-primary shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white"><?php echo $beneficiarios; ?></h3>
                                    <p class="mb-0 text-white">Beneficiarios Activos</p>
                                </div>
                                <i class="fas fa-users fa-3x text-white-50"></i>
                            </div>
                        </div>
                        <a href="index.php?action=beneficiarios_consulta" class="small-box-footer ml-2 text-white">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card bg-gradient-success shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white"><?php echo $empleados; ?></h3>
                                    <p class="mb-0 text-white">Empleados Activos</p>
                                </div>
                                <i class="fas fa-user-tie fa-3x text-white-50"></i>
                            </div>
                        </div>
                        <a href="index.php?action=empleados_consulta" class="small-box-footer ml-2 text-white">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card bg-gradient-warning shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white"><?php echo $citas ?></h3>
                                    <p class="mb-0 text-white">Citas Pendientes</p>
                                </div>
                                <i class="fas fa-calendar-alt fa-3x text-white-50"></i>
                            </div>
                        </div>
                        <a href="index.php?action=citas_listar" class="small-box-footer ml-2 text-white">
                            Más info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card bg-gradient-danger shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white"><?php echo $diagnosticos['total'] ?></h3>
                                    <p class="mb-0 text-white">Diagnósticos totales</p>
                                </div>
                                <i class="fas fa-file-medical fa-3x text-white-50"></i>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer text-white ml-2">
                            Abajo especificados por áreas <i class="fas fa-arrow-circle-down"></i> 
                        </a>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="col-md-6 mt-4">
                    <div class="card shadow">
                        <div class="card-header bg-gradient-info">
                            <h3 class="card-title text-white">
                                <i class="fas fa-chart-pie mr-2"></i>Distribución de Citas (Próximos 7 días)
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="citasChart" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-4">
                    <div class="card shadow">
                        <div class="card-header bg-gradient-info">
                            <h3 class="card-title text-white"><i class="fas fa-chart-bar mr-2"></i>Diagnósticos por Área</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="diagnosticosChart" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <?php if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo'):?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Calendario de Citas</h3>
              </div>
              <div class="card-body">
                <div id="calendar-container">
                  <div id='calendar'></div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>

        
      </div>
    </section>
</div>

  
  <?php include 'template/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<?php include 'template/script.php'; ?>

<script src="dist/js/index.global.js"></script>
<script>
    const diagnosticosPorArea = <?php echo json_encode($diagnosticos['por_area']); ?>;
    const citasPorDia = <?php echo json_encode($citasPorDia); ?>;
</script>
<script src="dist/js/inicio/inicio.js"></script>


<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalTitle">Detalles del Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="eventModalBody">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
    #calendar{
      width: 100% !important;
      height: 75vh;
    }
</style>

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
