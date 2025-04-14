<?php require_once 'app/models/MedicinaModel.php';

function medicina_crear()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
            $servicios = $modelo->Servicios();
            $inventario = $modelo->inventario();
            $patologias = $modelo->Patologias();
            $beneficiarios = $modelo->Beneficiarios();
            require_once "app/views/diagnostico_medicina.php";
        } else {
            $_SESSION['mensaje'] = "No tienes permisos de Administrador para realizar esta acción.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inicio');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function medicina_consulta()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();
        $medicina = $modelo->consultasMedicas($_SESSION['id_empleado'], $_SESSION['tipo_empleado']);
        require_once "app/views/diagnostico_medicina_consulta.php";
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function consulta_registrar_medicina()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_servicios = $_POST['id_servicios'];
            $id_beneficiario = $_POST['id_beneficiario'];
            $id_patologia = $_POST['id_patologia'];
            $insumos = json_decode($_POST['insumos'], true); // Decodificar el arreglo de insumos
            $estatura = $_POST['estatura'];
            $peso = $_POST['peso'];
            $tipo_sangre = $_POST['tipo_sangre'];
            $motivo_visita = $_POST['motivo_visita'];
            $diagnostico = $_POST['diagnostico'];
            $tratamiento = $_POST['tratamiento'];
            $observaciones = $_POST['observaciones'];

            try {
                $registro = $modelo->medicina_crear(
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
                );

                if ($registro) {
                    $_SESSION['mensaje'] = "Consulta médica registrada con éxito.";
                    $_SESSION['tipo_mensaje'] = 'exito';
                } else {
                    $_SESSION['mensaje'] = "Error al registrar la consulta médica.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            } catch (Exception $e) {
                $_SESSION['mensaje'] = "Error: " . $e->getMessage();
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=diagnostico_medicina');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function medicina_constancia()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        $id_consulta_med = $_GET['id_consulta_med'];
        $datos = $modelo->medicina_id($id_consulta_med);
        $patologias = $modelo->Patologias();
        require_once 'PDF/constancia/procesar.php';
    }
}

function medicina_recipe(){
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        $id_consulta_med = $_GET['id_consulta_med'];
        $consulta = $modelo->medicina_id($id_consulta_med);
        require_once 'PDF/MEDICINA/procesar.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function medicina_referencia(){
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
        $modelo = new Medicina();

        $id_consulta_med = $_GET['id_consulta_med'];
        $medicina = $modelo->medicina_id($id_consulta_med);
        require_once 'PDF/referencia/procesar.php';
    }
}

function medicina_editar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        $id_consulta_med = $_GET['id_consulta_med'];
        $id_detalle_patologia = $_GET['id_detalle_patologia'];
        $datos = $modelo->medicina_id($id_consulta_med);
        $patologias = $modelo->Patologias();
        require_once 'app/views/diagnostico_medicina_editar.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function medicina_eliminar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        $id_detalle_patologia = $_GET['id_detalle_patologia'];
        $id_consulta_med = $_GET['id_consulta_med'];
        $id_solicitud_serv = $_GET['id_solicitud_serv'];
        $id_detalle_insumo = $_GET['id_detalle_insumo'];

        $eliminar = $modelo->medicina_eliminar($id_detalle_patologia, $id_consulta_med, $id_solicitud_serv, $id_detalle_insumo);
        if ($eliminar) {
            $_SESSION['mensaje'] = "Consulta médica eliminada con éxito.";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "Error al eliminar la consulta médica.";
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?action=medicina_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function medicina_visualizar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();

        $id_consulta_med = $_GET['id_consulta_med'];
        $datos = $modelo->medicina_id($id_consulta_med);
        $patologias = $modelo->Patologias();
        require_once 'app/views/diagnostico_medicina_ver.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function medicina_actualizar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new Medicina();
        $id_detalle_patologia = $_POST['id_detalle_patologia'];
        $id_consulta_med = $_POST['id_consulta_med'];
        $id_patologia = $_POST['id_patologia'];
        $estatura = $_POST['estatura'];
        $peso = $_POST['peso'];
        $tipo_sangre = $_POST['tipo_sangre'];
        $motivo_visita = $_POST['motivo_visita'];
        $diagnostico = $_POST['diagnostico'];
        $tratamiento = $_POST['tratamiento'];
        $observaciones = $_POST['observaciones'];

        $actualizacion = $modelo->medicina_actualizar($id_detalle_patologia, $id_patologia, $estatura, $peso, $tipo_sangre, $motivo_visita, $diagnostico, $tratamiento, $observaciones, $id_consulta_med);
        if ($actualizacion) {
            $_SESSION['mensaje'] = "Consulta médica actualizada con éxito.";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "Error al actualizar la consulta médica.";
            $_SESSION['tipo_mensaje'] = 'error';
        }
        header ('Location: index.php?action=medicina_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}
