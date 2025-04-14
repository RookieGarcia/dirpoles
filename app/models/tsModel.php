<?php
require_once "app/models/conexion.php";

class TrabajoSocial extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    //------------------------ GENERALES
    public function Servicios()
    {
        $query = "SELECT * FROM servicio WHERE id_servicios = 5";
        $stmt = $this->conn->query($query);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarBeneficiarios()
    {
        $query = "SELECT beneficiario.id_beneficiario,
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
        FROM beneficiario
        JOIN pnf ON beneficiario.id_pnf = pnf.id_pnf
        WHERE 
            beneficiario.estatus = 1
        ORDER BY beneficiario.id_beneficiario ASC";

        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //--------------------------------------------------------> BECAS

    public function crearBeca($id_beneficiario, $id_servicios, $direccion_pdf, $ctabcv, $tipo_banco)
    {
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

            $query2 = "INSERT INTO becas (id_solicitud_serv, cta_bcv, direccion_pdf, tipo_banco, fecha_creacion) VALUES (:id_solicitud_serv, :ctabcv, :direccion_pdf, :tipo_banco, curdate())";

            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':ctabcv', $ctabcv, PDO::PARAM_STR);
            $stmt2->bindParam(':direccion_pdf', $direccion_pdf, PDO::PARAM_STR);
            $stmt2->bindParam(':tipo_banco', $tipo_banco, PDO::PARAM_STR);
            $stmt2->execute();

            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Registro', 'Diagnostico de Becas registrado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error al crear la consulta trabajo social: " . $e->getMessage();
            return false;
        }
    }

    public function consultarBeca()
    {
        $query = "SELECT 
                bc.id_becas,
                CONCAT(b.nombres, ' ', b.apellidos) AS nombre_beneficiario,
                b.cedula,
                b.id_pnf,
                bc.cta_bcv,
                bc.direccion_pdf,
                bc.tipo_banco,
                bc.fecha_creacion,
                pnf.nombre_pnf,
                ss.id_solicitud_serv
            FROM 
                becas bc
            LEFT JOIN 
                solicitud_de_servicio ss ON bc.id_solicitud_serv = ss.id_solicitud_serv
            LEFT JOIN 
                beneficiario b ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN
                pnf ON b.id_pnf = pnf.id_pnf";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarImagenBeca($id)
    {
        $query = "SELECT direccion_imagen FROM becas WHERE id_becas = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarBeca($id, $ruta_archivo, $ctabcv, $tipo_banco)
    {
        try {
            $query1 = "UPDATE becas
                    SET direccion_pdf = :ruta_archivo, cta_bcv = :ctabcv, tipo_banco = :tipo_banco
                    WHERE id_becas = :id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->bindParam(':ruta_archivo', $ruta_archivo, PDO::PARAM_LOB);
            $stmt1->bindParam(':ctabcv', $ctabcv, PDO::PARAM_STR);
            $stmt1->bindParam(':tipo_banco', $tipo_banco, PDO::PARAM_STR);
            $stmt1->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Actualización', 'Diagnóstico de Becas actualizado con éxito.', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar el registro: " . $e->getMessage();
            return false;
        }
    }

    public function mostrarFormularioEditar($id_beca)
    {
        $query = "SELECT 
            bc.id_becas,
            bc.cta_bcv,
            bc.direccion_pdf,
            bc.tipo_banco,
            bc.fecha_creacion,

            -- Datos del beneficiario
            b.id_beneficiario,
            b.nombres,
            b.apellidos,
            b.cedula,

            -- Datos del servicio
            s.id_servicios,
            s.nombre_serv,

            -- Datos de la solicitud de servicio
            ss.id_solicitud_serv,

            -- Datos del empleado (ahora se obtiene de la tabla solicitud_de_servicio)
            CONCAT(e.nombre, ' ', e.apellido) as nombres_empleado,
            e.telefono,
            te.tipo

        FROM 
            becas bc
        LEFT JOIN 
            solicitud_de_servicio ss ON bc.id_solicitud_serv = ss.id_solicitud_serv
        LEFT JOIN 
            beneficiario b ON ss.id_beneficiario = b.id_beneficiario
        LEFT JOIN 
            servicio s ON ss.id_servicios = s.id_servicios
        LEFT JOIN
            empleado e ON ss.id_empleado = e.id_empleado  -- Ahora se obtiene de solicitud_de_servicio
        LEFT JOIN
            tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
        WHERE 
            bc.id_becas = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_beca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ELIMINAR
    public function eliminarBeca($id, $id_solicitud_serv)
    {
        try {
            $this->conn->beginTransaction();

            $query1 = "DELETE FROM becas WHERE id_becas = :id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->execute();

            $query2 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Eliminación', 'Diagnostico de becas eliminado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar la beca: " . $e->getMessage();
            return false;
        }
    }


    //---------------------------------------------> EXONERACIÓN

    public function crearEx($id_beneficiario, $id_servicios, $motivo, $direccion_carta, $direccion_estudiose = null, $otro_motivo, $carnetDiscapacidad)
    {
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

            $query2 = "INSERT INTO exoneracion (id_solicitud_serv, motivo, direccion_carta, direccion_estudiose, otro_motivo, carnet_discapacidad, fecha_creacion) VALUES (:id_solicitud_serv, :motivo, :direccion_carta, :direccion_estudiose, :otro_motivo, :carnet, curdate())";

            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            $stmt2->bindParam(':direccion_carta', $direccion_carta, PDO::PARAM_STR);
            $stmt2->bindParam(':direccion_estudiose', $direccion_estudiose, PDO::PARAM_STR);
            $stmt2->bindParam(':otro_motivo', $otro_motivo, PDO::PARAM_STR);
            $stmt2->bindParam(':carnet', $carnetDiscapacidad, PDO::PARAM_STR);
            $stmt2->execute();

            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Registro', 'Diagnostico de Exoneración registrado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        }catch (PDOException $e) {
            $this->conn->rollback();
            echo "Error al guardar el registro: " . $e->getMessage();
            return false;
        }
    }

    public function consultarEx()
    {
        $query = "SELECT
                ex.*,
                CONCAT(b.nombres, ' ', b.apellidos) AS nombre_beneficiario,
                b.cedula,
                b.id_pnf,
                pnf.nombre_pnf,
                ss.id_solicitud_serv

                FROM exoneracion ex

                LEFT JOIN 
                solicitud_de_servicio ss ON ex.id_solicitud_serv = ss.id_solicitud_serv

                LEFT JOIN 
                beneficiario b ON ss.id_beneficiario = b.id_beneficiario

                LEFT JOIN pnf ON b.id_pnf = pnf.id_pnf";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarEx($id, $motivo, $ruta_carta, $otro_motivo, $carnetDiscapacidad)
    {
        try {

            $query1 = "UPDATE exoneracion SET motivo = :motivo, direccion_carta = :ruta_carta, otro_motivo = :otro_motivo, carnet_discapacidad = :carnet WHERE id_exoneracion = :id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            $stmt1->bindParam(':ruta_carta', $ruta_carta, PDO::PARAM_STR);
            $stmt1->bindParam(':otro_motivo', $otro_motivo, PDO::PARAM_STR);
            $stmt1->bindParam(':carnet', $carnetDiscapacidad, PDO::PARAM_STR);
            $stmt1->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query2 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Actualización', 'Diagnostico de Exoneración actualizado con éxito.', NOW())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt2->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar el registro: " . $e->getMessage();
            return false;
        }
    }

    public function mostrarFormularioEditarEx($id_ex)
    {
        $query = "SELECT
         
            ex.*,

            -- Datos del beneficiario
            b.id_beneficiario,
            b.nombres,
            b.apellidos,
            b.cedula,

            -- Datos del servicio
            s.nombre_serv,

            CONCAT(e.nombre, ' ', e.apellido) as nombres_empleado,
            e.telefono,
            te.tipo
            
            FROM exoneracion ex

            LEFT JOIN 
            solicitud_de_servicio ss ON ex.id_solicitud_serv = ss.id_solicitud_serv
            LEFT JOIN 
            beneficiario b ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN 
            servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN
            empleado e ON ss.id_empleado = e.id_empleado
            LEFT JOIN
            tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
            
            WHERE id_exoneracion = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_ex, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ELIMINAR
    public function eliminarEx($id, $id_solicitud_serv)
    {
        try {
            $this->conn->beginTransaction();

            $query1 = "DELETE FROM exoneracion WHERE id_exoneracion = :id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->execute();

            $query2 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt2->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query3 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Eliminación', 'Diagnostico de Exoneración eliminado con éxito.', NOW())";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar la exoneración: " . $e->getMessage();
            return false;
        }
    }

    // --------------------------- FAMES -------------------------

    public function crearFames($id_beneficiario, $id_servicios, $patologia, $tipo_ayuda, $otro_tipo)
    {
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

            $query3 = "INSERT INTO detalle_patologia (id_patologia) VALUES (:id_patologia)";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_patologia', $patologia, PDO::PARAM_INT);
            $stmt3->execute();
            $id_patologia_generado = $this->conn->lastInsertId();

            $query2 = "INSERT INTO fames (id_solicitud_serv, id_detalle_patologia, tipo_ayuda, otro_tipo, fecha_creacion) VALUES (:id_solicitud_serv, :patologia, :tipo_ayuda, :otro_tipo, curdate())";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':patologia', $id_patologia_generado, PDO::PARAM_INT);
            $stmt2->bindParam(':tipo_ayuda', $tipo_ayuda, PDO::PARAM_STR);
            $stmt2->bindParam(':otro_tipo', $otro_tipo, PDO::PARAM_STR);
            $stmt2->execute();

            $query4 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Registro', 'Diagnostico de Fames registrado con éxito.', NOW())";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt4->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error al guardar registro: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerPatologiasFames()
    {
        $query = "SELECT * FROM patologia";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultarFames()
    {
        $query = "SELECT fames.* , pt.nombre_patologia, b.nombres, b.apellidos, b.cedula, dp.id_detalle_patologia
        FROM fames
        LEFT JOIN solicitud_de_servicio ss ON fames.id_solicitud_serv = ss.id_solicitud_serv
        LEFT JOIN detalle_patologia dp ON fames.id_detalle_patologia = dp.id_detalle_patologia
        LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
        LEFT JOIN patologia pt ON dp.id_patologia = pt.id_patologia";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarFames($id_solicitud_serv, $id_beneficiario, $id, $patologia, $tipo_ayuda, $otro_tipo, $id_detalle_patologia)
    {
        try {
            $this->conn->beginTransaction();

            $query1 = "UPDATE fames SET tipo_ayuda = :tipo_ayuda, otro_tipo = :otro_tipo WHERE id_fames = :id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->bindParam(':tipo_ayuda', $tipo_ayuda, PDO::PARAM_STR);
            $stmt1->bindParam(':otro_tipo', $otro_tipo, PDO::PARAM_STR);
            $stmt1->execute();

            $query2 = "UPDATE solicitud_de_servicio SET id_beneficiario = :id_beneficiario WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt2->bindParam(':id_beneficiario', $id_beneficiario, PDO::PARAM_INT);
            $stmt2->execute();

            $query3 = "UPDATE detalle_patologia SET id_patologia = :id_patologia WHERE id_detalle_patologia = :id_detalle_patologia";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_detalle_patologia', $id_detalle_patologia, PDO::PARAM_INT);
            $stmt3->bindParam('id_patologia', $patologia, PDO::PARAM_INT);
            $stmt3->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query4 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Actualización', 'Diagnostico de Fames actualizado con éxito.', NOW())";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt4->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar el registro: " . $e->getMessage();
            return false;
        }
    }

    public function mostrarFormularioEditarFames($id)
    {
        $query = "SELECT
         
            fm.*,

            -- Datos del beneficiario
            b.id_beneficiario,
            b.nombres,
            b.apellidos,
            b.cedula,

            -- Datos del servicio
            s.id_servicios,
            s.nombre_serv,

            -- Datos de detalle patologia y patologia
            dp.id_patologia,
            p.nombre_patologia,

            CONCAT(e.nombre, ' ', e.apellido) as nombres_empleado,
            e.telefono,
            te.tipo
            
            FROM fames fm

            LEFT JOIN solicitud_de_servicio ss ON fm.id_solicitud_serv = ss.id_solicitud_serv
            LEFT JOIN detalle_patologia dp ON fm.id_detalle_patologia = dp.id_detalle_patologia
            LEFT JOIN beneficiario b ON ss.id_beneficiario = b.id_beneficiario
            LEFT JOIN servicio s ON ss.id_servicios = s.id_servicios
            LEFT JOIN empleado e ON ss.id_empleado = e.id_empleado
            LEFT JOIN tipo_empleado te ON e.id_tipo_empleado = te.id_tipo_emp
            LEFT JOIN patologia p ON dp.id_patologia = p.id_patologia
            
            WHERE id_fames = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ELIMINAR
    public function eliminarFames($id, $id_solicitud_serv, $id_detalle_patologia)
    {
        try {
            $this->conn->beginTransaction();

            $query1 = "DELETE FROM fames WHERE id_fames = :id";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt1->execute();

            $query2 = "DELETE FROM solicitud_de_servicio WHERE id_solicitud_serv = :id_solicitud_serv";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id_solicitud_serv', $id_solicitud_serv, PDO::PARAM_INT);
            $stmt2->execute();

            $query3 = "DELETE FROM detalle_patologia WHERE id_detalle_patologia = :id_detalle_patologia";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id_detalle_patologia', $id_detalle_patologia, PDO::PARAM_INT);
            $stmt3->execute();

            $id_empleado = $_SESSION['id_empleado'];
            $query4 = "INSERT INTO bitacora (id_empleado, modulo, accion, descripcion, fecha) 
                        VALUES (:id_empleado, 'Trabajador Social', 'Eliminación', 'Diagnostico de Fames eliminado con éxito.', NOW())";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt4->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar el registro fames: " . $e->getMessage();
            return false;
        }
    }
}
