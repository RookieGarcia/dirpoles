<?php
require_once "app/models/conexion.php";

class Orientacion extends Database {

    public function __construct(){
        parent::__construct();
    }

    public function orientacion_crear($id_beneficiario, $id_servicios, $motivo_orientacion, $indicaciones_orientacion, $descripcion_orientacion, $obs_adic_orientacion) {
        try {
            $this->conn->beginTransaction();
            $id_empleado = $_SESSION['id_empleado'];
            
            $query1 = "INSERT INTO solicitud_de_servicio (id_beneficiario, id_servicios, id_empleado) VALUES (:id_beneficiario, :id_servicios, :id_empleado)";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt1->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
            $stmt1->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt1->execute();
            $id_solicitud_generado = $this->conn->lastInsertId();
            
            $query2 = "INSERT INTO orientacion (id_solicitud_serv, motivo_orientacion, indicaciones_orientacion, descripcion_orientacion, obs_adic_orientacion, fecha_creacion) 
            VALUES (:id_solicitud_serv, :motivo_orientacion, :indicaciones_orientacion, :descripcion_orientacion, :obs_adic_orientacion, CURDATE())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':motivo_orientacion', $motivo_orientacion, PDO::PARAM_STR);
            $stmt2->bindParam(':indicaciones_orientacion', $indicaciones_orientacion, PDO::PARAM_STR);
            $stmt2->bindParam(':descripcion_orientacion', $descripcion_orientacion, PDO::PARAM_STR);
            $stmt2->bindParam(':obs_adic_orientacion', $obs_adic_orientacion, PDO::PARAM_STR);
            $stmt2->execute();
            $id_consulta_orientacion_generado = $this->conn->lastInsertId();

            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Orientación', 'Registro', 'Diagnostico registrado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al crear la consulta orientacion: " . $e->getMessage();
            return false;
        }
    }

    public function orientacion_actualizar($id_orientacion, $id_solicitud_serv, $id_beneficiario, $motivo_orientacion, $indicaciones_orientacion, $descripcion_orientacion, $obs_adic_orientacion) {
        try {
            $this->conn->beginTransaction();

            $query2 = "UPDATE orientacion SET 
                        motivo_orientacion = :motivo_orientacion, 
                        indicaciones_orientacion = :indicaciones_orientacion, 
                        descripcion_orientacion = :descripcion_orientacion, 
                        obs_adic_orientacion = :obs_adic_orientacion 
                        WHERE id_orientacion = :id_orientacion";

            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_orientacion', $id_orientacion, PDO::PARAM_INT);
            $stmt2->bindParam(':motivo_orientacion', $motivo_orientacion, PDO::PARAM_STR);
            $stmt2->bindParam(':indicaciones_orientacion', $indicaciones_orientacion, PDO::PARAM_STR);
            $stmt2->bindParam(':descripcion_orientacion', $descripcion_orientacion, PDO::PARAM_STR);
            $stmt2->bindParam(':obs_adic_orientacion', $obs_adic_orientacion, PDO::PARAM_STR);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Orientación', 'Actualización', 'Diagnostico actualizado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al actualizar la consulta orientacion: " . $e->getMessage();
            return false;
        }
    }

    public function orientacion_eliminar($id_orientacion, $id_solicitud_serv) {
        try {
            $this->conn->beginTransaction();

            $query1 = "DELETE FROM orientacion WHERE id_orientacion = :id_orientacion";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_orientacion', $id_orientacion, PDO::PARAM_INT);
            $stmt1->execute();

            $query2 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv"; 
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Orientación', 'Eliminación', 'Diagnostico eliminado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al eliminar la consulta orientacion: " . $e->getMessage();
            return false;
        }
    }

    public function Servicios() {
        $query = "SELECT * FROM servicio WHERE id_servicios = 4";
        $stmt = $this->conn->query($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarBeneficiarios() {
        $query = "
        SELECT 
            beneficiario.id_beneficiario, 
            beneficiario.nombres, 
            beneficiario.apellidos, 
            beneficiario.tipo_cedula, 
            beneficiario.cedula, 
            beneficiario.fecha_nac, 
            beneficiario.telefono, 
            beneficiario.correo, 
            beneficiario.genero, 
            beneficiario.direccion, 
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

    public function consulta_orientacion() {
        $query = "
            SELECT 
                cm.id_orientacion,
                CONCAT(b.nombres, ' ', b.apellidos) AS nombre_beneficiario,
                cm.motivo_orientacion,
                cm.indicaciones_orientacion,
                cm.descripcion_orientacion,
                cm.obs_adic_orientacion,
                ss.id_solicitud_serv,
                cm.fecha_creacion
            FROM 
                orientacion cm
            LEFT JOIN 
                solicitud_de_servicio ss ON cm.id_solicitud_serv = ss.id_solicitud_serv
            LEFT JOIN 
                beneficiario b ON ss.id_beneficiario = b.id_beneficiario";

        $stmt = $this->conn->query($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatosConsultaOrientacion($id_orientacion) {
        $query = "
            SELECT 
                cm.id_orientacion,
                cm.motivo_orientacion,
                cm.indicaciones_orientacion,
                cm.descripcion_orientacion,
                cm.obs_adic_orientacion,
                cm.fecha_creacion,
                
                -- Datos del beneficiario
                b.id_beneficiario,
                b.nombres AS nombre_beneficiario,
                b.apellidos AS apellido_beneficiario,
                b.cedula,
                
                -- Datos del servicio
                s.id_servicios,
                s.nombre_serv,
                            
                -- Obtener id_solicitud_serv desde la tabla solicitud_de_servicio
                ss.id_solicitud_serv,

                -- Datos del empleado (ahora se obtiene de solicitud_de_servicio)
                e.id_empleado,
                e.nombre,
                e.apellido,
                CONCAT (e.nombre, ' ', e.apellido) AS nombres_empleado,
                te.tipo,
                e.telefono

            FROM 
                orientacion cm
            LEFT JOIN 
                solicitud_de_servicio ss ON cm.id_solicitud_serv = ss.id_solicitud_serv
            LEFT JOIN 
                beneficiario b ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN 
                servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN
                empleado e ON ss.id_empleado = e.id_empleado
            LEFT JOIN
                tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
            WHERE 
                cm.id_orientacion = :id_orientacion";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_orientacion', $id_orientacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
