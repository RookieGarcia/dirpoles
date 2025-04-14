<?php
$title = "Empleados - Editar";
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
            <div class="card">
                <div class="card-header bg-navy">
                    <h3 class="card-title">Editar datos del Empleado</h3>
                </div>
                <div class="card-body">
            <form action="index.php?action=empleados_actualizar" method="POST" onsubmit="concatenarTelefono()">
                <!-- Campo oculto para enviar el ID del empleado -->
                <input type="hidden" name="id_empleado" value="<?php echo htmlspecialchars($empleado['id_empleado']); ?>">

                <div class="row">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                            <div class="col-sm-9">
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" maxlength="50" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios permitidos." value="<?php echo htmlspecialchars($empleado['nombre']); ?>">
                            <div id="nombreerror" class="text-danger"></div> <!-- Error para nombre -->
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="apellido" class="col-sm-3 col-form-label">Apellido</label>
                            <div class="col-sm-9">
                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" maxlength="50" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios permitidos." value="<?php echo htmlspecialchars($empleado['apellido']); ?>">
                            <div id="apellidoerror" class="text-danger"></div> <!-- Error para apellido -->
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="cedula" class="col-sm-2 col-form-label">Cédula</label>
                            <div class="col-sm-10">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <select class="custom-select form-control-border" id="tipo_cedula" name="tipo_cedula">
                                            <option value="V" <?php echo $empleado['tipo_cedula'] == 'V' ? 'selected' : ''; ?>>V</option>
                                            <option value="E" <?php echo $empleado['tipo_cedula'] == 'E' ? 'selected' : ''; ?>>E</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Cédula" maxlength="8" pattern="\d{7,8}" title="Debe ingresar una cedula valida" oninput="validarCedula(this)" value="<?php echo htmlspecialchars($empleado['cedula']); ?>">
                                    <div id="cedulaerror" class="text-danger"></div> <!-- Error para cédula -->
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="correo" class="col-sm-3 col-form-label">Correo</label>
                            <div class="col-sm-9">
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" title="Ingrese un correo electrónico válido." value="<?php echo htmlspecialchars($empleado['correo']); ?>">
                            <div id="correoerror" class="text-danger"></div> <!-- Error para el correo -->
                        </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="telefono" class="col-sm-3 col-form-label">Teléfono</label>
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
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="id_tipo_empleado" class="col-sm-2 col-form-label">Cargo</label>
                            <div class="col-sm-10">
                                <select name="id_tipo_empleado" id="id_tipo_empleado" class="form-control">
                                    <option value="" disabled>Seleccione un tipo de empleado</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?php echo htmlspecialchars($tipo['id_tipo_emp']); ?>" <?php echo $empleado['id_tipo_empleado'] == $tipo['id_tipo_emp'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($tipo['tipo']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="id_tipo_empleadoerror" class="text-danger"></div> <!-- Error para cargo -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="fecha_nacimiento" class="col-sm-6 col-form-label">Fecha Nacimiento</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($empleado['fecha_nacimiento']); ?>">
                                <div id="fechaNacimientoError" class="text-danger"></div> <!-- Error para fecha de nacimiento -->
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="clave" class="col-sm-3 col-form-label">Clave</label>
                            <div class="col-sm-9">
                            <input type="password" class="form-control" id="clave" name="clave" placeholder="Clave" 
       pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8}$" 
       title="Debe tener exactamente 8 caracteres, incluyendo al menos una letra y un número" 
       maxlength="8" 
        oninput="validarClave()">
        <div id="claveerror" class="text-danger"></div> <!-- Error para clave -->
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="estatus" class="col-sm-2 col-form-label">Estatus</label>
                            <div class="col-sm-10">
                                <select class="custom-select form-control-border" id="estatus" name="estatus">
                                    <option value="" disabled>Seleccione</option>
                                    <option value="1" <?php echo $empleado['estatus'] == 1 ? 'selected' : ''; ?>>Activo</option>
                                    <option value="0" <?php echo $empleado['estatus'] == 0 ? 'selected' : ''; ?>>Bloqueado</option>
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
                                <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección" rows="3"><?php echo htmlspecialchars($empleado['direccion']); ?></textarea>
                                <div id="direccionerror" class="text-danger"></div> <!-- Error para dirección -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de Horario -->
                <div id="horarios_psicologo" style="display: none;">
                    <h5>Horarios del Psicólogo</h5>
                    <table class="table table-striped table-bordered" id="tabla_horarios">
                        <thead>
                            <tr>
                                <th>Día</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($horarios as $horario) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($horario['dia_semana']); ?></td>
                                    <td><?= htmlspecialchars($horario['hora_inicio']); ?></td>
                                    <td><?= htmlspecialchars($horario['hora_fin']); ?></td>
                                    <td>
                                        <a href="index.php?action=editar_horario&id_horario=<?= $horario['id_horario']; ?>&id_empleado=<?= $empleado['id_empleado']; ?>" class="btn btn-primary btn-edit btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="index.php?action=eliminar_horario&id_horario=<?= $horario['id_horario']; ?>&id_empleado=<?= $empleado['id_empleado']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este horario?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <div class="btn-group w-100">
                            <button type="submit" id="btnActualizar" class="btn btn-success w-50">Actualizar</button>
                            <a href="index.php?action=empleados_consulta" id="btnCancelar" class="btn btn-danger w-50">Cancelar</a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="telefono" id="telefono">
            </form>
            <button id="agregar_horario" class="btn btn-info btn-sm" style="display: none;">Agregar Horario</button>
            <div id="horarios_wrapper">
                <!-- Aquí se agregarán los nuevos horarios -->
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

<script src="dist/js/empleados/editar.js"></script>

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

