<?php
    $title = "Beneficiarios - Editar";
    $nivel1 = "beneficiarios";
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
                    <h1>Bienvenido al área de Beneficiarios</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Editar datos del Beneficiario</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?action=beneficiario_actualizar" method="POST">
                        <input type="hidden" name="id_beneficiario" value="<?php echo htmlspecialchars($beneficiarios['id_beneficiario']); ?>">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="id_pnf" class="col-sm-3 col-form-label">PNF</label>
                                        <div class="col-sm-9">
                                        <select name="id_pnf" id="id_pnf" class="custom-select form-control-border">
                                            <option value="" disabled>Seleccione un PNF</option>
                                            <?php foreach ($pnfs as $pnf): ?>
                                                <option value="<?php echo htmlspecialchars($pnf['id_pnf']); ?>" 
                                                    <?php echo ($pnf['id_pnf'] == $beneficiarios['id_pnf']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($pnf['nombre_pnf']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div id="id_pnferror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="nombres" class="col-sm-3 col-form-label">Nombre</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombre" maxlength="50" 
                                                value="<?php echo htmlspecialchars($beneficiarios['nombres']); ?>">
                                                <div id="nombreerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="apellidos" class="col-sm-3 col-form-label">Apellido</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellido" maxlength="50" 
                                                value="<?php echo htmlspecialchars($beneficiarios['apellidos']); ?>">
                                                <div id="apellidoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="cedula" class="col-sm-3 col-form-label">Cédula</label>
                                        <div class="col-sm-9">
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <select name="tipo_cedula" class="custom-select form-control-border">
                                                        <option value="V" <?php echo ($beneficiarios['tipo_cedula'] == 'V') ? 'selected' : ''; ?>>V</option>
                                                        <option value="E" <?php echo ($beneficiarios['tipo_cedula'] == 'E') ? 'selected' : ''; ?>>E</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Cédula" maxlength="8" pattern="\d{7,8}" title="Debe ingresar una cedula valida" oninput="validarCedula(this)"  
                                                        value="<?php echo htmlspecialchars($beneficiarios['cedula']); ?>">
                                                        <div id="cedulaerror" class="text-danger"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="correo" class="col-sm-3 col-form-label">Correo</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Ingrese un correo electrónico válido."  
                                                value="<?php echo htmlspecialchars($beneficiarios['correo']); ?>">
                                                <div id="correoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-3 col-form-label">Teléfono</label>
                                        <div class="col-sm-9">
                                            <div class="form-row">
                                                <div class="col-auto">
                                                    <select name="telefono_prefijo" id="telefono_prefijo" class="custom-select form-control-border">
                                                        <option value="" disabled>Seleccione</option>
                                                        <option value="0416" <?= ($telefono_prefijo == '0416') ? 'selected' : '' ?>>0416</option>
                                                        <option value="0426" <?= ($telefono_prefijo == '0426') ? 'selected' : '' ?>>0426</option>
                                                        <option value="0414" <?= ($telefono_prefijo == '0414') ? 'selected' : '' ?>>0414</option>
                                                        <option value="0424" <?= ($telefono_prefijo == '0424') ? 'selected' : '' ?>>0424</option>
                                                        <option value="0412" <?= ($telefono_prefijo == '0412') ? 'selected' : '' ?>>0412</option>
                                                    </select>
                                                    <div id="telefono_prefijoerror" class="text-danger"></div>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" name="telefono_numero" id="telefono_numero" class="form-control" 
                                                        placeholder="Teléfono" maxlength="7" pattern="\d{7}" 
                                                        title="Debe ingresar 7 dígitos numéricos." 
                                                        oninput="validarTelefono(this)" 
                                                        value="<?= htmlspecialchars($telefono_numero) ?>"> <!-- Usar $telefono_numero -->
                                                    <div id="telefonoerror" class="text-danger"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="fecha_nac" class="col-sm-6 col-form-label">Fecha Nacimiento</label>
                                        <div class="col-sm-6">
                                            <input type="date" name="fecha_nac" id="fecha_nac" class="form-control"  
                                                value="<?php echo htmlspecialchars($beneficiarios['fecha_nac']); ?>">
                                                <div id="fechaNacimientoError" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="genero" class="col-sm-3 col-form-label">Género</label>
                                        <div class="col-sm-9">
                                            <select name="genero" id="genero" class="custom-select form-control-border">
                                                <option value="" disabled>Seleccione</option>
                                                <option value="M" <?php echo ($beneficiarios['genero'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                                                <option value="F" <?php echo ($beneficiarios['genero'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                                            </select>
                                            <div id="generoerror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php $isAdmin = ($_SESSION['tipo_empleado'] == 'Administrador'); ?>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="estatus" class="col-sm-3 col-form-label">Estatus</label>
                                        <div class="col-sm-9">
                                            <select name="estatus" id="estatus" class="custom-select form-control-border" <?php echo !$isAdmin ? 'disabled' : ''; ?>>
                                                <option value="1" <?php echo ($beneficiarios['estatus'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                                <option value="0" <?php echo ($beneficiarios['estatus'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                                            </select>
                                            <div id="estatuserror" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group row">
                                        <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                                        <div class="col-sm-10">
                                            <textarea name="direccion" id="direccion" class="form-control" placeholder="Dirección" rows="3"><?php echo htmlspecialchars($beneficiarios['direccion']); ?></textarea>
                                            <div id="direccionerror" class="text-danger"></div> <!-- Error para dirección -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-success w-50">Actualizar</button>
                                        <a href="index.php?action=beneficiarios_consulta" class="btn btn-danger w-50">Cancelar</a>
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
<script src="dist/js/beneficiarios/editar.js"></script>

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
