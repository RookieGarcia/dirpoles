<?php
require_once "app/models/Conexion.php";

class UserModel extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function authenticate($username, $password) {
        $query = "
            SELECT empleado.*, tipo_empleado.tipo AS nombre_tipo
            FROM empleado
            JOIN tipo_empleado ON empleado.id_tipo_empleado = tipo_empleado.id_tipo_emp
            WHERE empleado.correo = :username AND empleado.clave = :password";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['username' => $username, 'password' => $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function disableUser($username) {
        $query = "UPDATE empleado SET estatus = 0 WHERE correo = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function existe_usuario($username){
        $query = "SELECT correo FROM empleado WHERE correo = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerConteoEmpleados() {
        $query = $this->conn->query("SELECT COUNT(*) as total FROM empleado");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenerConteoBeneficiarios() {
        $query = $this->conn->query("SELECT COUNT(*) as total FROM beneficiario");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenerConteoCitas() {
        $query = $this->conn->query("SELECT COUNT(*) as total FROM cita WHERE fecha >= CURDATE()");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenerConteoDiagnosticos(){
        $query = "SELECT 
                    (SELECT COUNT(*) FROM consulta_medica) AS total_consulta_medica,
                    (SELECT COUNT(*) FROM consulta_psicologica) AS total_consulta_psicologica,
                    (SELECT COUNT(*) FROM discapacidad) AS total_discapacidad,
                    (SELECT COUNT(*) FROM orientacion) AS total_orientacion,
                    (SELECT COUNT(*) FROM fames) AS total_fames,
                    (SELECT COUNT(*) FROM exoneracion) AS total_exoneracion,
                    (SELECT COUNT(*) FROM becas) AS total_becas";
        
        $stmt = $this->conn->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si deseas el total general:
        $total = array_sum($result);
        
        return [
            'por_area' => $result,
            'total' => $total
        ];
    }
    
    public function obtenerCitasPorDia() {
        $query = "
            SELECT DATE(fecha) AS dia, COUNT(*) AS total 
            FROM cita 
            WHERE fecha >= CURDATE() 
              AND fecha < CURDATE() + INTERVAL 7 DAY 
            GROUP BY DATE(fecha) 
            ORDER BY DATE(fecha)
        ";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}

?>