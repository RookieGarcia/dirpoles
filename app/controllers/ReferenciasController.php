<?php require_once 'app/models/ReferenciasModel.php';

function referencias_crear(){
    $modelo = new ReferenciasModel();
    $areas = $modelo->consultar_areas();
    require_once 'app/views/new/referencias/referencia_crear.php';
}