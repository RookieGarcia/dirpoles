<?php
require_once "app/config/config.php";

class BeneficiarioModel extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function existeCedula($cedula) {
        $query = "SELECT cedula FROM beneficiario WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function beneficiario_registrar($id_pnf, $nombres, $apellidos, $tipo_cedula, $cedula, $fecha_nac, $telefono, $correo, $genero, $direccion, $estatus){
        $query = "INSERT INTO beneficiario (id_pnf, nombres, apellidos, tipo_cedula, cedula, fecha_nac, telefono, correo, genero, direccion, estatus, fecha_creacion) VALUES (:id_pnf, :nombres, :apellidos, :tipo_cedula, :cedula, :fecha_nac, :telefono, :correo, :genero, :direccion, :estatus, CURDATE())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pnf', $id_pnf, PDO::PARAM_INT);
        $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_cedula', $tipo_cedula, PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nac', $fecha_nac, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);

        $id_sesion = $_SESSION['id_empleado'];
        $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                       VALUES (:id_empleado, 'Beneficiario', 'Registro', 'Registro de beneficiario exitoso', NOW())";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(':id_empleado', $id_sesion, PDO::PARAM_INT);
        $stmt2->execute();
        
        return ($stmt->execute()) ? $this->conn->lastInsertId() : false;
    }


    public function listarBeneficiarios() {
        $query = "
        SELECT beneficiario.id_beneficiario, beneficiario.nombres, beneficiario.apellidos, beneficiario.tipo_cedula, beneficiario.cedula, 
            beneficiario.fecha_nac, beneficiario.telefono, beneficiario.correo, beneficiario.genero, 
            beneficiario.direccion, beneficiario.estatus, pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        ORDER BY beneficiario.id_beneficiario ASC";
    
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function beneficiario_ID($id_beneficiario){
        $query = "SELECT * FROM beneficiario WHERE id_beneficiario = :id_beneficiario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function beneficiarioCedula($tipo_cedula, $cedula, $id_empleado = null, $id_beneficiario = null){
        // Consulta que verifica en ambas tablas usando UNION
        $query = "SELECT COUNT(*) AS total FROM (
            SELECT tipo_cedula, cedula FROM beneficiario 
            WHERE tipo_cedula = :tipo_cedula 
            AND cedula = :cedula 
            " . ($id_beneficiario ? " AND id_beneficiario != :id_beneficiario" : "") . "
            UNION
            SELECT tipo_cedula, cedula FROM empleado 
            WHERE tipo_cedula = :tipo_cedula 
            AND cedula = :cedula 
            " . ($id_empleado ? " AND id_empleado != :id_empleado" : "") . "
          ) AS combined";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tipo_cedula', $tipo_cedula, PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        if ($id_empleado) {
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        }
        if ($id_beneficiario) {
            $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
        }
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0;
    }

    public function validarTelefonoUnico($telefono) {
        $query = "SELECT COUNT(*) AS total FROM (
                    SELECT telefono FROM beneficiario 
                    WHERE telefono = :telefono
                    UNION
                    SELECT telefono FROM empleado 
                    WHERE telefono = :telefono
                  ) AS combined";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->execute();
    
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0;
    }
    

    public function obtenerPNF() {
        $sql = "SELECT id_pnf, nombre_pnf FROM pnf WHERE estatus = 1 ORDER BY nombre_pnf ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        // Verificar los resultados
        $pnfs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pnfs;
    }

    public function beneficiario_actualizar($id_beneficiario, $id_pnf, $nombres, $apellidos, $tipo_cedula, $cedula, $fecha_nac, $telefono, $correo, $genero, $direccion, $estatus) {

        try{
            $this->conn->beginTransaction();

            $query = "UPDATE beneficiario SET id_pnf = :id_pnf, nombres = :nombres, apellidos = :apellidos, tipo_cedula = :tipo_cedula, cedula = :cedula, fecha_nac = :fecha_nac, telefono = :telefono, correo = :correo, genero = :genero, direccion = :direccion, estatus = :estatus WHERE id_beneficiario = :id_beneficiario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt->bindParam(':id_pnf', $id_pnf, PDO::PARAM_INT);
            $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_cedula', $tipo_cedula, PDO::PARAM_STR);
            $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nac', $fecha_nac, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
            $stmt->execute();

            $id_sesion = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                            VALUES (:id_empleado, 'Beneficiario', 'Actualización', 'Actualización de beneficiario exitoso', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_sesion, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        }catch(PDOException $e){
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
            }
            throw $e;
        }
        
    }

    
    public function beneficiario_eliminar($id_beneficiario) {
        try{
            $this->conn->beginTransaction();

            $query = "DELETE FROM beneficiario WHERE id_beneficiario = :id_beneficiario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt->execute();
            
            $id_sesion = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                            VALUES (:id_empleado, 'Beneficiario', 'Eliminación', 'Eliminación de beneficiario exitosa', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_sesion, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        }catch(PDOException $e){
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function validar_beneficiario_solicitud($id_beneficiario){
        $query = "SELECT id_beneficiario FROM solicitud_de_servicio WHERE id_beneficiario = :id_beneficiario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Retorna true si hay registros
    }

    public function validar_beneficiario_cita($id_beneficiario){
        $query = "SELECT id_beneficiario FROM cita WHERE id_beneficiario = :id_beneficiario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    

}