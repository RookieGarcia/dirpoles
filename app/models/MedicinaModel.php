<?php
require_once "app/models/conexion.php";

class Medicina extends Database{
    public function __construct(){
        parent::__construct();
    }

    public function medicina_crear(
        $id_beneficiario,
        $id_servicios,
        $id_patologia,
        $insumos,
        $estatura,
        $peso,
        $tipo_sangre,
        $motivo_visita,
        $diagnostico,
        $tratamiento,
        $observaciones
    ) {
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
    
            $query2 = "INSERT INTO detalle_patologia (id_patologia) VALUES (:id_patologia)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_patologia', $id_patologia, PDO::PARAM_INT);
            $stmt2->execute();
            $id_detalle_generado = $this->conn->lastInsertId();
    
            $query3 = "INSERT INTO consulta_medica (id_detalle_patologia, id_solicitud_serv, estatura, peso, tipo_sangre, motivo_visita, diagnostico, tratamiento, observaciones, fecha_creacion) VALUES (:id_detalle_patologia, :id_solicitud_serv, :estatura, :peso, :tipo_sangre, :motivo_visita, :diagnostico, :tratamiento, :observaciones, CURDATE())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_detalle_patologia', $id_detalle_generado, PDO::PARAM_INT);
            $stmt3->bindParam(':id_solicitud_serv', $id_solicitud_generado, PDO::PARAM_INT);
            $stmt3->bindParam(':estatura', $estatura, PDO::PARAM_STR);
            $stmt3->bindParam(':peso', $peso, PDO::PARAM_STR);
            $stmt3->bindParam(':tipo_sangre', $tipo_sangre, PDO::PARAM_STR);
            $stmt3->bindParam(':motivo_visita', $motivo_visita, PDO::PARAM_STR);
            $stmt3->bindParam(':diagnostico', $diagnostico, PDO::PARAM_STR);
            $stmt3->bindParam(':tratamiento', $tratamiento, PDO::PARAM_STR);
            $stmt3->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt3->execute();
            $id_consulta_generado = $this->conn->lastInsertId();
    
            foreach ($insumos as $insumo) {
                $id_insumo = $insumo['id'];
                $cantidad_usada = $insumo['cantidad'];
    
                $query4 = "INSERT INTO detalle_insumo (id_consulta_med, id_insumo, cantidad_usada) VALUES (:id_consulta_med, :id_insumo, :cantidad_usada)";
                $stmt4 = $this->conn->prepare($query4);
                $stmt4->bindParam(':id_consulta_med', $id_consulta_generado, PDO::PARAM_INT);
                $stmt4->bindParam(':id_insumo', $id_insumo, PDO::PARAM_INT);
                $stmt4->bindParam(':cantidad_usada', $cantidad_usada, PDO::PARAM_INT);
                $stmt4->execute();
    
                $query5 = "UPDATE insumos SET cantidad = cantidad - :cantidad_usada WHERE id_insumo = :id_insumo";
                $stmt5 = $this->conn->prepare($query5);
                $stmt5->bindParam(':id_insumo', $id_insumo, PDO::PARAM_INT);
                $stmt5->bindParam(':cantidad_usada', $cantidad_usada, PDO::PARAM_INT);
                $stmt5->execute();
    
                $query6 = "INSERT INTO inventario_medico (id_insumo, id_empleado, fecha_movimiento, tipo_movimiento, cantidad, descripcion) VALUES (:id_insumo, :id_empleado, CURDATE(), 'Salida', :cantidad_usada, :descripcion)";
                $stmt6 = $this->conn->prepare($query6);
                $stmt6->bindParam(':id_insumo', $id_insumo, PDO::PARAM_INT);
                $stmt6->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $stmt6->bindParam(':cantidad_usada', $cantidad_usada, PDO::PARAM_INT);
                $stmt6->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $descripcion = "Salida de insumo para la consulta médica";
                $stmt6->execute();

                $query7 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Inventario Médico', 'Registro', 'Salida registrada con exito.', NOW())";
                $stmt7 = $this->conn->prepare($query7);
                $stmt7->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $stmt7->execute();
            }

            $query8 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Medicina', 'Registro', 'Diagnostico registrado con exito.', NOW())";
            $stmt8 = $this->conn->prepare($query8);
            $stmt8->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt8->execute();
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al crear la consulta médica: " . $e->getMessage();
            return false;
        }
    }
    

    public function medicina_actualizar($id_detalle_patologia, $id_patologia, $estatura, $peso, $tipo_sangre, $motivo_visita, $diagnostico, $tratamiento, $observaciones, $id_consulta_med) {
        try {
            $this->conn->beginTransaction();
    
            $query1 = "UPDATE detalle_patologia SET id_patologia = :id_patologia WHERE id_detalle_patologia = :id_detalle_patologia";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_detalle_patologia', $id_detalle_patologia, PDO::PARAM_INT);
            $stmt1->bindParam(':id_patologia', $id_patologia, PDO::PARAM_INT);
            $stmt1->execute();
    
            $query2 = "UPDATE consulta_medica SET id_detalle_patologia = :id_detalle_patologia, estatura = :estatura, peso = :peso, tipo_sangre = :tipo_sangre, motivo_visita = :motivo_visita, diagnostico = :diagnostico, tratamiento = :tratamiento, observaciones = :observaciones WHERE id_consulta_med = :id_consulta_med";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_detalle_patologia', $id_detalle_patologia, PDO::PARAM_INT);
            $stmt2->bindParam(':estatura', $estatura, PDO::PARAM_STR);
            $stmt2->bindParam(':peso', $peso, PDO::PARAM_STR);
            $stmt2->bindParam(':tipo_sangre', $tipo_sangre, PDO::PARAM_STR);
            $stmt2->bindParam(':motivo_visita', $motivo_visita, PDO::PARAM_STR);
            $stmt2->bindParam(':diagnostico', $diagnostico, PDO::PARAM_STR);
            $stmt2->bindParam(':tratamiento', $tratamiento, PDO::PARAM_STR);
            $stmt2->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt2->bindParam(':id_consulta_med', $id_consulta_med, PDO::PARAM_INT);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Medicina', 'Actualización', 'Diagnostico actualizado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al actualizar la consulta de medicina: " . $e->getMessage();
            return false;
        }
    }
    

    public function medicina_eliminar($id_detalle_patologia, $id_consulta_med, $id_solicitud_serv, $id_detalle_insumo) {
        try {
            $this->conn->beginTransaction();
    
            $query1 = "DELETE FROM detalle_insumo WHERE id_consulta_med = :id_consulta_med";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_consulta_med', $id_consulta_med, PDO::PARAM_INT);
            $stmt1->execute();
    
            $query2 = "DELETE FROM consulta_medica WHERE id_consulta_med = :id_consulta_med";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_consulta_med', $id_consulta_med, PDO::PARAM_INT);
            $stmt2->execute();
    
            $query3 = "DELETE FROM detalle_patologia WHERE id_detalle_patologia = :id_detalle_patologia";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_detalle_patologia', $id_detalle_patologia, PDO::PARAM_INT);
            $stmt3->execute();
    
            $query4 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt4->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query5 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Medicina', 'Eliminación', 'Diagnostico eliminado con éxito.', NOW())";
            $stmt5 = $this->conn->prepare($query5);
            $stmt5->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt5->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al eliminar la consulta de medicina: " . $e->getMessage();
            return false;
        }
    }

    public function Patologias() {
        $query = "SELECT id_patologia, nombre_patologia FROM patologia WHERE tipo_patologia = 'medica'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Servicios(){
        $query = "SELECT * FROM servicio WHERE id_servicios = 3";
        $stmt = $this->conn->query($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function inventario(){
        $query = "SELECT i.*, p.nombre_presentacion 
                  FROM insumos i
                  INNER JOIN presentacion_insumo p ON i.id_presentacion = p.id_presentacion
                  WHERE i.fecha_vencimiento > CURDATE()"; // JOIN con presentacion
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar resultados
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

    public function consultasMedicas($id_empleado, $tipo_empleado) {
        $query = "SELECT 
                    cm.id_consulta_med,
                    cm.estatura,
                    cm.peso,
                    cm.tipo_sangre,
                    cm.motivo_visita,
                    cm.diagnostico,
                    cm.tratamiento,
                    cm.observaciones,
                    cm.fecha_creacion,
                    p.nombre_patologia,
                    dp.id_detalle_patologia,
                    ss.id_solicitud_serv,
                    di.id_detalle_insumo,
                    CONCAT(b.nombres, ' ', b.apellidos) AS beneficiario,
                    CONCAT(e.nombre, ' ', e.apellido) AS empleado,
                    GROUP_CONCAT(i.nombre_insumo, ' (Cant: ', di.cantidad_usada, ') ' SEPARATOR ', ') AS insumos_usados
                  FROM consulta_medica cm
                  INNER JOIN detalle_patologia dp 
                    ON cm.id_detalle_patologia = dp.id_detalle_patologia
                  INNER JOIN patologia p 
                    ON dp.id_patologia = p.id_patologia
                  INNER JOIN solicitud_de_servicio ss 
                    ON cm.id_solicitud_serv = ss.id_solicitud_serv
                  INNER JOIN beneficiario b 
                    ON ss.id_beneficiario = b.id_beneficiario
                  INNER JOIN empleado e 
                    ON ss.id_empleado = e.id_empleado
                  LEFT JOIN detalle_insumo di 
                    ON cm.id_consulta_med = di.id_consulta_med
                  LEFT JOIN insumos i 
                    ON di.id_insumo = i.id_insumo";
    
        // Condición para filtro
        if ($tipo_empleado !== 'Administrador') {
            $query .= " WHERE ss.id_empleado = :id_empleado";
        }
    
        $query .= " GROUP BY cm.id_consulta_med ORDER BY cm.fecha_creacion DESC";
    
        $stmt = $this->conn->prepare($query);
        
        // Bind param solo si no es admin
        if ($tipo_empleado !== 'Administrador') {
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function medicina_id($id_consulta_med) {
        try {
            $query = "
                SELECT 
                    cm.id_consulta_med,
                    CONCAT(b.nombres, ' ', b.apellidos) AS nombre_beneficiario,
                    p.id_patologia,
                    p.nombre_patologia,
                    s.nombre_serv AS servicio,
                    GROUP_CONCAT(CONCAT(ins.nombre_insumo, ' (Cant: ', di.cantidad_usada, ')') SEPARATOR ', ') AS insumos_utilizados,
                    cm.motivo_visita,
                    b.cedula,
                    cm.tipo_sangre,
                    cm.estatura,
                    cm.peso,
                    cm.diagnostico,
                    cm.tratamiento,
                    cm.observaciones,
                    cm.fecha_creacion,
                    s.nombre_serv,
                    dp.id_detalle_patologia,
                    ss.id_solicitud_serv,
                    e.nombre AS nombre_empleado,
                    e.apellido AS apellidos_empleado,
                    CONCAT(
                        SUBSTRING_INDEX(e.nombre, ' ', 1), ' ', 
                        SUBSTRING_INDEX(e.apellido, ' ', 1)
                    ) AS nombres_empleado,
                    te.tipo,
                    e.telefono,
                    te.tipo AS tipo_empleado
                FROM 
                    consulta_medica cm
                LEFT JOIN 
                    solicitud_de_servicio ss ON cm.id_solicitud_serv = ss.id_solicitud_serv
                LEFT JOIN 
                    beneficiario b ON ss.id_beneficiario = b.id_beneficiario
                LEFT JOIN 
                    servicio s ON ss.id_servicios = s.id_servicios
                LEFT JOIN 
                    detalle_patologia dp ON cm.id_detalle_patologia = dp.id_detalle_patologia
                LEFT JOIN 
                    patologia p ON dp.id_patologia = p.id_patologia
                LEFT JOIN 
                    detalle_insumo di ON cm.id_consulta_med = di.id_consulta_med
                LEFT JOIN 
                    insumos ins ON di.id_insumo = ins.id_insumo
                LEFT JOIN 
                    empleado e ON ss.id_empleado = e.id_empleado
                LEFT JOIN 
                    tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
                WHERE 
                    cm.id_consulta_med = :id_consulta_med
                GROUP BY 
                    cm.id_consulta_med
            ";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_consulta_med', $id_consulta_med, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error al obtener los detalles de la consulta médica: " . $e->getMessage();
            return [];
        }
    }
    
}