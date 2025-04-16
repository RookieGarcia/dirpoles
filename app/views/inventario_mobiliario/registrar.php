

<div class="container mt-4">
    <h2 class="text-center mb-4">Registrar Item en Inventario</h2>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Seleccione el tipo de item</h6>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mobiliario-tab" data-toggle="tab" href="#mobiliario" role="tab">Mobiliario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="equipo-tab" data-toggle="tab" href="#equipo" role="tab">Equipo</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="mobiliario" role="tabpanel">
                    <form action="index.php?action=inventario_mobiliario_guardar" method="POST" class="mt-3">
                        <input type="hidden" name="tipo" value="mobiliario">
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="id_tipo_mobiliario">Tipo de Mobiliario</label>
                                <select class="form-control" id="id_tipo_mobiliario" name="id_tipo_mobiliario" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($tiposMobiliario as $tipo): ?>
                                    <option value="<?= $tipo['id_tipo_mobiliario'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_servicios">Ubicación</label>
                                <select class="form-control" id="id_servicios" name="id_servicios" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($servicios as $servicio): ?>
                                    <option value="<?= $servicio['id_servicios'] ?>"><?= htmlspecialchars($servicio['nombre_serv']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="marca">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="modelo">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="Nuevo">Nuevo</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="En reparación">En reparación</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" value="1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion_adicional">Descripción Adicional</label>
                            <textarea class="form-control" id="descripcion_adicional" name="descripcion_adicional" rows="2"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Registrar Mobiliario</button>
                    </form>
                </div>
                
                <div class="tab-pane fade" id="equipo" role="tabpanel">
                    <form action="index.php?action=inventario_mobiliario_guardar" method="POST" class="mt-3">
                        <input type="hidden" name="tipo" value="equipo">
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="id_tipo_equipo">Tipo de Equipo</label>
                                <select class="form-control" id="id_tipo_equipo" name="id_tipo_equipo" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($tiposEquipo as $tipo): ?>
                                    <option value="<?= $tipo['id_tipo_equipo'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_servicios">Ubicación</label>
                                <select class="form-control" id="id_servicios" name="id_servicios" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($servicios as $servicio): ?>
                                    <option value="<?= $servicio['id_servicios'] ?>"><?= htmlspecialchars($servicio['nombre_serv']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="marca">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="modelo">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="serial">Serial</label>
                                <input type="text" class="form-control" id="serial" name="serial" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="Nuevo">Nuevo</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                    <option value="En reparación">En reparación</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion_adicional">Descripción Adicional</label>
                            <textarea class="form-control" id="descripcion_adicional" name="descripcion_adicional" rows="2"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Registrar Equipo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

