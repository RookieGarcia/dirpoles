<?php
require_once "app/config/config.php";
class EmpleadoModel extends Database {

    public function __construct(){
        parent::__construct();
    }

    public function validarCedula($tipo_cedula, $cedula){
        // Consulta que verifica en ambas tablas usando UNION
            $query = "SELECT COUNT(*) AS total FROM (
                SELECT tipo_cedula, cedula FROM beneficiario 
                WHERE tipo_cedula = :tipo_cedula AND cedula = :cedula
                UNION
                SELECT tipo_cedula, cedula FROM empleado 
                WHERE tipo_cedula = :tipo_cedula AND cedula = :cedula
            ) AS combined";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tipo_cedula', $tipo_cedula, PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
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

    public function existeCedula($cedula) {
        $query = "SELECT cedula FROM empleado WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function existeCorreo($correo) {
        $query = "SELECT correo FROM empleado WHERE correo = :correo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function tipos_empleados() {
        $query = "SELECT id_tipo_emp, tipo FROM tipo_empleado WHERE estatus = 1 ORDER BY id_tipo_emp ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function empleados_registrar($nombre, $apellido, $tipo_cedula, $cedula, $correo, $telefono, $id_tipo_empleado, $fecha_nacimiento, $direccion, $clave, $estatus) {
        try {
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];
    
            // 1. Insertar el empleado
            $query = "INSERT INTO empleado (nombre, apellido, tipo_cedula, cedula, correo, telefono, id_tipo_empleado, fecha_nacimiento, direccion, clave, estatus, fecha_creacion) 
                      VALUES (:nombre, :apellido, :tipo_cedula, :cedula, :correo, :telefono, :id_tipo_empleado, :fecha_nacimiento, :direccion, :clave, :estatus, CURDATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_cedula', $tipo_cedula, PDO::PARAM_STR);
            $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':id_tipo_empleado', $id_tipo_empleado, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':clave', $clave, PDO::PARAM_STR);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                $this->conn->rollBack();
                return false;
            }
            $id_empleado_insertado = $this->conn->lastInsertId();
    
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                       VALUES (:id_empleado, 'Empleado', 'Registro', 'Registro de empleado exitoso', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();
    
            $this->conn->commit();
            return $id_empleado_insertado;
        } catch (PDOException $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }
    

    public function HorarioPsicologo($id_empleado, $dia_semana, $hora_inicio, $hora_fin) {
        // Validar rango de horas antes de insertar
        if (strtotime($hora_inicio) < strtotime('07:00') || strtotime($hora_fin) > strtotime('16:00')) {
            return false; // Retorna falso si el horario está fuera de rango
        }
    
        $query = "INSERT INTO horario (id_empleado, dia_semana, hora_inicio, hora_fin) 
                  VALUES (:id_empleado, :dia_semana, :hora_inicio, :hora_fin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->bindParam(':dia_semana', $dia_semana, PDO::PARAM_STR);
        $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR);      
        return $stmt->execute();
    }
    

    public function verificarDiaExistente($idEmpleado, $diaSemana) {
        $sql = "SELECT COUNT(*) as total FROM horario WHERE id_empleado = :id_empleado AND dia_semana = :dia_semana";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_empleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(':dia_semana', $diaSemana, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    public function DiaExistente($id_empleado, $dia_semana, $id_horario = null)
    {
        $sql = "SELECT * FROM horario WHERE id_empleado = ? AND dia_semana = ?";
        $params = [$id_empleado, $dia_semana];

        if ($id_horario) {
            $sql .= " AND id_horario != ?";
            $params[] = $id_horario;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    

    
    

    public function empleados_listar(){
        $query = "SELECT empleado.id_empleado, empleado.nombre, empleado.apellido, empleado.tipo_cedula, empleado.cedula, empleado.correo, empleado.telefono, empleado.fecha_nacimiento, empleado.direccion, empleado.clave, empleado.estatus, tipo_empleado.tipo AS tipo FROM empleado JOIN tipo_empleado ON empleado.id_tipo_empleado = tipo_empleado.id_tipo_emp ORDER BY empleado.id_empleado ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function empleados_ID($id_empleado){
        $query = "SELECT * FROM empleado WHERE id_empleado = :id_empleado";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerHorariosPorEmpleado($id_empleado) {
        $query = "SELECT id_horario, dia_semana, hora_inicio, hora_fin FROM horario WHERE id_empleado = :id_empleado";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function HorarioID($id_horario){
        $query = "SELECT dia_semana, hora_inicio, hora_fin FROM horario WHERE id_horario = :id_horario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function horario_editar($id_horario, $dia_semana, $hora_inicio, $hora_fin){
        $query = "UPDATE horario SET dia_semana = :dia_semana, hora_inicio = :hora_inicio, hora_fin = :hora_fin WHERE id_horario = :id_horario ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->bindParam(':dia_semana', $dia_semana, PDO::PARAM_STR);
        $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function horario_eliminar($id_horario){
        $query = "DELETE FROM horario WHERE id_horario = :id_horario ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function empleados_editar($id_empleado, $nombre, $apellido, $tipo_cedula, $cedula, $correo, $telefono, $id_tipo_empleado, $fecha_nacimiento, $direccion, $clave, $estatus) {
        $query = "UPDATE empleado SET 
                    nombre = :nombre, 
                    apellido = :apellido, 
                    tipo_cedula = :tipo_cedula, 
                    cedula = :cedula, 
                    correo = :correo, 
                    telefono = :telefono, 
                    id_tipo_empleado = :id_tipo_empleado, 
                    fecha_nacimiento = :fecha_nacimiento, 
                    direccion = :direccion, 
                    clave = :clave, 
                    estatus = :estatus 
                    WHERE id_empleado = :id_empleado";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_cedula', $tipo_cedula, PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':id_tipo_empleado', $id_tipo_empleado, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':clave', $clave, PDO::PARAM_STR);
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);

        $id_sesion = $_SESSION['id_empleado'];
        $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                       VALUES (:id_empleado, 'Empleado', 'Actualización', 'Actualización de empleado exitoso', NOW())";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(':id_empleado', $id_sesion, PDO::PARAM_INT);
        $stmt2->execute();

        return $stmt->execute();
    
        return $stmt->execute();
    }
    

    public function empleados_eliminar($id_empleado){
        try{
            $this->conn->beginTransaction();

            $query = "DELETE FROM empleado WHERE id_empleado = :id_empleado";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt->execute();

            $id_sesion = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Empleado', 'Eliminacion', 'Eliminacion de empleado exitoso', NOW())";
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

    public function validar_empleado_solicitud($id_empleado){
        $query = "SELECT id_empleado FROM solicitud_de_servicio WHERE id_empleado = :id_empleado";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Retorna true si hay registros
    }

    public function validar_empleado_cita($id_empleado){
        $query = "SELECT id_empleado FROM cita WHERE id_empleado = :id_empleado";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}
?>