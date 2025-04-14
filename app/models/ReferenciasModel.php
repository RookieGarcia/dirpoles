<?php
require_once "app/config/config.php";

class ReferenciasModel extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function consultar_areas(){
        $query = "SELECT * FROM servicio";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }

}