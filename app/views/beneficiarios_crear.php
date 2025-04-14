<?php
$title = "Beneficiarios";
$nivel1 = "beneficiarios";
$nivel2 = "crear";
include 'template/head.php';
?>

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
                            <h1>Bienvenido al área de Beneficiarios</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Registrar un nuevo Beneficiario</h3>
                        </div>
                        <div class="card-body">
                            <form action="index.php?action=beneficiarios_registrar" method="POST" onsubmit="concatenarTelefono()">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cedula">Cédula</label>
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <select name="tipo_cedula" id="tipo_cedula" class="form-control">
                                                        <option value="V">V</option>
                                                        <option value="E">E</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Cédula" maxlength="8" pattern="\d{7,8}" title="Debe ingresar una cedula valida" oninput="validarCed(this)">
                                                </div>
                                                <div id="cedulaerror" class="text-danger ml-2"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="id_pnf">PNF</label>
                                            <select name="id_pnf" id="id_pnf" class="form-control">
                                                <option value="" disabled selected>Seleccione un PNF</option>
                                                <?php foreach ($pnfs as $pnf): ?>
                                                    <option value="<?php echo htmlspecialchars($pnf['id_pnf']); ?>">
                                                        <?php echo htmlspecialchars($pnf['nombre_pnf']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div id="id_pnferror" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombres">Nombre</label>
                                            <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombre" maxlength="50" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios permitidos." oninput="validarTextoSinNumerosSimbolos(this, 'nombreerror')">
                                            <div id="nombreerror" class="text-danger"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apellidos">Apellido</label>
                                            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellido" maxlength="50" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios permitidos." oninput="validarTextoSinNumerosSimbolos(this, 'apellidoerror')">
                                            <div id="apellidoerror" class="text-danger"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="correo">Correo</label>
                                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Ingrese un correo electrónico válido." oninput="validarCorreo(this)">
                                            <div id="correoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <div class="form-row">
                                                <div class="col-auto">
                                                    <select name="telefono_prefijo" id="telefono_prefijo" class="form-control">
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
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_nac">Fecha Nacimiento</label>
                                            <input type="date" name="fecha_nac" id="fecha_nac" class="form-control">
                                            <div id="fechaNacimientoError" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="genero">Género</label>
                                            <select name="genero" id="genero" class="form-control">
                                                <option value="" disabled selected>Seleccione</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                            <div id="generoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="estatus" id="estatus" class="custom-select form-control-border" style="display: none;">
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
                                            <textarea name="direccion" id="direccion" class="form-control" placeholder="Dirección" rows="3"></textarea>
                                            <div id="direccionerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="btn-group w-100">
                                            <button type="submit" class="btn btn-success w-50">Registrar</button>
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
        <!-- CONTENIDO -->

        <?php include 'template/footer.php'; ?>
    </div>

    <?php include 'template/script.php'; ?>

    <!-- SCRIPT PERSONALIZADOS -->
     <script src="dist/js/beneficiarios/crear.js"></script>


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