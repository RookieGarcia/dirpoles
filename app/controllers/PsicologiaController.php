<?php require_once 'app/models/PsicologiaModel.php';

function diagnostico_psicologia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
        $modelo = new Psicologia();
        $beneficiarios = $modelo->Beneficiarios();
        $patologias = $modelo->Patologias();
        $servicios = $modelo->Servicios();
        $psicologos = $modelo->listar_Psicologos();
        if ($_SESSION['tipo_empleado'] === 'Administrador') {
            $horarios = $modelo->obtenerHorarios();
        } elseif ($_SESSION['tipo_empleado'] === 'Psicologo') {
            $id_empleado = $_SESSION['id_empleado'];
            $horarios = $modelo->obtenerHorarios($id_empleado);
        }
        require_once 'app/views/diagnostico_psicologia.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function psicologia_listar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Psicologia();

        // Pasar ambos parámetros
        $psicologias = $modelo->psicologia_listar(
            $_SESSION['id_empleado'],
            $_SESSION['tipo_empleado'] // 'Administrador' o 'Psicología'
        );
        require_once 'app/views/diagnostico_psicologia_listar.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function psicologia_crear() {
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Psicologia();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Recibir datos del formulario
            $id_beneficiario = isset($_POST['id_beneficiario']) ? $_POST['id_beneficiario'] : null;
            $id_patologia = isset($_POST['id_patologia']) ? $_POST['id_patologia'] : null;
            $diagnostico = isset($_POST['diagnostico']) ? $_POST['diagnostico'] : null;
            $tratamiento_gen = isset($_POST['tratamiento_gen']) ? $_POST['tratamiento_gen'] : null;
            $observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : null;
            $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : null;
            $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
            $hora = isset($_POST['hora']) ? $_POST['hora'] : null;
            $id_servicios = isset($_POST['id_servicios']) ? $_POST['id_servicios'] : null;
            $motivo_otro = isset($_POST['motivo_otro']) ? $_POST['motivo_otro'] : null;
            $id_empleado_cita = isset($_POST['id_empleado']) ? $_POST['id_empleado'] : null; // ID empleado enviado desde la cita

            // Determinar cuál ID de empleado usar
            $id_empleado = !empty($id_empleado_cita) ? $id_empleado_cita : $_SESSION['id_empleado'];

            // Validar fecha pasada
            if (!empty($fecha) && $fecha < date('Y-m-d')) {
                $_SESSION['mensaje'] = "No se pueden registrar citas en una fecha pasada.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=diagnostico_psicologia#diagnostico_general');
                exit();
            }

            // Validar disponibilidad del empleado
            if (!empty($fecha) && !empty($hora) && !empty($id_empleado_cita)) {
                if (!$modelo->validarHorario($id_empleado_cita, $fecha, $hora)) {
                    $_SESSION['mensaje'] = "El psicólogo no está disponible en este horario.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: index.php?action=diagnostico_psicologia#diagnostico_general');
                    exit();
                }

                $citaExistente = $modelo->citaExistente($id_empleado_cita, $fecha, $hora);
                if ($citaExistente['existe_misma_hora']) {
                    $_SESSION['mensaje'] = "Ya existe una cita registrada a esta hora exacta.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: index.php?action=diagnostico_psicologia#diagnostico_general');
                    exit();
                } elseif ($citaExistente['existe_intervalo']) {
                    $_SESSION['mensaje'] = "El psicólogo ya tiene una cita programada 30 minutos antes/después.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: index.php?action=diagnostico_psicologia#diagnostico_general');
                    exit();
                }
            }

            // Registrar el diagnóstico y la cita como una operación atómica
            $resultado = $modelo->psicologia_registrar($id_empleado, $fecha, $hora, $id_beneficiario, $id_servicios, $id_patologia, $diagnostico, $tratamiento_gen, $observaciones, $motivo_otro, $motivo);

            if ($resultado) {
                $_SESSION['mensaje'] = "La consulta psicológica y la cita (si se solicitó) se han registrado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al registrar la consulta psicológica.";
                $_SESSION['tipo_mensaje'] = 'error';
            }

            header('Location: index.php?action=diagnostico_psicologia#diagnostico_general');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción.";
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}



function psicologia_2()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {

        $modelo = new Psicologia();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id_beneficiario = $_POST['id_beneficiario'];
            $id_servicios = $_POST['id_servicios'];
            $observaciones = $_POST['observaciones'];
            $motivo_otro = $_POST['motivo_otro'];
            $motivo = $_POST['motivo'];

            $registro2 = $modelo->psicologia_2($id_beneficiario, $id_servicios, $observaciones, $motivo_otro, $motivo);

            if ($registro2) {
                $_SESSION['mensaje'] = "La consulta se ha registrado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
                $_SESSION['form_open'] = true;
            } else {
                $_SESSION['mensaje'] = "Error al registrar la consulta.";
                $_SESSION['tipo_mensaje'] = 'error';
                $_SESSION['form_open'] = true;
            }
        }
        header('Location: index.php?action=diagnostico_psicologia#diagnostico_general');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function psicologia_constancia()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
        $modelo = new Psicologia();
        $id_psicologia = isset($_GET['id_psicologia']) ? $_GET['id_psicologia'] : null;
        $datos = $modelo->psicologia_ID($id_psicologia);
        require_once 'pdf/constancia/procesar.php';

    }
}

function psicologia_editar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
        $modelo = new Psicologia();
        $id_psicologia = isset($_GET['id_psicologia']) ? $_GET['id_psicologia'] : null;
        $datos = $modelo->psicologia_ID($id_psicologia);
        $servicios = $modelo->Servicios();
        $patologias = $modelo->Patologias();
        require_once 'app/views/diagnostico_psicologia_editar.php';

    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

    function psicologia_actualizar(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
            $modelo = new Psicologia();
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $id_psicologia = $_POST['id_psicologia'];
                $diagnostico = $_POST['diagnostico'];
                $tratamiento_gen = $_POST['tratamiento_gen'];
                $observaciones = $_POST['observaciones'];
    
                $registro = $modelo->psicologia_actualizar($id_psicologia, $diagnostico, $tratamiento_gen, $observaciones);
    
                if($registro){
                    $_SESSION['mensaje'] = "La información se ha actualizado con éxito.";
                    $_SESSION['tipo_mensaje'] = 'exito';
                }else{
                    $_SESSION['mensaje'] = "Error al actualizar la información.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
            header('Location: index.php?action=psicologia_listar');
            exit();
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('location:index.php?action=login');
            exit();
        }
    }

    function psicologia_actualizar_2(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
            $modelo = new Psicologia();
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $id_psicologia = $_POST['id_psicologia'];
                $motivo_otro = $_POST['motivo_otro'];
                $observaciones = $_POST['observaciones'];
    
                $registro = $modelo->psicologia_actualizar_2($id_psicologia, $motivo_otro, $observaciones);
    
                if($registro){
                    $_SESSION['mensaje'] = "La información se ha actualizado con éxito.";
                    $_SESSION['tipo_mensaje'] = 'exito';
                }else{
                    $_SESSION['mensaje'] = "Error al actualizar la información.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
            header('Location: index.php?action=psicologia_listar');
            exit();
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('location:index.php?action=login');
            exit();
        }
        
    }

    function psicologia_visualizar(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
            $modelo = new Psicologia();
            $id_psicologia = isset($_GET['id_psicologia']) ? $_GET['id_psicologia'] : null;
            $datos = $modelo->psicologia_ID($id_psicologia);
            $servicios = $modelo->Servicios();
            $patologias = $modelo->Patologias();
            require_once 'app/views/diagnostico_discapacidad_ver.php';
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('location:index.php?action=login');
            exit();
        }
    }

    function psicologia_referencia(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
            $modelo = new Psicologia();
            $id_psicologia = isset($_GET['id_psicologia']) ? $_GET['id_psicologia'] : null;
            $psicologia = $modelo->psicologia_ID($id_psicologia);
            require_once 'PDF/referencia/procesar.php';
        }
    }

    function psicologia_eliminar(){
        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Psicologo') {
            $modelo = new Psicologia();
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $id_psicologia = $_GET['id_psicologia'];
                $id_solicitud_serv = $_GET['id_solicitud_serv'];

                $datos = $modelo->psicologia_eliminar($id_psicologia, $id_solicitud_serv);
                if($datos){
                    $_SESSION['mensaje'] = "La información se ha eliminado con éxito.";
                    $_SESSION['tipo_mensaje'] = 'exito';
                }else{
                    $_SESSION['mensaje'] = "Error al eliminar la información.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
            header('Location: index.php?action=psicologia_listar');
            exit();
        }else{
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
            $_SESSION['tipo_mensaje'] = 'error';
            header('location:index.php?action=login');
            exit();
        }
    }
