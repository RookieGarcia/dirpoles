<?php include_once 'app/models/DiscapacidadModel.php';


    function diagnostico_discapacidad(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            $beneficiarios = $modelo->Beneficiarios();
            $servicios = $modelo->Servicios();
            require_once 'app/views/diagnostico_discapacidad.php';
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=login');
            exit();
        }
        
    }

    function discapacidad_crear(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_beneficiario = $_POST['id_beneficiario'];
                $id_servicios = $_POST['id_servicios'];
                $condicion_medica = $_POST['condicion_medica'];
                $cirugia_prev = $_POST['cirugia_prev'];
                $toma_medicamentos_reg = $_POST['toma_medicamentos_reg'];
                $naturaleza_discapacidad = $_POST['naturaleza_discapacidad'];
                $impacto_disc = $_POST['impacto_disc'];
                $habilidades_funcionales_b = $_POST['habilidades_funcionales_b'];
                $requiere_asistencia = $_POST['requiere_asistencia'];
                $dispositivo_asistencia = $_POST['dispositivos_asistencia'];
                $salud_mental = $_POST['salud_mental'];
                $apoyo_psicologico = $_POST['apoyo_psicologico'];
                $carnet_discapacidad = $_POST['carnet_discapacidad'];

                $datos = $modelo->discapacidad_registrar($id_beneficiario, $id_servicios, $condicion_medica, $cirugia_prev, $toma_medicamentos_reg, $naturaleza_discapacidad, $impacto_disc, $habilidades_funcionales_b, $requiere_asistencia, $dispositivo_asistencia, $salud_mental, $apoyo_psicologico, $carnet_discapacidad);

                if($datos){
                    $_SESSION['mensaje'] = "Consulta de discapacidad registrada exitosamente";
                    $_SESSION['tipo_mensaje'] = 'exito';
                }else{
                    $_SESSION['mensaje'] = "Error al registrar la consulta de discapacidad";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
                header ('Location: index.php?action=diagnostico_discapacidad');
                exit();
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=login');
            exit();
        }
    }

    function listar_discapacidad(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            $discapacidad = $modelo->discapacidad_listar($_SESSION['id_empleado'], $_SESSION['tipo_empleado']);
            require_once 'app/views/diagnostico_discapacidad_listar.php';
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=login');
            exit();
        }
        
    }

    function discapacidad_constancia(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            if(isset($_GET['id_discapacidad'])){
                $id_discapacidad = $_GET['id_discapacidad'];
                $discapacidad = $modelo->discapacidadID($id_discapacidad);
                require_once 'PDF/constancia/procesar.php';
            }
        
        }
    }

    function discapacidad_referencia(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            if(isset($_GET['id_discapacidad'])){
                $id_discapacidad = $_GET['id_discapacidad'];
                $discapacidad = $modelo->discapacidadID($id_discapacidad);
                require_once 'PDF/referencia/procesar.php';
            }
        
        }
    }

    function discapacidad_editar(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            if(isset($_GET['id_discapacidad'])){
                $id_discapacidad = $_GET['id_discapacidad'];
                $discapacidad = $modelo->discapacidadID($id_discapacidad);
                require_once 'app/views/diagnostico_discapacidad_editar.php';
            }
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=login');
            exit();
        }
    }

    function discapacidad_actualizar(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_discapacidad = $_POST['id_discapacidad'];
                $condicion_medica = $_POST['condicion_medica'];
                $cirugia_prev = $_POST['cirugia_prev'];
                $toma_medicamentos_reg = $_POST['toma_medicamentos_reg'];
                $naturaleza_discapacidad = $_POST['naturaleza_discapacidad'];
                $impacto_disc = $_POST['impacto_disc'];
                $habilidades_funcionales_b = $_POST['habilidades_funcionales_b'];
                $requiere_asistencia = $_POST['requiere_asistencia'];
                $dispositivo_asistencia = $_POST['dispositivos_asistencia'];
                $salud_mental = $_POST['salud_mental'];
                $apoyo_psicologico = $_POST['apoyo_psicologico'];
                $carnet_discapacidad = $_POST['carnet_discapacidad'];
    
                $datos = $modelo->discapacidad_actualizar($id_discapacidad, $condicion_medica, $cirugia_prev, $toma_medicamentos_reg, $naturaleza_discapacidad, $impacto_disc, $habilidades_funcionales_b, $requiere_asistencia, $dispositivo_asistencia, $salud_mental, $apoyo_psicologico, $carnet_discapacidad);
    
                if($datos){
                    $_SESSION['mensaje'] = "Consulta de discapacidad actualizada exitosamente";
                    $_SESSION['tipo_mensaje'] = 'exito';
                }else{
                    $_SESSION['mensaje'] = "Error al actualizar la consulta de discapacidad";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
            header('Location: index.php?action=discapacidad_listar');
            exit();
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=login');
            exit();
        }
    }

    function discapacidad_eliminar(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Discapacidad') {
            $modelo = new Discapacidad();
            if(isset($_GET['id_discapacidad']) && $_GET['id_solicitud_serv']){
                $id_discapacidad = $_GET['id_discapacidad'];
                $id_solicitud_serv = $_GET['id_solicitud_serv'];
    
                $datos = $modelo->discapacidad_eliminar($id_discapacidad, $id_solicitud_serv);
    
                if($datos){
                    $_SESSION['mensaje'] = "Consulta de discapacidad eliminada exitosamente";
                    $_SESSION['tipo_mensaje'] = 'exito';
                }else{
                    $_SESSION['mensaje'] = "Error al eliminar la consulta de discapacidad";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
            header('Location: index.php?action=discapacidad_listar');
            exit();
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=login');
            exit();
        }
    }
