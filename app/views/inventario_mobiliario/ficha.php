

<div class="container mt-4">
    <h2 class="text-center mb-4">Crear Ficha Técnica</h2>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Datos de la Ficha</h6>
        </div>
        <div class="card-body">
            <form id="fichaForm" action="index.php?action=inventario_mobiliario_guardar_ficha" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre_ficha">Nombre de la Ficha</label>
                        <input type="text" class="form-control" id="nombre_ficha" name="nombre_ficha" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="id_servicio">Servicio/Área</label>
                        <select class="form-control" id="id_servicio" name="id_servicio" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($servicios as $servicio): ?>
                            <option value="<?= $servicio['id_servicios'] ?>"><?= htmlspecialchars($servicio['nombre_serv']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_responsable">Responsable</label>
                        <select class="form-control" id="id_responsable" name="id_responsable">
                            <option value="">Seleccione...</option>
                            <?php foreach ($empleados as $empleado): ?>
                            <option value="<?= $empleado['id_empleado'] ?>">
                                <?= htmlspecialchars($empleado['nombre'] . ' ' . $empleado['apellido']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
                </div>
                
                <hr>
                
                <h5 class="mb-3">Seleccionar Items</h5>
                
                <ul class="nav nav-tabs" id="itemsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="mobiliario-tab" data-toggle="tab" href="#mobiliario" role="tab">Mobiliario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="equipos-tab" data-toggle="tab" href="#equipos" role="tab">Equipos</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="itemsTabContent">
                    <div class="tab-pane fade show active" id="mobiliario" role="tabpanel">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="mobiliarioTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Marca/Modelo</th>
                                        <th>Color</th>
                                        <th>Estado</th>
                                        <th>Disponible</th>
                                        <th>Ubicación</th>
                                        <th>Cantidad</th>
                                        <th>Agregar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mobiliario as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['tipo_mobiliario']) ?></td>
                                        <td><?= htmlspecialchars($item['marca']) ?> <?= htmlspecialchars($item['modelo']) ?></td>
                                        <td><?= htmlspecialchars($item['color']) ?></td>
                                        <td><?= htmlspecialchars($item['estado']) ?></td>
                                        <td><?= htmlspecialchars($item['disponible']) ?></td>
                                        <td><?= htmlspecialchars($item['servicio']) ?></td>
                                        <td>
                                            <input type="number" class="form-control cantidad-input" 
                                                   min="1" max="<?= $item['disponible'] ?>" 
                                                   data-id="<?= $item['id_mobiliario'] ?>" 
                                                   style="width: 80px;">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary agregar-mobiliario" 
                                                    data-id="<?= $item['id_mobiliario'] ?>"
                                                    data-tipo="<?= htmlspecialchars($item['tipo_mobiliario']) ?>"
                                                    data-marca="<?= htmlspecialchars($item['marca']) ?>"
                                                    data-modelo="<?= htmlspecialchars($item['modelo']) ?>">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="equipos" role="tabpanel">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="equiposTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Marca/Modelo</th>
                                        <th>Serial</th>
                                        <th>Estado</th>
                                        <th>Disponible</th>
                                        <th>Ubicación</th>
                                        <th>Agregar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($equipos as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['tipo_equipo']) ?></td>
                                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                                        <td><?= htmlspecialchars($item['marca']) ?> <?= htmlspecialchars($item['modelo']) ?></td>
                                        <td><?= htmlspecialchars($item['serial']) ?></td>
                                        <td><?= htmlspecialchars($item['estado']) ?></td>
                                        <td><?= $item['disponible'] ? 'Sí' : 'No' ?></td>
                                        <td><?= htmlspecialchars($item['servicio']) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary agregar-equipo" 
                                                    data-id="<?= $item['id_equipo'] ?>"
                                                    data-tipo="<?= htmlspecialchars($item['tipo_equipo']) ?>"
                                                    data-nombre="<?= htmlspecialchars($item['nombre']) ?>"
                                                    data-serial="<?= htmlspecialchars($item['serial']) ?>">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h5 class="mb-3">Items Seleccionados</h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="selectedItemsTable">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="selectedItemsBody">
                            <!-- Aquí se agregarán dinámicamente los items seleccionados -->
                        </tbody>
                    </table>
                </div>
                
                <input type="hidden" id="mobiliarioData" name="mobiliario">
                <input type="hidden" id="equiposData" name="equipos">
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Guardar Ficha Técnica</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const mobiliarioSeleccionado = [];
    const equiposSeleccionado = [];
    
    // Agregar mobiliario
    $('.agregar-mobiliario').click(function() {
        const id = $(this).data('id');
        const tipo = $(this).data('tipo');
        const marca = $(this).data('marca');
        const modelo = $(this).data('modelo');
        const cantidad = $(this).closest('tr').find('.cantidad-input').val();
        
        if (!cantidad || cantidad < 1) {
            alert('Ingrese una cantidad válida');
            return;
        }
        
        // Verificar si ya está agregado
        if (mobiliarioSeleccionado.some(item => item.id === id)) {
            alert('Este item ya fue agregado');
            return;
        }
        
        const item = {
            id: id,
            tipo: tipo,
            descripcion: `${marca} ${modelo}`,
            cantidad: cantidad,
            observaciones: ''
        };
        
        mobiliarioSeleccionado.push(item);
        actualizarTablaSeleccionados();
    });
    
    // Agregar equipo
    $('.agregar-equipo').click(function() {
        const id = $(this).data('id');
        const tipo = $(this).data('tipo');
        const nombre = $(this).data('nombre');
        const serial = $(this).data('serial');
        
        // Verificar si ya está agregado
        if (equiposSeleccionado.some(item => item.id === id)) {
            alert('Este equipo ya fue agregado');
            return;
        }
        
        const item = {
            id: id,
            tipo: tipo,
            descripcion: `${nombre} (${serial})`,
            observaciones: ''
        };
        
        equiposSeleccionado.push(item);
        actualizarTablaSeleccionados();
    });
    
    // Actualizar tabla de items seleccionados
    function actualizarTablaSeleccionados() {
        const tbody = $('#selectedItemsBody');
        tbody.empty();
        
        // Mobiliario
        mobiliarioSeleccionado.forEach((item, index) => {
            const row = `
                <tr data-type="mobiliario" data-index="${index}">
                    <td>${item.tipo}</td>
                    <td>${item.descripcion}</td>
                    <td>${item.cantidad}</td>
                    <td>
                        <input type="text" class="form-control observaciones-input" 
                               value="${item.observaciones}" 
                               data-index="${index}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger eliminar-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
        
        // Equipos
        equiposSeleccionado.forEach((item, index) => {
            const row = `
                <tr data-type="equipo" data-index="${index}">
                    <td>${item.tipo}</td>
                    <td>${item.descripcion}</td>
                    <td>1</td>
                    <td>
                        <input type="text" class="form-control observaciones-input" 
                               value="${item.observaciones}" 
                               data-index="${index}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger eliminar-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
        
        // Actualizar inputs hidden
        $('#mobiliarioData').val(JSON.stringify(mobiliarioSeleccionado));
        $('#equiposData').val(JSON.stringify(equiposSeleccionado));
    }
    
    // Eliminar item
    $(document).on('click', '.eliminar-item', function() {
        const row = $(this).closest('tr');
        const type = row.data('type');
        const index = row.data('index');
        
        if (type === 'mobiliario') {
            mobiliarioSeleccionado.splice(index, 1);
        } else {
            equiposSeleccionado.splice(index, 1);
        }
        
        actualizarTablaSeleccionados();
    });
    
    // Actualizar observaciones
    $(document).on('change', '.observaciones-input', function() {
        const index = $(this).data('index');
        const type = $(this).closest('tr').data('type');
        const observaciones = $(this).val();
        
        if (type === 'mobiliario') {
            mobiliarioSeleccionado[index].observaciones = observaciones;
        } else {
            equiposSeleccionado[index].observaciones = observaciones;
        }
        
        $('#mobiliarioData').val(JSON.stringify(mobiliarioSeleccionado));
        $('#equiposData').val(JSON.stringify(equiposSeleccionado));
    });
    
    // Validar formulario antes de enviar
    $('#fichaForm').submit(function(e) {
        if (mobiliarioSeleccionado.length === 0 && equiposSeleccionado.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un item para la ficha técnica');
        }
    });
});
</script>

