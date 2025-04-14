<?php 
require_once "app/models/conexion.php";

class Psicologia extends Database {
    public function __construct(){
        parent::__construct();
    }

    public function Patologias(){
        $query = "SELECT id_patologia, nombre_patologia FROM patologia WHERE tipo_patologia = 'psicologica'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $patologias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $patologias;
    }

    public function Servicios(){
        $query = "SELECT * FROM servicio WHERE id_servicios = 2";
        $stmt = $this->conn->query($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    

    public function Beneficiarios(){
        $query = "
        SELECT beneficiario.id_beneficiario, beneficiario.nombres, beneficiario.apellidos, beneficiario.tipo_cedula, beneficiario.cedula, beneficiario.fecha_nac, beneficiario.estatus, pnf.nombre_pnf AS nombre_pnf
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        WHERE beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";
        
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function psicologia_registrar($id_empleado, $fecha, $hora, $id_beneficiario, $id_servicios, $id_patologia, $diagnostico, $tratamiento_gen, $observaciones, $motivo_otro, $motivo){
        try{
            $this->conn->beginTransaction();
    
            if (!empty($fecha) && !empty($hora)) {
                $query = "INSERT INTO cita (fecha, hora, id_beneficiario, id_empleado, estatus, fecha_creacion) 
                            VALUES (:fecha, :hora, :id_beneficiario, :id_empleado, 1, CURDATE())";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
                $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
                $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $stmt->execute();
                $id_cita_generado = $this->conn->lastInsertId(); // Obtenemos el ID de la cita generada

                $query5 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Psicología', 'Registro', 'Cita del Diagnostico registrada con éxito.', NOW())";
                $stmt5 = $this->conn->prepare($query5);
                $stmt5->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $stmt5->execute();
            } else {
                $id_cita_generado = null;
            }
    
            $query2 = "INSERT INTO solicitud_de_servicio (id_beneficiario, id_servicios, id_empleado) VALUES (:id_beneficiario, :id_servicios, :id_empleado)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt2->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();
            $id_solicitud_serv = $this->conn->lastInsertId();
    
            $query3 = "INSERT INTO detalle_patologia (id_patologia) VALUES (:id_patologia)";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_patologia', $id_patologia, PDO::PARAM_INT);
            $stmt3->execute();
            $id_detalle_patologia = $this->conn->lastInsertId();
    
            $query4 = "INSERT INTO consulta_psicologica (id_solicitud_serv, id_detalle_patologia, id_cita, diagnostico, tratamiento_gen, observaciones, motivo_otro, motivo, fecha_creacion) 
                        VALUES (:id_solicitud_serv, :id_detalle_patologia, :id_cita, :diagnostico, :tratamiento_gen, :observaciones, :motivo_otro, :motivo, CURDATE())";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt4->bindParam(':id_detalle_patologia', $id_detalle_patologia, PDO::PARAM_INT);
            $stmt4->bindParam(':id_cita', $id_cita_generado, PDO::PARAM_INT);
            $stmt4->bindParam(':diagnostico', $diagnostico, PDO::PARAM_STR);
            $stmt4->bindParam(':tratamiento_gen', $tratamiento_gen, PDO::PARAM_STR);
            $stmt4->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt4->bindParam(':motivo_otro', $motivo_otro, PDO::PARAM_STR);
            $stmt4->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            $stmt4->execute();

            $query6 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', NOW())";
            $stmt6 = $this->conn->prepare($query6);
            $stmt6->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt6->execute();
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al registrar: " . $e->getMessage());
            return false;
        }
    }
    

    public function psicologia_2($id_beneficiario, $id_servicios, $observaciones, $motivo_otro, $motivo){
        try{
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];

            $query2 = "INSERT INTO solicitud_de_servicio (id_beneficiario, id_servicios, id_empleado) VALUES (:id_beneficiario, :id_servicios, :id_empleado)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt2->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();
            $id_solicitud_serv = $this->conn->lastInsertId();


            $query3 = "INSERT INTO consulta_psicologica (id_solicitud_serv, observaciones, motivo_otro, motivo, fecha_creacion) VALUES (:id_solicitud_serv, :observaciones, :motivo_otro, :motivo, CURDATE())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt3->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt3->bindParam(':motivo_otro', $motivo_otro, PDO::PARAM_STR);
            $stmt3->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            $stmt3->execute();

            $query4 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', NOW())";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt4->execute();
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al registrar: " . $e->getMessage();
            return false;
        }
    }


    public function psicologia_listar($id_empleado, $tipo_empleado) {
        $query = "
            SELECT 
                c.id_psicologia,
                s.id_solicitud_serv,
                b.nombres AS nombre_beneficiario,
                b.apellidos AS apellido_beneficiario,
                e.nombre AS nombre_empleado,  -- Nueva columna
                e.apellido AS apellido_empleado, -- Nueva columna
                b.cedula AS cedula_beneficiario,
                ser.nombre_serv,
                p.nombre_patologia,
                ci.fecha AS fecha_cita,
                ci.hora AS hora_cita,
                c.diagnostico,
                c.tratamiento_gen,
                c.observaciones,
                c.motivo_otro,
                c.motivo,
                c.fecha_creacion AS fecha_psicologia
            FROM 
                consulta_psicologica c
            LEFT JOIN 
                solicitud_de_servicio s ON c.id_solicitud_serv = s.id_solicitud_serv
            LEFT JOIN 
                empleado e ON s.id_empleado = e.id_empleado  -- Nuevo JOIN
            LEFT JOIN 
                beneficiario b ON s.id_beneficiario = b.id_beneficiario
            LEFT JOIN 
                servicio ser ON s.id_servicios = ser.id_servicios
            LEFT JOIN 
                detalle_patologia dp ON c.id_detalle_patologia = dp.id_detalle_patologia
            LEFT JOIN 
                patologia p ON dp.id_patologia = p.id_patologia
            LEFT JOIN 
                cita ci ON c.id_cita = ci.id_cita
        ";
    
        // Condición para filtro
        if ($tipo_empleado !== 'Administrador') {
            $query .= " WHERE s.id_empleado = :id_empleado";
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

    public function psicologia_ID($id_psicologia) {
        $query = "
            SELECT 
                c.id_psicologia,
                s.id_solicitud_serv,
                b.nombres AS nombre_beneficiario,
                b.apellidos AS apellido_beneficiario,
                b.cedula AS cedula_beneficiario,
                ser.nombre_serv,
                p.nombre_patologia,
                ci.fecha AS fecha_cita,
                ci.hora AS hora_cita,
                c.diagnostico,
                c.tratamiento_gen,
                c.observaciones,
                c.motivo_otro,
                c.motivo,
                c.fecha_creacion AS fecha_psicologia,
                CONCAT(e.nombre, ' ', e.apellido) AS nombres_empleado,
                e.telefono,
                te.tipo
            FROM 
                consulta_psicologica c
            LEFT JOIN 
                solicitud_de_servicio s ON c.id_solicitud_serv = s.id_solicitud_serv
            LEFT JOIN 
                beneficiario b ON s.id_beneficiario = b.id_beneficiario
            LEFT JOIN 
                servicio ser ON s.id_servicios = ser.id_servicios
            LEFT JOIN 
                detalle_patologia dp ON c.id_detalle_patologia = dp.id_detalle_patologia
            LEFT JOIN 
                patologia p ON dp.id_patologia = p.id_patologia
            LEFT JOIN 
                cita ci ON c.id_cita = ci.id_cita
            LEFT JOIN 
                empleado e ON s.id_empleado = e.id_empleado
            LEFT JOIN 
                tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
            WHERE 
                c.id_psicologia = :id_psicologia
            ORDER BY 
                c.fecha_creacion ASC
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_psicologia', $id_psicologia, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function psicologia_actualizar($id_psicologia, $diagnostico, $tratamiento_gen, $observaciones){
        try {
            $this->conn->beginTransaction();

            $query = "UPDATE consulta_psicologica SET diagnostico = :diagnostico, tratamiento_gen = :tratamiento_gen, observaciones = :observaciones WHERE id_psicologia = :id_psicologia";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_psicologia', $id_psicologia, PDO::PARAM_INT);
            $stmt->bindParam(':diagnostico', $diagnostico, PDO::PARAM_STR);
            $stmt->bindParam(':tratamiento_gen', $tratamiento_gen, PDO::PARAM_STR);
            $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Psicología', 'Actualización', 'Diagnostico actualizado con éxito.', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            $this->conn->rollBack();
            return false;
        }

        
    }

    public function psicologia_actualizar_2($id_psicologia, $motivo_otro, $observaciones){
        try {
            $this->conn->beginTransaction();

            $query = "UPDATE consulta_psicologica SET motivo_otro = :motivo_otro, observaciones = :observaciones WHERE id_psicologia = :id_psicologia";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_psicologia', $id_psicologia, PDO::PARAM_INT);
            $stmt->bindParam(':motivo_otro', $motivo_otro, PDO::PARAM_STR);
            $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Psicología', 'Actualización', 'Diagnostico actualizado con éxito.', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            $this->conn->rollBack();
            return false;
        }
    }

    public function psicologia_eliminar($id_psicologia, $id_solicitud_serv){
        try{
            $this->conn->beginTransaction();

            $query1 = "DELETE FROM consulta_psicologica WHERE id_psicologia = :id_psicologia";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_psicologia', $id_psicologia, PDO::PARAM_INT);
            $stmt1->execute();

            $query2 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Psicología', 'Eliminación', 'Diagnostico eliminado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            $this->conn->rollBack();
            return false;
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