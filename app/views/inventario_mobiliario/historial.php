

<div class="container mt-4">
    <h2 class="text-center mb-4">Historial de Movimientos</h2>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Registro de Movimientos</h6>
            <a href="index.php?action=inventario_mobiliario_index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableHistorial" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Empleado</th>
                            <th>Tipo</th>
                            <th>Item</th>
                            <th>Movimiento</th>
                            <th>Servicio</th>
                            <th>Ficha</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historial as $movimiento): ?>
                        <tr>
                            <td><?= htmlspecialchars($movimiento['fecha_formato']) ?></td>
                            <td><?= htmlspecialchars($movimiento['empleado']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($movimiento['tipo_item'])) ?></td>
                            <td>
                                <?php if ($movimiento['tipo_item'] == 'mobiliario'): ?>
                                    Mobiliario ID: <?= $movimiento['id_item'] ?>
                                <?php else: ?>
                                    Equipo ID: <?= $movimiento['id_item'] ?>
                                <?php endif; ?>
                            </td>
                            <td><?= ucfirst(htmlspecialchars($movimiento['tipo_movimiento'])) ?></td>
                            <td><?= htmlspecialchars($movimiento['servicio']) ?></td>
                            <td><?= htmlspecialchars($movimiento['ficha']) ?></td>
                            <td><?= htmlspecialchars($movimiento['descripcion']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

