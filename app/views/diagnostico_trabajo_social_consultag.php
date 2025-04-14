<?php
$title = "Trabajo Social - Consulta";
$nivel1 = "diagnostico";
$nivel2 = "trabajo_social";
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
              <h1>Bienvenido al área de Trabajo Social</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 mx-auto mt-2">
              <select id="miSelect" name="ts" class="form-control" onchange="mostrarFormulario(this.value)">
                <option value="" Selected disabled>Selecciona una opcion</option>
                <option value="becas">Becas</option>
                <option value="exoneracion">Exoneracion</option>
                <option value="fames">FAMES</option>
              </select>
            </div>
            
            <div class="container-fluid mt-5" id="contenidoFormulario">
                
            </div>
          </div>
        </div>
    </div>
    </section>
  <!-- CONTENIDO -->

  <?php include 'template/footer.php'; ?>
  </div>


  <?php include 'template/script.php'; ?>
  <!-- SCRIPT PERSONALIZADOS -->
  <?php if (isset($_SESSION['mensaje'])): ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
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

  <script src="dist/js/crear_ts.js" defer></script>

</body>

</html>