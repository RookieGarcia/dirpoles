<?php
    $title = "Citas - Crear";
    $nivel1 = "citas";
    $nivel2 = "crear";
    include 'template/head.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <?php include 'template/header.php'; 
        include 'template/sidebar.php'; ?>

  <!-- CONTENIDO -->
  <div class="content-wrapper">
    <section class="content-header">
        <h1>Bienvenido al área de Citas</h1>
    </section>
    
    <section class="content">
        <div class="card">
            <div class="card-header bg-navy">
                <h3 class="card-title">Registrar una nueva Cita</h3>
            </div>
            <form id="citaForm" action="index.php?action=citas_registrar" method="POST">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="id_empleado" class="col-sm-3 col-form-label">Selecciona un Psicólogo</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEmpleado">Seleccionar Psicólogo</button>
                        </div>
                    </div>
                    <?php if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo'): ?>
                    <div class="form-group row">
                        <label for="horarios" class="col-sm-3 col-form-label">Visualizar horarios</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalHorarios">Horarios</button>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group row">
                        <label for="nombre_empleado" class="col-sm-3 col-form-label">Empleado</label>
                        <input type="hidden" name="id_empleado" id="id_empleado">
                        <div class="col-sm-6">
                            <input type="text" id="nombre_empleado" class="form-control" placeholder="Empleado seleccionado" disabled>
                            <div id="nombre_empleadoerror" class="text-danger"></div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="fecha" class="col-sm-3 col-form-label">Fecha</label>
                        <div class="col-sm-6">
                            <input type="date" name="fecha" id="fecha" class="form-control">
                            <div id="fechaError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hora" class="col-sm-3 col-form-label">Hora</label>
                        <div class="col-sm-6">
                            <input type="time" name="hora" id="hora" class="form-control">
                            <div id="horaError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_beneficiario" class="col-sm-3 col-form-label">Selecciona un Beneficiario</label>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalBeneficiario">Seleccionar Beneficiario</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre_beneficiario" class="col-sm-3 col-form-label">Beneficiario</label>
                        <input type="hidden" name="id_beneficiario" id="id_beneficiario">
                        <div class="col-sm-6">
                            <input type="text" id="nombre_beneficiario" class="form-control" placeholder="Beneficiario seleccionado" disabled>
                            <div id="nombre_beneficiarioerror" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="estatus" id="estatus" class="form-control" style="display: none;">
                            <option value="1" selected>Activo</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-success w-50">Registrar Cita</button>
                                <input type="reset" class="btn btn-danger w-50" value="Limpiar">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<div class="modal fade" id="modalEmpleado" tabindex="-1" role="dialog" aria-labelledby="modalEmpleadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h5 class="modal-title" id="modalEmpleadoLabel">Seleccionar Empleado</h5>
                <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tabla_empleados" class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-navy"> 
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cédula</th>
                            <th>Empleado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($_SESSION['tipo_empleado'] === 'Administrador'): ?>
                        <?php foreach ($psicologos as $empleado): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($empleado['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($empleado['cedula']); ?></td>
                                <td><?php echo htmlspecialchars($empleado['tipo']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-select-empleado" 
                                            data-id="<?php echo $empleado['id_empleado']; ?>" 
                                            data-nombre="<?php echo htmlspecialchars($empleado['nombre']); ?>" 
                                            data-apellido="<?php echo htmlspecialchars($empleado['apellido']); ?>" 
                                            data-cedula="<?php echo htmlspecialchars($empleado['cedula']); ?>">
                                        Seleccionar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php elseif ($_SESSION['tipo_empleado'] === 'Psicologo'): ?>
                        <?php foreach ($psicologos as $empleado): ?>
                            <?php if ($empleado['id_empleado'] === $_SESSION['id_empleado']): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($empleado['apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($empleado['cedula']); ?></td>
                                    <td><?php echo htmlspecialchars($empleado['tipo']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-select-empleado" 
                                                data-id="<?php echo $empleado['id_empleado']; ?>" 
                                                data-nombre="<?php echo htmlspecialchars($empleado['nombre']); ?>" 
                                                data-apellido="<?php echo htmlspecialchars($empleado['apellido']); ?>" 
                                                data-cedula="<?php echo htmlspecialchars($empleado['cedula']); ?>">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-danger">No tienes permiso para ver esta información</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBeneficiario" tabindex="-1" role="dialog" aria-labelledby="modalBeneficiarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h5 class="modal-title" id="modalBeneficiarioLabel">Seleccionar Beneficiario</h5>
                <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tabla_beneficiarios" class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-navy"> 
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cédula</th>
                            <th>PNF</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($beneficiarios as $beneficiario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($beneficiario['nombres']); ?></td>
                                <td><?php echo htmlspecialchars($beneficiario['apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($beneficiario['cedula']); ?></td>
                                <td><?php echo htmlspecialchars($beneficiario['nombre_pnf']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-select-beneficiario" 
                                            data-id="<?php echo $beneficiario['id_beneficiario']; ?>" 
                                            data-nombre="<?php echo htmlspecialchars($beneficiario['nombres']); ?>" 
                                            data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>">
                                        Seleccionar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHorarios" tabindex="-1" role="dialog" aria-labelledby="modalHorariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h5 class="modal-title" id="modalHorariosLabel">Horarios de los Psicólogos</h5>
                <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr class="bg-navy">
                            <th>#</th>
                            <th>Psicólogo</th>
                            <th>Día</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($horarios)): ?>
                            <?php foreach ($horarios as $index => $horario): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($horario['nombre_empleado']) ?></td>
                                    <td><?= htmlspecialchars($horario['dia_semana']) ?></td>
                                    <td><?= htmlspecialchars($horario['hora_inicio']) ?></td>
                                    <td><?= htmlspecialchars($horario['hora_fin']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No hay horarios disponibles</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pie del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




  <!-- CONTENIDO -->
   
  
  <?php include 'template/footer.php'; ?>
  
</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->

<script src="dist/js/citas/crear.js"></script>

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
