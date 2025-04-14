<?php
$title = "DIRPOLES: Referencias - Crear";
$nivel1 = "referencias";
$nivel2 = "crear";
include 'app/views/template/head.php'; ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include 'app/views/template/header.php';
        include 'app/views/template/sidebar.php'; ?>

        <!-- CONTENIDO -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1>Bienvenido al área de Referencias</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Crear Nueva Referencia</h3>
                        </div>
                        <div class="card-body">
                            <form action="index.php?action=referencias_crear" id="formulario-referencia" method="POST">
                                <div class="row">
                                    <!-- Beneficiario -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="beneficiario">Beneficiario</label>
                                            <select class="form-control select2" name="beneficiario_id" id="beneficiario" required>
                                                <option value="">Seleccione un beneficiario</option>
                                                <?php foreach ($beneficiarios as $beneficiario): ?>
                                                    <option value="#"></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div id="beneficiario_error" class="text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Área Origen -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="area_origen">Área Origen</label>
                                            <?php if($_SESSION['tipo_empleado'] === 'Administrador'): ?>
                                                <select class="form-control" name="area_origen_id" id="area_origen" required>
                                                    <option value="">Seleccione un área</option>
                                                    <?php foreach ($areas as $area): ?>
                                                        <option value="<?= $area['id_servicios'] ?>">
                                                            <?= htmlspecialchars($area['nombre_serv']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php else: 
                                                $mapaServicios = [
                                                    'Psicologo'         => ['id' => 2, 'nombre' => 'Psicologia'],
                                                    'Medico'            => ['id' => 3, 'nombre' => 'Medicina'],
                                                    'Trabajador Social' => ['id' => 5, 'nombre' => 'Trabajo Social'],
                                                    'Orientador'        => ['id' => 4, 'nombre' => 'Orientacion'],
                                                    'Discapacidad'      => ['id' => 6, 'nombre' => 'Discapacidad'],
                                                    // Si hay otros tipos (Secretaria, Gerente, etc.) puedes definirlos o dejar que tomen otro valor.
                                                ];
                                                
                                                // Supongamos que en $_SESSION['tipo_empleado'] se tiene exactamente el texto que coincide con las claves del arreglo
                                                if(isset($mapaServicios[$_SESSION['tipo_empleado']])) {
                                                    $id_area = $mapaServicios[$_SESSION['tipo_empleado']]['id'];
                                                    $nombre_area = $mapaServicios[$_SESSION['tipo_empleado']]['nombre'];
                                                } else {
                                                    // En caso de que no esté definido en el mapa, usar lo que ya esté en sesión (por ejemplo)
                                                    $id_area = $_SESSION['id_servicios'];
                                                    $nombre_area = $_SESSION['nombre_serv'];
                                                }
                                            ?>
                                                <select class="form-control" name="area_origen_id" id="area_origen" required disabled>
                                                    <option value="<?= htmlspecialchars($id_area) ?>">
                                                        <?= htmlspecialchars($nombre_area) ?>
                                                    </option>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Área Destino -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="area_destino">Área Destino</label>
                                            <select class="form-control select2" name="area_destino_id" id="area_destino" required>
                                                <option value="">Seleccione área destino</option>
                                                <?php foreach ($areas as $area): ?>
                                                    <?php if($area['id_servicios'] != $area_usuario_actual['id_servicios']): ?>
                                                        <option value="<?= $area['id_servicios'] ?>">
                                                            <?= htmlspecialchars($area['nombre_serv']) ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <div id="area_destino_error" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Motivo -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="motivo">Motivo de Referencia</label>
                                            <textarea class="form-control" name="motivo" id="motivo" rows="3" 
                                                placeholder="Describa el motivo de la derivación..." 
                                                oninput="validarMotivo(this)"
                                                required></textarea>
                                            <div id="motivo_error" class="text-danger"></div>
                                        </div>
                                    </div>

                                    <!-- Síntomas -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sintomas">Síntomas Relevantes</label>
                                            <textarea class="form-control" name="sintomas" id="sintomas" rows="3"
                                                placeholder="Describa los síntomas observados..."
                                                oninput="validarSintomas(this)"></textarea>
                                            <div id="sintomas_error" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documento Adjunto -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="documento">Documento Adjunto (Opcional)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="documento" name="documento" 
                                                    accept=".pdf,.doc,.docx">
                                                <label class="custom-file-label" for="documento">Seleccionar archivo</label>
                                            </div>
                                            <small class="form-text text-muted">Formatos permitidos: PDF, Word (Max 5MB)</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="btn-group w-100">
                                            <button type="submit" class="btn btn-success w-50">
                                                <i class="fas fa-save"></i> Guardar Referencia
                                            </button>
                                            <button type="reset" class="btn btn-danger w-50">
                                                <i class="fas fa-undo"></i> Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos ocultos -->
                                <input type="hidden" name="usuario_origen_id" value="<?= $_SESSION['usuario_id'] ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'app/views/template/footer.php'; ?>

    </div>

    <?php include 'app/views/template/script.php'; ?>
    <!-- SCRIPT PERSONALIZADOS -->
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>

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