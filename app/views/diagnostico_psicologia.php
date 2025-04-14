<?php
    $title = "Diagnosticos - Psicologia";
    $nivel1 = "diagnostico";
    $nivel2 = "psicologia";
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
                    <h1>Bienvenido al área de Psicología</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div>
                <div class="btn-group mb-3">
                    <button class="btn btn-primary" id="btnDiagnosticoGeneral">Diagnóstico General</button>
                    <button class="btn btn-primary" id="btnCambioCarrera">Cambio de Carrera</button>
                    <button class="btn btn-primary" id="btnRetiroTemporal">Retiro Temporal</button>
                    <button class="btn btn-primary" id="btnAction">Consultar</button>
                </div>
            </div>

            <!-- Formulario Diagnóstico General -->
            <div id="formDiagnosticoGeneral" class="form-section" style="display: none;">
                <form action="index.php?action=psicologia_registrar" method="POST">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Formulario Diagnóstico General</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <input type="hidden" name="motivo_otro" value="Sin motivo">
                                <div class="col-6">
                                    <label for="motivo" class="col-form-label">Motivo</label>
                                    <input type="text" class="form-control" id="motivo" placeholder="Motivo" value="Diagnóstico General" disabled style="margin-bottom: 0;">
                                    <input type="hidden" name="motivo" value="general">
                                </div>
                                <div class="col-6">
                                    <label for="id_servicios" class="col-form-label">Servicio de:</label>
                                    <input type="hidden" name="id_servicios" value="<?php echo $servicios['id_servicios']; ?>">
                                    <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled style="margin-bottom: 0;">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="id_patologia" class="col-sm-2 col-form-label">Patología</label>
                                <div class="col-sm-10 d-flex align-items-center">
                                    <div class="mr-2">
                                        <select name="id_patologia" id="id_patologia" class="custom-select form-control-border">
                                            <option value="" disabled selected>Seleccione una patología</option>
                                            <?php foreach ($patologias as $patologia): ?>
                                                <option value="<?php echo htmlspecialchars($patologia['id_patologia']); ?>">
                                                    <?php echo htmlspecialchars($patologia['nombre_patologia']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBeneficiario">Seleccionar Beneficiario</button>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="text" id="nombre_beneficiario_cita" class="form-control w-100" placeholder="Beneficiario seleccionado" disabled>
                                        <input type="hidden" name="id_beneficiario" id="id_beneficiario_cita">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="id_empleado" id="hidden_id_empleado">

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <input type="text" id="text_fecha" class="form-control optional" placeholder="Fecha seleccionada" disabled>
                                    <input type="hidden" id="hidden_fecha" name="fecha" class="optional">
                                </div>
                                <div class="col-sm-4 d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary w-100" data-toggle="modal" data-target="#modalCita">
                                        Crear Cita
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" id="text_hora" class="form-control optional" placeholder="Hora seleccionada" disabled>
                                    <input type="hidden" id="hidden_hora" name="hora" class="optional">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diagnostico" class="col-sm-2 col-form-label">Diagnóstico General</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" placeholder="Si no aplica, escriba N/A."></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tratamiento_gen" class="col-sm-2 col-form-label">Tratamiento General</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="tratamiento_gen" placeholder="Si no aplica, escriba N/A." name="tratamiento_gen" rows="3" ></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="observaciones" class="col-sm-2 col-form-label">Observaciones Generales</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="observaciones" placeholder="Si no aplica, escriba N/A." name="observaciones" rows="3"></textarea>
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
                        </div>
                    </div>
                </form>
            </div>


            <!-- Formulario Cambio de Carrera -->
            <div id="formCambioCarrera" class="form-section" style="display: none;">
                <form action="index.php?action=psicologia_registrar_2" method="POST">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Formulario Cambio de Carrera</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                
                                <!-- Primera Columna -->
                                <div class="col-6">
                                    <label for="motivo" class="col-form-label">Motivo del cambio de carrera</label>
                                    <input type="text" class="form-control" id="motivo" placeholder="Motivo" value="Cambio de Carrera" disabled style="margin-bottom: 0;">
                                    <input type="hidden" name="motivo" value="cambio">
                                </div>

                                <!-- Segunda Columna -->
                                <div class="col-6">
                                    <label for="id_servicios" class="col-form-label">Servicio de:</label>
                                    <input type="hidden" name="id_servicios" value="<?php echo $servicios['id_servicios']; ?>">
                                    <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled style="margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modalBeneficiario">Seleccionar Beneficiario</button>
                    
                                <input type="hidden" name="id_beneficiario" id="id_beneficiario_cambio">
                    
                                <input type="text" id="nombre_beneficiario_cambio" class="form-control" placeholder="Beneficiario seleccionado para el cambio de Carrera" disabled style="flex: 1;">
                            </div>

                            <div class="form-group row" style="margin-top: 10px;" >
                                <label for="motivo_otro" class="col-sm-2 col-form-label">Motivo del Cambio de Carrera</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="motivo_otro" placeholder="Si no aplica, escriba N/A." name="motivo_otro" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="observacionesCambio" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Si no aplica, escriba N/A." id="observacionesCambio" name="observaciones" rows="3"></textarea>
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
                        </div>
                    </div>
                </form>
            </div>

            <!-- Formulario Retiro Temporal -->
            <div id="formRetiroTemporal" class="form-section" style="display: none;">
                <form action="index.php?action=psicologia_registrar_2" method="POST">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Formulario Retiro Temporal</h3>
                        </div>
                        <div class="card-body">
                        <div class="form-group row">
                                <!-- Primera Columna -->
                                <div class="col-6">
                                    <label for="motivo" class="col-form-label">Motivo del retiro temporal</label>
                                    <input type="text" class="form-control" id="motivo" placeholder="Motivo" value="Retiro Temporal" disabled style="margin-bottom: 0;">
                                    <input type="hidden" name="motivo" value="retiro">
                                </div>

                                <!-- Segunda Columna -->
                                <div class="col-6">
                                    <label for="id_servicios" class="col-form-label">Servicio de:</label>
                                    <input type="hidden" name="id_servicios" value="<?php echo $servicios['id_servicios']; ?>">
                                    <input type="text" id="id_servicios" class="form-control" value="<?php echo htmlspecialchars($servicios['nombre_serv']); ?>" disabled style="margin-bottom: 0;">
                                </div>
                            </div>

                            <div class="d-flex align-items-center" >
                                <!-- Botón para seleccionar beneficiario -->
                                <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modalBeneficiario">Seleccionar Beneficiario</button>

                                <!-- Input Hidden para el id_beneficiario -->
                                <input type="hidden" name="id_beneficiario" id="id_beneficiario_retiro">

                                <!-- Input Disabled para mostrar los detalles del beneficiario -->
                                <input type="text" id="nombre_beneficiario_retiro" class="form-control" placeholder="Beneficiario seleccionado para el Retiro Temporal" disabled style="flex: 1;">
                            </div>

                            <div class="form-group row" style="margin-top: 10px;">
                                <label for="motivo_otro_retiro" class="col-sm-2 col-form-label">Motivo por el Retiro Temporal</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Si no aplica, escriba N/A." id="motivo_otro_retiro" name="motivo_otro" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="observacionesRetiro" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Si no aplica, escriba N/A." id="observacionesRetiro" name="observaciones" rows="3"></textarea>
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>


<div class="modal fade" id="modalCita" tabindex="-1" role="dialog" aria-labelledby="modalCitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title" id="modalCitaLabel">Crear una Cita</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <?php if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo'): ?>
                        <div class="form-row">
                            <!-- Selección de Psicólogo -->
                            <div class="form-group col-md-6">
                                <label for="id_empleado" class="col-form-label">Selecciona un Psicólogo</label>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalEmpleado">Seleccionar Psicólogo</button>
                            </div>
                            <!-- Visualizar Horarios -->
                            <div class="form-group col-md-6">
                                <label for="horarios" class="col-form-label">Visualizar horarios</label>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalHorarios">Horarios</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nombre_empleado" class="col-form-label">Empleado</label>
                            <input type="hidden" name="id_empleado" id="id_empleado">
                            <input type="text" id="nombre_empleado" class="form-control" placeholder="Empleado seleccionado" disabled>
                            <div id="nombre_empleadoerror" class="text-danger"></div>
                        </div>
                    <?php endif; ?>

                    <!-- Fecha y Hora -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control">
                            <div id="fechaError" class="text-danger"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hora">Hora</label>
                            <input type="time" name="hora" id="hora" class="form-control">
                            <div id="horaError" class="text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" id="guardar_cita">Guardar Cita</button>
            </div>
        </div>
    </div>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                <!-- Tabla de Beneficiarios -->
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
                                        data-apellido="<?php echo htmlspecialchars($beneficiario['apellidos']); ?>"
                                        data-cedula="<?php echo htmlspecialchars($beneficiario['cedula']); ?>"
                                        data-pnf="<?php echo htmlspecialchars($beneficiario['nombre_pnf']); ?>">
                                    Seleccionar
                                </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</div>
<!-- CONTENIDO -->

<?php include 'template/footer.php'; ?>

</div>

<?php include 'template/script.php'; ?>
<!-- SCRIPT PERSONALIZADOS -->
<?php if (isset($_SESSION['form_open']) && $_SESSION['form_open']): ?>
    <script>
        $(document).ready(function() {
            $('#formDiagnosticoGeneral').show();
        });
    </script>
<?php endif; ?>

<script src="dist/js/diagnosticos/psicologia/crear.js"></script>

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
