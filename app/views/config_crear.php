<?php
    $title = "Configuración - Crear";
    $nivel1 = "configuracion";
    $nivel2 = "crear";
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
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Bienvenido al área de Configuración del Sistema</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Presentación de Insumo</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?action=config_registrar">
                        <h4 class="mb-3">Crea una nueva presentación de insumo</h4>
                        <hr>
                        <input type="hidden" name="tabla" value="presentacion_insumo">
                        <div class="row">      
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nombre_presentacion">Nombre Presentación</label>
                                    <input type="text" class="form-control" name="datos[nombre_presentacion]" id="nombre_presentacion" placeholder="Nombre de la Presentación">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-right">
                                <button class="btn btn-success w-25" type="submit">Registrar</button>
                                <button type="reset" class="btn btn-danger w-25">Limpiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card card-primary">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Patología</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?action=config_registrar">
                        <h4 class="mb-3">Crea una nueva patología</h4>
                        <hr>
                        <input type="hidden" name="tabla" value="patologia">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nombre_patologia">Nombre Patología</label>
                                    <input type="text" class="form-control" name="datos[nombre_patologia]" id="nombre_patologia" placeholder="Nombre de la Patología">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tipo_patologia">Tipo de Patología</label>
                                    <select class="custom-select form-control" name="datos[tipo_patologia]" id="estatus" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="medica">Médica</option>
                                        <option value="psicologica">Psicológica</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 text-right">
                                <button class="btn btn-success w-25" type="submit">Registrar</button>
                                <button type="reset" class="btn btn-danger w-25">Limpiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            

            <div class="card card-primary">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Plan Nacional de Formación</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?action=config_registrar" id="form_pnf">
                        <h4 class="mb-3">Crea un nuevo PNF</h4>
                        <hr>
                        <input type="hidden" name="tabla" value="pnf">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="nombre_pnf">Nombre PNF</label>
                                    <input type="text" class="form-control" name="datos[nombre_pnf]" id="nombre_pnf" placeholder="Nombre del PNF">
                                    <div id="id_pnferror" class="text-danger" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="estatus">Estatus</label>
                                    <select class="custom-select form-control" name="datos[estatus]" id="estatus" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 text-right">
                                <button class="btn btn-success w-25" type="submit">Registrar</button>
                                <button type="reset" class="btn btn-danger w-25">Limpiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Formulario Servicio -->
            <div class="card card-primary">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Servicio</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?action=config_registrar">
                        <h4 class="mb-3">Crea un nuevo servicio</h4>
                        <hr>
                        <input type="hidden" name="tabla" value="servicio">
                        <div class="row">
                            <input type="hidden" name="datos[Id_empleado]" value="<?php echo $_SESSION['id_empleado']; ?>">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="nombre_serv">Nombre Servicio</label>
                                    <input type="text" class="form-control" name="datos[nombre_serv]" id="nombre_serv" placeholder="Nombre del Servicio">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="estatus">Estatus</label>
                                    <select class="custom-select form-control" name="datos[estatus]" id="estatus" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 text-right">
                                <button class="btn btn-success w-25" type="submit">Registrar</button>
                                <button type="reset" class="btn btn-danger w-25">Limpiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Formulario Tipo de Empleado -->
            <div class="card card-primary">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Tipo de Empleado</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?action=config_registrar">
                        <h4 class="mb-3">Crea un nuevo tipo de empleado</h4>
                        <hr>
                        <input type="hidden" name="tabla" value="tipo_empleado">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="tipo">Nombre del tipo de Empleado</label>
                                    <input type="text" class="form-control" name="datos[tipo]" id="tipo" placeholder="Nombre del tipo de Empleado">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="estatus">Estatus</label>
                                    <select class="custom-select form-control" name="datos[estatus]" id="estatus" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 text-right">
                                <button class="btn btn-success w-25" type="submit">Registrar</button>
                                <button type="reset" class="btn btn-danger w-25">Limpiar</button>
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
<script src="dist/js/configuracion/crear.js"></script>

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
