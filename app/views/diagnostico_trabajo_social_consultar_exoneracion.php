<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-navy">
            <h3 class="card-title">Listado de exoneraciones</h3>
          </div>
          <div class="card-body">
            <table id="tabla_exoneraciones" class="table table-bordered table-striped text-center"
              style="width: 100%; table-layout: auto;">
              <thead>
                <tr class="bg-navy">
                  <th>Fecha</th>
                  <th>Nombres</th>
                  <th>Cedula</th>
                  <th>PNF</th>
                  <th>Carta</th>
                  <th>Motivo</th>
                  <th>Discapacitado</th>
                  <th>Carnet Discapacidad</th>
                  <th>Estudio Socio-Economico</th>
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
                      <td><?php echo $bd['nombre_beneficiario']; ?></td>
                      <td><?php echo $bd['cedula']; ?></td>
                      <td><?php echo $bd['nombre_pnf']; ?></td>
                      <td>
                        <button class="btn btn-info btn-sm" onclick="abrirPopupEx('<?php echo $bd['direccion_carta']; ?>')">Abrir
                          Carta</button>
                      </td>
                      <td><?php echo ($bd['motivo'] == 'pqt_grado') ? 'Paquete de Grado' : 'Inscripción'; ?></td>
                      <td><?php echo htmlspecialchars($bd['otro_motivo']); ?></td>
                      <td><?php echo htmlspecialchars($bd['carnet_discapacidad']); ?></td>
                      <td>
                        <button class="btn btn-info btn-sm"
                          onclick="abrirPopupEx('<?php echo $bd['direccion_estudiose']; ?>')">Abrir PDF</button>
                      </td>
                      <td> <a href="index.php?action=ex_constancia&id=<?php echo $bd['id_exoneracion']; ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-file-pdf"></i>
                        </a>
                      </td>
                      <td> <a href="index.php?action=ex_referencia&id=<?php echo $bd['id_exoneracion']; ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-share"></i>
                        </a>
                      </td>
                      <td>
                        <a href="index.php?action=editar_ex&id=<?php echo $bd['id_exoneracion']; ?>"
                          class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0);"
                          onclick="confirmarEliminacionEx('<?php echo $bd['id_exoneracion']; ?>', '<?php echo $bd['direccion_carta']; ?>', '<?php echo $bd['direccion_estudiose']; ?>', '<?php echo $bd['id_solicitud_serv']; ?>')"
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

<script src="dist/js/diagnosticos/trabajador_social/consulta_ex.js"></script>