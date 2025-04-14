<?php require_once 'app/models/Conexion.php';

class Discapacidad extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function discapacidad_registrar($id_beneficiario, $id_servicios, $condicion_medica, $cirugia_prev, $toma_medicamentos_reg, $naturaleza_discapacidad, $impacto_disc, $habilidades_funcionales_b, $requiere_asistencia, $dispositivo_asistencia, $salud_mental, $apoyo_psicologico, $carnet_discapacidad){
        try{
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];

            $query = "INSERT INTO solicitud_de_servicio (id_beneficiario, id_servicios, id_empleado) VALUES (:id_beneficiario, :id_servicios, :id_empleado)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt->execute();
            $id_solicitud_generado = $this->conn->lastInsertId();

            $query2 = "INSERT INTO discapacidad (
            id_solicitud_serv, 
            condicion_medica, 
            cirugia_prev, 
            toma_medicamentos_reg, 
            naturaleza_discapacidad, 
            impacto_disc, 
            habilidades_funcionales_b, 
            requiere_asistencia, 
            dispositivo_asistencia, 
            salud_mental, 
            apoyo_psicologico, 
            fecha_creacion, 
            carnet_discapacidad) 
            VALUES (
            :id_solicitud_serv, 
            :condicion_medica, 
            :cirugia_prev, 
            :toma_medicamentos_reg, 
            :naturaleza_discapacidad, 
            :impacto_disc, 
            :habilidades_funcionales_b, 
            :requiere_asistencia, 
            :dispositivo_asistencia, 
            :salud_mental, 
            :apoyo_psicologico, 
            curdate(), 
            :carnet_discapacidad)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':condicion_medica', $condicion_medica, PDO::PARAM_STR);
            $stmt2->bindParam(':cirugia_prev', $cirugia_prev, PDO::PARAM_STR);
            $stmt2->bindParam(':toma_medicamentos_reg', $toma_medicamentos_reg, PDO::PARAM_STR);
            $stmt2->bindParam(':naturaleza_discapacidad', $naturaleza_discapacidad, PDO::PARAM_STR);
            $stmt2->bindParam(':impacto_disc', $impacto_disc, PDO::PARAM_STR);
            $stmt2->bindParam(':habilidades_funcionales_b', $habilidades_funcionales_b, PDO::PARAM_STR);
            $stmt2->bindParam(':requiere_asistencia', $requiere_asistencia, PDO::PARAM_STR);
            $stmt2->bindParam(':dispositivo_asistencia', $dispositivo_asistencia, PDO::PARAM_STR);
            $stmt2->bindParam(':salud_mental', $salud_mental, PDO::PARAM_STR);
            $stmt2->bindParam(':apoyo_psicologico', $apoyo_psicologico, PDO::PARAM_STR);
            $stmt2->bindParam(':carnet_discapacidad', $carnet_discapacidad, PDO::PARAM_STR);
            $stmt2->execute();

            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Discapacidad', 'Registro', 'Diagnostico registrado con exito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function Beneficiarios() {
        $query = "
        SELECT 
            beneficiario.id_beneficiario, 
            beneficiario.nombres, 
            beneficiario.apellidos, 
            beneficiario.tipo_cedula, 
            beneficiario.cedula,
            beneficiario.estatus, 
            pnf.nombre_pnf AS nombre_pnf
        FROM 
            beneficiario
        JOIN 
            pnf ON beneficiario.id_pnf = pnf.id_pnf
        WHERE 
            beneficiario.estatus = 1
        ORDER BY 
            beneficiario.id_beneficiario ASC";
        
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Servicios(){
        $query = "SELECT * FROM servicio WHERE id_servicios = 6";
        $stmt = $this->conn->query($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function discapacidad_listar($id_empleado, $tipo_empleado){
        $query = "
            SELECT 
                d.*, 
                b.nombres as nombre_beneficiario, 
                b.apellidos as apellido_beneficiario, 
                b.cedula, 
                b.id_pnf, 
                p.nombre_pnf 
            FROM 
                discapacidad d
            INNER JOIN 
                solicitud_de_servicio s ON d.id_solicitud_serv = s.id_solicitud_serv
            INNER JOIN 
                beneficiario b ON s.id_beneficiario = b.id_beneficiario
            INNER JOIN 
                pnf p ON b.id_pnf = p.id_pnf
        ";

        // Condición para filtro
        if ($tipo_empleado !== 'Administrador') {
            $query .= " WHERE s.id_empleado = :id_empleado";
        }
    
        $query .= " ORDER BY d.fecha_creacion DESC";
    
        $stmt = $this->conn->prepare($query);
        
        // Bind param solo si no es admin
        if ($tipo_empleado !== 'Administrador') {
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function discapacidadID($id_discapacidad){
        $query = "
            SELECT 
                d.*,
                d.carnet_discapacidad, 
                b.nombres as nombre_beneficiario, 
                b.apellidos as apellido_beneficiario, 
                b.cedula, 
                b.id_pnf, 
                p.nombre_pnf,
                CONCAT(e.nombre, ' ', e.apellido) as nombres_empleado,
                e.telefono,
                te.tipo
            FROM 
                discapacidad d
            INNER JOIN 
                solicitud_de_servicio s ON d.id_solicitud_serv = s.id_solicitud_serv
            INNER JOIN
                empleado e ON s.id_empleado = e.id_empleado  -- Cambié esta línea para usar la tabla solicitud_de_servicio
            INNER JOIN
                tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
            INNER JOIN 
                beneficiario b ON s.id_beneficiario = b.id_beneficiario
            INNER JOIN 
                pnf p ON b.id_pnf = p.id_pnf
            WHERE d.id_discapacidad = :id_discapacidad
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id_discapacidad', $id_discapacidad, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function discapacidad_actualizar($id_discapacidad, $condicion_medica, $cirugia_prev, $toma_medicamentos_reg, $naturaleza_discapacidad, $impacto_disc, $habilidades_funcionales_b, $requiere_asistencia, $dispositivo_asistencia, $salud_mental, $apoyo_psicologico, $carnet_discapacidad){

        try{
            $this->conn->beginTransaction();

            $query = "UPDATE discapacidad SET 
                condicion_medica = :condicion_medica, 
                cirugia_prev = :cirugia_prev, 
                toma_medicamentos_reg = :toma_medicamentos_reg, 
                naturaleza_discapacidad = :naturaleza_discapacidad, 
                impacto_disc = :impacto_disc, 
                habilidades_funcionales_b = :habilidades_funcionales_b, 
                requiere_asistencia = :requiere_asistencia, 
                dispositivo_asistencia = :dispositivo_asistencia, 
                salud_mental = :salud_mental, 
                apoyo_psicologico = :apoyo_psicologico, 
                carnet_discapacidad = :carnet_discapacidad
                WHERE id_discapacidad = :id_discapacidad";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_discapacidad', $id_discapacidad, PDO::PARAM_INT);
            $stmt->bindParam(':condicion_medica', $condicion_medica, PDO::PARAM_STR);
            $stmt->bindParam(':cirugia_prev', $cirugia_prev, PDO::PARAM_STR);
            $stmt->bindParam(':toma_medicamentos_reg', $toma_medicamentos_reg, PDO::PARAM_STR);
            $stmt->bindParam(':naturaleza_discapacidad', $naturaleza_discapacidad, PDO::PARAM_STR);
            $stmt->bindParam(':impacto_disc', $impacto_disc, PDO::PARAM_STR);
            $stmt->bindParam(':habilidades_funcionales_b', $habilidades_funcionales_b, PDO::PARAM_STR);
            $stmt->bindParam(':requiere_asistencia', $requiere_asistencia, PDO::PARAM_STR);
            $stmt->bindParam(':dispositivo_asistencia', $dispositivo_asistencia, PDO::PARAM_STR);
            $stmt->bindParam(':salud_mental', $salud_mental, PDO::PARAM_STR);
            $stmt->bindParam(':apoyo_psicologico', $apoyo_psicologico, PDO::PARAM_STR);
            $stmt->bindParam(':carnet_discapacidad', $carnet_discapacidad, PDO::PARAM_STR);
            $stmt->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Discapacidad', 'Actualización', 'Diagnostico actualizado con éxito.', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }      
    }

    public function discapacidad_eliminar($id_discapacidad, $id_solicitud_serv){
        try {
            $this->conn->beginTransaction();
    
            $query1 = "DELETE FROM discapacidad WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt = $this->conn->prepare($query1);
            $stmt->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt->execute();
    
            $query2 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt = $this->conn->prepare($query2);
            $stmt->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Discapacidad', 'Eliminación', 'Diagnostico eliminado con éxito.', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            echo 'Ha ocurrido un error: ',  $e->getMessage(), "\n";
            $this->conn->rollBack();
            return false;
        }
    }

}