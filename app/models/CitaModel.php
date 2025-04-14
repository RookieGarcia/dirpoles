<?php 
require_once "app/models/conexion.php";

class Cita extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function cita_crear($fecha, $hora, $id_beneficiario, $id_empleado, $estatus) {
        try{
            $this->conn->beginTransaction();

            $query = "INSERT INTO cita (fecha, hora, id_beneficiario, id_empleado, estatus, fecha_creacion) 
                  VALUES (:fecha, :hora, :id_beneficiario, :id_empleado, :estatus, CURDATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
            $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
            $stmt->execute();

            $id_sesion = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Cita', 'Registro', 'Creación de cita exitosa', NOW())";
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
    
    public function citas_listar($id_empleado, $tipo_empleado) {
        $query = "SELECT c.*, b.nombres AS beneficiario_nombres, b.apellidos AS beneficiario_apellidos, 
                         e.nombre AS empleado_nombre, e.apellido AS empleado_apellido
                  FROM cita c
                  JOIN beneficiario b ON c.id_beneficiario = b.id_beneficiario
                  JOIN empleado e ON c.id_empleado = e.id_empleado";
            // Condición para filtro
            if ($tipo_empleado !== 'Administrador') {
                $query .= " WHERE c.id_empleado = :id_empleado";
            }
    
        $query .= " ORDER BY c.fecha_creacion DESC";
    
        $stmt = $this->conn->prepare($query);
        
        // Bind param solo si no es admin
        if ($tipo_empleado !== 'Administrador') {
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function citas_para_calendario() {
        $query = "
            SELECT 
                c.id_cita,
                c.fecha,
                c.hora,
                e.nombre AS nombre_empleado,
                e.apellido AS apellido_empleado,
                b.nombres AS nombre_beneficiario,
                b.apellidos AS apellido_beneficiario
            FROM 
                cita AS c
            JOIN 
                empleado AS e ON c.id_empleado = e.id_empleado
            JOIN 
                beneficiario AS b ON c.id_beneficiario = b.id_beneficiario
            WHERE 
                c.estatus = 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function listar_psicologos(){
        $query = "
            SELECT e.id_empleado, e.nombre, e.apellido, e.cedula, t.tipo 
            FROM empleado e
            INNER JOIN tipo_empleado t ON e.id_tipo_empleado = t.id_tipo_emp
            WHERE e.id_tipo_empleado = 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function citasID($id_cita) {
        $query = "
            SELECT cita.id_cita, cita.fecha, cita.hora, cita.estatus,
                empleado.id_empleado, empleado.nombre AS nombre_empleado, empleado.apellido AS apellido_empleado,
                beneficiario.id_beneficiario, beneficiario.nombres AS nombres_beneficiario, beneficiario.apellidos AS apellidos_beneficiario, 
                beneficiario.cedula, pnf.nombre_pnf
            FROM cita
            JOIN empleado ON cita.id_empleado = empleado.id_empleado
            JOIN beneficiario ON cita.id_beneficiario = beneficiario.id_beneficiario
            JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
            WHERE cita.id_cita = :id_cita";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function citas_actualizar($id_cita, $fecha, $hora, $estatus){

        try{
            $this->conn->beginTransaction();

            $query = "UPDATE cita SET fecha = :fecha, hora = :hora, estatus = :estatus WHERE id_cita = :id_cita";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
            $stmt->execute();

            $id_sesion = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Cita', 'Actualización', 'Actualización de cita exitosa', NOW())";
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

    public function obtenerHorarios($id_empleado = null) {
        $query = "SELECT h.id_horario, e.nombre AS nombre_empleado, h.dia_semana, h.hora_inicio, h.hora_fin 
                  FROM horario h
                  JOIN empleado e ON h.id_empleado = e.id_empleado";
        
        if ($id_empleado !== null) {
            $query .= " WHERE h.id_empleado = :id_empleado";
        }
    
        $stmt = $this->conn->prepare($query);
        
        if ($id_empleado !== null) {
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    


    public function citas_eliminar($id_cita) {

        try{
            $this->conn->beginTransaction();

            $query1 = "DELETE FROM consulta_psicologica WHERE id_cita = :id_cita";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $stmt1->execute();

            $query2 = "DELETE FROM cita WHERE id_cita = :id_cita";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $stmt2->execute();

            $id_sesion = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Cita', 'Eliminación', 'Eliminación de cita exitosa', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_sesion, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        }catch(PDOException $e){
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function validarHorario($id_empleado, $fecha, $hora) {
        $dia_semana = date('l', strtotime($fecha));
        $dias_traducidos = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        $dia_semana = $dias_traducidos[$dia_semana];
    
        $query = "
            SELECT COUNT(*) as disponible 
            FROM horario 
            WHERE id_empleado = :id_empleado 
              AND dia_semana = :dia_semana 
              AND :hora BETWEEN hora_inicio AND hora_fin
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->bindParam(':dia_semana', $dia_semana, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['disponible'] > 0;
    }

    public function citaExistente($id_empleado, $fecha, $hora) {
        // Verificar citas en la misma hora exacta
        $sql_misma_hora = "SELECT COUNT(*) as total FROM cita 
                          WHERE id_empleado = :id_empleado 
                          AND fecha = :fecha 
                          AND hora = :hora";
    
        $stmt_misma_hora = $this->conn->prepare($sql_misma_hora);
        $stmt_misma_hora->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt_misma_hora->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt_misma_hora->bindParam(':hora', $hora, PDO::PARAM_STR);
        $stmt_misma_hora->execute();
        $misma_hora = $stmt_misma_hora->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    
        // Verificar citas en el intervalo de 30 minutos
        $sql_intervalo = "SELECT COUNT(*) as total FROM cita 
                 WHERE id_empleado = :id_empleado 
                 AND fecha = :fecha 
                 AND (
                     TIME(hora) BETWEEN 
                         SUBTIME(:hora, '00:30:00') 
                         AND 
                         ADDTIME(:hora, '00:30:00')
                 )
                 AND hora != :hora"; // Paréntesis cerrado correctamente
    
        $stmt_intervalo = $this->conn->prepare($sql_intervalo);
        $stmt_intervalo->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt_intervalo->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt_intervalo->bindParam(':hora', $hora, PDO::PARAM_STR);
        $stmt_intervalo->execute();
        $intervalo = $stmt_intervalo->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    
        return [
            'existe_misma_hora' => $misma_hora,
            'existe_intervalo' => $intervalo
        ];
    }
  
}