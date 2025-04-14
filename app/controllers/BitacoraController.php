<?php
require_once "app/models/BitacoraModel.php";

function bitacora_listar(){
    $modelo = new BitacoraModel();
    $bitacora = $modelo->obtener_bitacora();
    include 'app/views/bitacora_listar.php';
}

?>