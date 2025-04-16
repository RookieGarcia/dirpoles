

<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Ficha Técnica: <?= htmlspecialchars($ficha['ficha']['nombre_ficha']) ?></h6>
            <div>
                <a href="index.php?action=inventario_mobiliario_imprimir_ficha&id=<?= $ficha['ficha']['id_ficha'] ?>" 
                   class="btn btn-success btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Imprimir
                </a>
                <a href="index.php?action=inventario_mobiliario_index" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Servicio/Área:</strong> <?= htmlspecialchars($ficha['ficha']['servicio']) ?></p>
                    <p><strong>Responsable:</strong> <?= htmlspecialchars($ficha['ficha']['responsable']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha de Creación:</strong> <?= date('d/m/Y', strtotime($ficha['ficha']['fecha_creacion'])) ?></p>
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($ficha['ficha']['descripcion']) ?></p>
                </div>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Mobiliario Asignado</h5>
            <?php if (!empty($ficha['mobiliario'])): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Marca/Modelo</th>
                            <th>Color</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ficha['mobiliario'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['tipo_mobiliario']) ?></td>
                            <td><?= htmlspecialchars($item['marca']) ?> <?= htmlspecialchars($item['modelo']) ?></td>
                            <td><?= htmlspecialchars($item['color']) ?></td>
                            <td><?= htmlspecialchars($item['estado']) ?></td>
                            <td><?= htmlspecialchars($item['cantidad']) ?></td>
                            <td><?= htmlspecialchars($item['observaciones']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-info">No hay mobiliario asignado a esta ficha</div>
            <?php endif; ?>
            
            <hr>
            
            <h5 class="mb-3">Equipos Asignados</h5>
            <?php if (!empty($ficha['equipos'])): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Marca/Modelo</th>
                            <th>Serial</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ficha['equipos'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['tipo_equipo']) ?></td>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td><?= htmlspecialchars($item['marca']) ?> <?= htmlspecialchars($item['modelo']) ?></td>
                            <td><?= htmlspecialchars($item['serial']) ?></td>
                            <td><?= htmlspecialchars($item['estado']) ?></td>
                            <td><?= htmlspecialchars($item['observaciones']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-info">No hay equipos asignados a esta ficha</div>
            <?php endif; ?>
        </div>
    </div>
</div>

