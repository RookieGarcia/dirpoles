<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-navy">
            <h3 class="card-title">Listado de becas</h3>
          </div>
          <div class="card-body">
            <div class="dt-buttons-container"></div>
            <table id="tabla_becas" class="table table-bordered table-striped text-center">
              <thead>
                <tr class="bg-navy">
                  <th>Fecha</th>
                  <th>Nombres</th>
                  <th>Cedula</th>
                  <th>PNF</th>
                  <th class="planilla-celda">Planilla de<br>Inscripción</th>
                  <th>Banco</th>
                  <th>Cuenta</th>
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
                      <td class="nombres-celda"><?php echo $bd['nombre_beneficiario']; ?></td>
                      <td><?php echo $bd['cedula']; ?></td>
                      <td><?php echo $bd['nombre_pnf']; ?></td>
                      <td>
                        <button class="btn btn-info btn-sm" onclick="abrirPopupBeca('<?php echo $bd['direccion_pdf']; ?>')">
                          Abrir imagen
                        </button>
                      </td>
                      <td class="bancos-celda"><?php
                                                $bancos = [
                                                  '0102' => 'BANCO DE VENEZUELA',
                                                  '0156' => '100% BANCO',
                                                  '0172' => 'BANCAMIGA BANCO MICROFINANCIERO C.A',
                                                  '0114' => 'BANCARIBE',
                                                  '0171' => 'BANCO ACTIVO',
                                                  '0166' => 'BANCO AGRICOLA DE VENEZUELA',
                                                  '0175' => 'BANCO BICENTENARIO DEL PUEBLO',
                                                  '0128' => 'BANCO CARONI',
                                                  '0163' => 'BANCO DEL TESORO',
                                                  '0115' => 'BANCO EXTERIOR',
                                                  '0151' => 'BANCO FONDO COMUN',
                                                  '0173' => 'BANCO INTERNACIONAL DE DESARROLLO',
                                                  '0105' => 'BANCO MERCANTIL',
                                                  '0191' => 'BANCO NACIONAL DE CREDITO',
                                                  '0138' => 'BANCO PLAZA',
                                                  '0137' => 'BANCO SOFITASA',
                                                  '0104' => 'BANCO VENEZOLANO DE CREDITO',
                                                  '0168' => 'BANCRECER',
                                                  '0134' => 'BANESCO',
                                                  '0177' => 'BANFANB',
                                                  '0146' => 'BANGENTE',
                                                  '0174' => 'BANPLUS',
                                                  '0108' => 'BBVA PROVINCIAL',
                                                  '0157' => 'DELSUR BANCO UNIVERSAL',
                                                  '0169' => 'MI BANCO',
                                                  '0178' => 'N58 BANCO DIGITAL BANCO MICROFINANCIERO S A',
                                                ];

                                                foreach ($bancos as $codigo => $nombre) {
                                                  if ($codigo == $bd['tipo_banco']) {
                                                    echo $nombre;
                                                  }
                                                }
                                                ?></td>

                      <td><?php echo $bd['cta_bcv']; ?></td>
                      <td> <a href="index.php?action=beca_constancia&id=<?php echo $bd['id_becas']; ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-file-pdf"></i>
                        </a>
                      </td>
                      <td> <a href="index.php?action=beca_referencia&id=<?php echo $bd['id_becas']; ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-share"></i>
                        </a>
                      </td>
                      <td>
                        <a href="index.php?action=editar_beca&id=<?php echo $bd['id_becas']; ?>"
                          class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0);"
                          onclick="confirmarEliminacionBeca('<?php echo $bd['id_becas']; ?>', '<?php echo $bd['direccion_pdf']; ?>', '<?php echo $bd['id_solicitud_serv']; ?>')"
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

<!-- SCRIPT PERSONALIZADOS -->
<script src="dist/js/diagnosticos/trabajador_social/consulta_beca.js"></script>
<style>
  #tabla_becas td:not(.nombres-celda):not(.bancos-celda):not(.planilla-celda),
  #tabla_becas th {
    white-space: nowrap;
  }

  .nombres-celda,
  .bancos-celda,
  .planilla-celda {
    white-space: normal;
    word-wrap: break-word;
  }
</style>