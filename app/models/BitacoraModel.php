<?php
require_once "app/config/config.php";

class BitacoraModel extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function obtener_bitacora(){
        $query = "SELECT bitacora.*, DATE_FORMAT(bitacora.fecha, '%d/%m/%Y %H:%i:%s') AS fecha_format, empleado.nombre, empleado.apellido 
        FROM bitacora
        INNER JOIN empleado ON bitacora.id_empleado = empleado.id_empleado 
        ORDER BY bitacora.fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>