<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-navy">
            <h3 class="card-title">Listado de FAMES</h3>
          </div>
          <div class="card-body">
            <table id="tabla_fames" class="table table-bordered table-striped text-center">
              <thead>
                <tr class="bg-navy">
                  <th>Fecha</th>
                  <th>Nombres</th>
                  <th>Cedula</th>
                  <th>Patologia</th>
                  <th>Tipo de Ayuda</th>
                  <th>Otros</th>
                  <th>Constancia</th>
                  <th>Referencia</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($funcion) && !empty($funcion)) { ?>
                  <?php foreach ($funcion as $bd): ?>
                    <tr>
                      <td><?php echo date("d-m-Y", strtotime($bd['fecha_creacion'])); ?></td>
                      <td><?php echo htmlspecialchars($bd['nombres'] . ' ' . $bd['apellidos']); ?></td>
                      <td><?php echo htmlspecialchars($bd['cedula']); ?></td>
                      <td><?php echo htmlspecialchars($bd['nombre_patologia']); ?></td>
                      <td><?php echo htmlspecialchars($bd['tipo_ayuda']); ?></td>
                      <td><?php echo htmlspecialchars($bd['otro_tipo']); ?></td>
                      <td> <a href="index.php?action=fames_constancia&id=<?php echo $bd['id_fames']; ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-file-pdf"></i>
                        </a>
                      </td>
                      <td> <a href="index.php?action=fames_referencia&id=<?php echo $bd['id_fames']; ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-share"></i>
                        </a>
                      </td>
                      <td>
                        <a href="index.php?action=editar_fames&id=<?php echo $bd['id_fames']; ?>" class="btn btn-warning btn-sm"><i
                            class="fas fa-edit"></i></a>
                        <a href="javascript:void(0);" onclick="confirmarEliminacionFames('<?php echo $bd['id_fames']; ?>', '<?php echo $bd['id_solicitud_serv']; ?>', '<?php echo $bd['id_detalle_patologia']; ?>')"
                          class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                      </td>
                    </tr>
                <?php endforeach;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="dist/js/diagnosticos/trabajador_social/consulta_fames.js"></script>