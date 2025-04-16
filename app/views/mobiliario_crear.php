<?php
$title = "Mobiliario";
$nivel1 = "Mobiliario";
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
                            <h1>Bienvenido al Inventario de Mobiliario</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Registrar un nuevo Mobiliario</h3>
                        </div>
                        <div class="card-body">
                        <form action="index.php?action=mobiliario_registrar" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_area">Área:</label>
                    <select class="form-control" id="id_area" name="id_area" required>
                        <option value="">Seleccione un área</option>
                        <?php foreach ($areas as $area): ?>
                            <option value="<?= $area['id_area'] ?>"><?= $area['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nombre">Nombre del Mobiliario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="Nuevo">Nuevo</option>
                        <option value="Bueno">Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                        <option value="En reparación">En reparación</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="estatus">Estatus:</label>
                    <select class="form-control" id="estatus" name="estatus" required>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="index.php?action=mobiliario_consulta" class="btn btn-secondary">Cancelar</a>
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

    

</body>

</html>