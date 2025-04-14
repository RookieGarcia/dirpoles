<?php
$title = "Empleados - Crear";
$nivel1 = "empleados";
$nivel2 = "crear";
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
                            <h1>Bienvenido al área de Empleados</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Registrar un nuevo Empleado</h3>
                        </div>
                        <div class="card-body">
                            <form action="index.php?action=empleados_registrar" id="formulario-empleado" method="POST" onsubmit="concatenarTelefono()">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <select class="form-control" id="tipo_cedula" name="tipo_cedula">
                                                        <option value="V">V</option>
                                                        <option value="E">E</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Cédula" maxlength="8" pattern="\d{7,8}" title="Debe ingresar una cedula valida" oninput="validarCed(this)">
                                                </div>
                                                <div id="cedulaerror" class="text-danger ml-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" title="Solo se permiten letras y espacios" oninput="validarTextoSinNumerosSimbolos(this, 'nombreerror')">
                                            <div id="nombreerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apellido">Apellido</label>
                                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" title="Solo se permiten letras y espacios" oninput="validarTextoSinNumerosSimbolos(this, 'apellidoerror')">
                                            <div id="apellidoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="correo">Correo</label>
                                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" oninput="validarCorreo(this)">
                                            <div id="correoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <div class="form-row">
                                                <div class="col-auto">
                                                    <select name="telefono_prefijo" id="telefono_prefijo" class=" form-control">
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="0416">0416</option>
                                                        <option value="0426">0426</option>
                                                        <option value="0414">0414</option>
                                                        <option value="0424">0424</option>
                                                        <option value="0412">0412</option>
                                                    </select>
                                                    <div id="telefono_prefijoerror" class="text-danger"></div>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" name="telefono_numero" id="telefono_numero" class="form-control" placeholder="Teléfono" maxlength="7" pattern="\d{7}" title="Debe ingresar 7 dígitos numéricos." oninput="validarTelefono(this)">
                                                    <div id="telefonoerror" class="text-danger"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_tipo_empleado">Cargo</label>
                                            <select name="id_tipo_empleado" id="id_tipo_empleado" class="form-control">
                                                <option value="" disabled selected>Seleccione un tipo de empleado</option>
                                                <?php foreach ($tipos as $tipo): ?>
                                                    <option value="<?php echo htmlspecialchars($tipo['id_tipo_emp']); ?>">
                                                        <?php echo htmlspecialchars($tipo['tipo']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div id="id_tipo_empleadoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_nacimiento">Fecha Nacimiento</label>
                                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                                            <div id="fechaNacimientoError" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="clave">Clave</label>
                                            <input type="password" class="form-control" id="clave" name="clave" placeholder="Clave" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8}$" title="Debe tener exactamente 8 caracteres, incluyendo al menos una letra y un número" maxlength="8" oninput="validarClave()">
                                            <div id="claveerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="custom-select form-control-border" id="estatus" name="estatus" style="display: none;">
                                                <option value="" disabled selected>Seleccione</option>
                                                <option value="1" selected>Activo</option>
                                            </select>
                                            <div id="estatuserror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección" rows="3"></textarea>
                                            <div id="direccionerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="horarios_psicologo" style="display: none;">
                                    <h5>Horarios del Psicólogo</h5>
                                    <div id="horarios_wrapper">
                                    </div>
                                    <button type="button" class="btn btn-success mt-3" id="agregar_horario">
                                        <i class="fas fa-plus"></i> Agregar Horario
                                    </button>
                                    <div id="horarioerror" class="text-danger"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="btn-group w-100">
                                            <button type="submit" id="btnRegistrar" class="btn btn-success w-50">Registrar</button>
                                            <input type="reset" class="btn btn-danger w-50" value="Limpiar">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="telefono" id="telefono">
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <?php include 'template/footer.php'; ?>

    </div>

    <?php include 'template/script.php'; ?>
    <!-- SCRIPT PERSONALIZADOS -->
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="dist/js/empleados/crear.js"></script>

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