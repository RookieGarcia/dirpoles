<?php
require_once "app/models/conexion.php";

class InventarioModel extends Database{

    public function __construct(){
        parent::__construct();
    }

    public function Presentaciones(){
        $query = "SELECT * FROM presentacion_insumo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $presentaciones;
    }

    public function inventario_registrar($id_presentacion, $nombre_insumo, $descripcion, $tipo_insumo, $fecha_vencimiento, $cantidad) {
        $id_empleado = $_SESSION['id_empleado'];
        try {
            $this->conn->beginTransaction();
    
            // Verificar si el insumo ya existe
            $queryCheck = "SELECT COUNT(*) FROM insumos WHERE id_presentacion = :id_presentacion AND nombre_insumo = :nombre_insumo AND tipo_insumo = :tipo_insumo AND fecha_vencimiento = :fecha_vencimiento";
            $stmtCheck = $this->conn->prepare($queryCheck);
            $stmtCheck->bindParam(':id_presentacion', $id_presentacion);
            $stmtCheck->bindParam(':nombre_insumo', $nombre_insumo);
            $stmtCheck->bindParam(':tipo_insumo', $tipo_insumo);
            $stmtCheck->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $stmtCheck->execute();
            $exists = $stmtCheck->fetchColumn();
    
            if ($exists > 0) {
                throw new Exception("El insumo ya existe.");
            }
    
            $query1 = "INSERT INTO insumos (id_presentacion, nombre_insumo, descripcion, tipo_insumo, fecha_vencimiento, fecha_creacion, cantidad, estatus)
                    VALUES (:id_presentacion, :nombre_insumo, :descripcion, :tipo_insumo, :fecha_vencimiento, CURDATE(), :cantidad, :estatus)";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_presentacion', $id_presentacion);
            $stmt1->bindParam(':nombre_insumo', $nombre_insumo);
            $stmt1->bindParam(':descripcion', $descripcion);
            $stmt1->bindParam(':tipo_insumo', $tipo_insumo);
            $stmt1->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $stmt1->bindParam(':cantidad', $cantidad);
            $stmt1->bindParam(':estatus', $estatus);
            $estatus = 'Activo';
            $stmt1->execute();
            $id_insumo_generado = $this->conn->lastInsertId();
    
            $query2 = "INSERT INTO inventario_medico (id_insumo, id_empleado, fecha_movimiento, tipo_movimiento, cantidad, descripcion)
           VALUES (:id_insumo, :id_empleado, NOW(), :tipo_movimiento, :cantidad, :descripcion)";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_insumo', $id_insumo_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->bindParam(':tipo_movimiento', $tipo_movimiento, PDO::PARAM_STR);
            $stmt2->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt2->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $tipo_movimiento = 'Registro';
            $descripcion = 'Nuevo registro';
            $stmt2->execute();

            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Inventario Médico', 'Registro', 'Inventario registrado con exito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();
    
            $this->conn->commit();
    
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al registrar el inventario: " . $e->getMessage();
            return false;
        }
    }
    

    public function inventario_actualizar($id_insumo, $id_presentacion, $nombre_insumo, $descripcion, $tipo_insumo, $fecha_vencimiento, $estatus, $es_desbloqueo) {
        try {
            $this->conn->beginTransaction();

            // Validación estricta para desbloqueos
            if($es_desbloqueo) {
                $hoy = new DateTime();
                $fecha_ingresada = new DateTime($fecha_vencimiento);
                
                if($fecha_ingresada <= $hoy) {
                    throw new Exception("La fecha de vencimiento debe ser futura para reactivar");
                }
            }
    
            $query1 = "UPDATE insumos SET
                        id_presentacion = :id_presentacion,
                        nombre_insumo = :nombre_insumo,
                        descripcion = :descripcion,
                        tipo_insumo = :tipo_insumo,
                        fecha_vencimiento = :fecha_vencimiento,
                        estatus = :estatus
                        WHERE id_insumo = :id_insumo";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_presentacion', $id_presentacion);
            $stmt1->bindParam(':nombre_insumo', $nombre_insumo);
            $stmt1->bindParam(':descripcion', $descripcion);
            $stmt1->bindParam(':tipo_insumo', $tipo_insumo);
            $stmt1->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $stmt1->bindParam(':estatus', $estatus);
            $stmt1->bindParam(':id_insumo', $id_insumo);
            $stmt1->execute();

            $id_empleado = $_SESSION['id_empleado'];
            // Insertar bitacora
            if($es_desbloqueo) {
                $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                            VALUES (:id_empleado, 'Inventario Médico', 'Desbloqueo', 'Inventario desbloqueado con exito.', NOW())";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $stmt2->execute();
            }

                $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                            VALUES (:id_empleado, 'Inventario Médico', 'Actualización', 'Inventario actualizado con exito.', NOW())";
                $stmt3 = $this->conn->prepare($query3);
                $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
                $stmt3->execute();
    
            $this->conn->commit();
    
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al actualizar el inventario: " . $e->getMessage();
            return false;
        }
    }

    public function inventario_eliminar($id_insumo) {
        try {
            $this->conn->beginTransaction();
    
            // 1. Eliminar registros relacionados en inventario_medico
            $query1 = "DELETE FROM inventario_medico WHERE id_insumo = :id_insumo";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id_insumo', $id_insumo);
            $stmt1->execute();
    
            // 2. Eliminar el insumo
            $query2 = "DELETE FROM insumos WHERE id_insumo = :id_insumo";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_insumo', $id_insumo);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Inventario Médico', 'Eliminación', 'Inventario eliminado con exito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al eliminar insumo: " . $e->getMessage()); // Registrar error
            
            return false;
        }
    }

    public function consultar_insumos(){
        $query = "SELECT i.*, p.nombre_presentacion 
                  FROM insumos i
                  INNER JOIN presentacion_insumo p ON i.id_presentacion = p.id_presentacion";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultar_insumos_entrada(){
        $query = "SELECT i.*, p.nombre_presentacion 
                  FROM insumos i
                  INNER JOIN presentacion_insumo p ON i.id_presentacion = p.id_presentacion
                  WHERE i.fecha_vencimiento > CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultar_insumo_por_id($id_insumo){
        $query = "SELECT i.*, p.nombre_presentacion 
                  FROM insumos i
                  INNER JOIN presentacion_insumo p ON i.id_presentacion = p.id_presentacion
                  WHERE i.id_insumo = :id_insumo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_insumo', $id_insumo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }   


    public function registrarEntrada($id_insumo, $cantidad, $descripcion) {
        $id_empleado = $_SESSION['id_empleado'];
        $this->conn->beginTransaction();
        try {
            $query1 = "UPDATE insumos SET cantidad = cantidad + :cantidad WHERE id_insumo = :id_insumo";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':cantidad', $cantidad);
            $stmt1->bindParam(':id_insumo', $id_insumo);
            $stmt1->execute();

            $query2 = "INSERT INTO inventario_medico 
                            (id_insumo, id_empleado, fecha_movimiento, tipo_movimiento, cantidad, descripcion)
                            VALUES 
                            (:id_insumo, :id_empleado, CURDATE(), 'Entrada', :cantidad, :descripcion)";
            
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_insumo', $id_insumo, PDO::PARAM_INT);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt2->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt2->execute();

            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Inventario Médico', 'Registro', 'Entrada del insumo registrada con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en transacción: " . $e->getMessage());
            return false;
        }
    }

    public function inventario_movimientos(){
        $query = "SELECT 
                    im.*, DATE_FORMAT(im.fecha_movimiento, '%d/%m/%Y') AS fecha_format, 
                    i.nombre_insumo, 
                    CONCAT(e.nombre, ' ', e.apellido) AS nombre_empleado
                  FROM inventario_medico im
                  INNER JOIN insumos i ON im.id_insumo = i.id_insumo
                  INNER JOIN empleado e ON im.id_empleado = e.id_empleado
                  ORDER BY im.fecha_movimiento DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validar_stock($id_insumo) {
        $query = "SELECT cantidad FROM insumos WHERE id_insumo = :id_insumo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_insumo', $id_insumo);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado && $resultado['cantidad'] > 0) {
            return true;
        }
        return false;
    }

    public function validar_insumo_medicina($id_insumo) {
        $query = "SELECT COUNT(*) as total FROM detalle_insumo WHERE id_insumo = :id_insumo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_insumo', $id_insumo);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado && $resultado['total'] > 0) {
            return true;
        }
        return false;
    }
    
    

}