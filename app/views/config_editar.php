<?php
    $title = "Configuración - Editar";
    $nivel1 = "configuracion";
    $nivel2 = "editar";
    include 'template/head.php'; 
?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; 
  ?>

  <!-- CONTENIDO -->
  <div class="content-wrapper">
    <section class="content-header">
        <h1>Bienvenido al área de configuración</h1>
    </section>
    
    <section class="content">
        <div class="container">
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Editar <?php echo ucfirst(str_replace('_', ' ', $tabla)); ?></h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=config_actualizar" method="post" id="form_config">
                        <input type="hidden" name="tabla" value="<?php echo htmlspecialchars($tabla); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                        <?php foreach ($columnas as $columna): ?>
                            <div class="form-group">
                                <label for="<?php echo $columna; ?>"><?php echo ucfirst(str_replace('_', ' ', $columna)); ?></label>
                                
                                <?php if ($columna == 'estatus'): ?>
                                    <select name="datos[<?php echo $columna; ?>]" id="<?php echo $columna; ?>" class="form-control" >
                                        <option value="1" <?php echo $registro[$columna] == 1 ? 'selected' : ''; ?>>Activo</option>
                                        <option value="0" <?php echo $registro[$columna] == 0 ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                    <?php elseif ($columna === 'nombre_pnf'): ?>
                                    <input type="text" name="datos[<?php echo $columna; ?>]" id="<?php echo $columna; ?>" class="form-control" value="<?php echo htmlspecialchars($registro[$columna] ?? ''); ?>" required>
                                    <div id="id_pnferror" class="text-danger" style="display: none; font-size: 0.9em;"></div>
                                <?php else: ?>
                                
                                    <input type="text" name="datos[<?php echo $columna; ?>]" id="<?php echo $columna; ?>"
                                        class="form-control" value="<?php echo htmlspecialchars($registro[$columna]); ?>" >
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-success w-50">Actualizar</button>
                                    <a href="index.php?action=config_listar" class="btn btn-danger w-50">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
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
<script src="dist/js/configuracion/editar.js"></script>

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
