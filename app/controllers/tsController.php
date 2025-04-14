<?php
require_once 'app/models/tsModel.php';

function mostrarVistaTs()
{
    $modelo = new TrabajoSocial();

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {
        $servicios = $modelo->Servicios();
        $beneficiarios = $modelo->listarBeneficiarios();

        $funcion = $modelo->obtenerPatologiasFames();
        require_once('app/views/diagnostico_trabajo_social.php');
    } else {
        $_SESSION['mensaje'] = "No tienes permisos de Administrador para realizar esta acción.";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }
}

function mostrarConsultaTs()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {
        if (isset($_GET['seleccion'])) {
            if ($_GET['seleccion'] == "becas") {
                require_once('app/views/diagnostico_trabajo_social_consultag.php');
            } else if ($_GET['seleccion'] == "exoneracion") {
                require_once('app/views/diagnostico_trabajo_social_consultag.php');
            } else {
                require_once('app/views/diagnostico_trabajo_social_consultag.php');
            }
        } else {
            require_once('app/views/diagnostico_trabajo_social_consultag.php');
        }
    } else {
        header('location:index.php?action=login');
        exit();
    }
}


//<-------BECAS --------->

function crearB()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();
        if (isset($_FILES['planilla']) && $_FILES['planilla']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/trabajo social/becas/planillas de inscripcion/";
            $file_name = basename($_FILES['planilla']['name']);
            $target_file = $target_dir . uniqid() . "_" . $file_name;

            if (move_uploaded_file($_FILES['planilla']['tmp_name'], $target_file)) {
                $ctabcv = $_POST['ctabcv'];
                $tipo_banco = $_POST['tipo_banco'];
                $id_beneficiario = $_POST['id_beneficiario_becas'];
                $id_servicios = $_POST['id_servicios_beca'];

                $resultado = $modelo->crearBeca($id_beneficiario, $id_servicios, $target_file, $ctabcv, $tipo_banco);
                if ($resultado) {
                    $mensaje = "Registro exitoso";
                    $tipoMensaje = 'exito';
                } else {
                    $mensaje = "Error al guardar los datos.";
                    $tipoMensaje = 'error';
                }
            } else {
                $mensaje = "Error al subir el archivo.";
                $tipoMensaje = 'error';
            }
        } else {
            $mensaje = "No se ha cargado ningún archivo.";
            $tipoMensaje = 'error';
        }


        $_SESSION['mensaje'] = $mensaje;
        $_SESSION['tipo_mensaje'] = $tipoMensaje;

        header('location: index.php?action=vista_trabajo_social' . '&formulario=' . $_POST['formulario']);
        exit();
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function consultarBeca()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();
        $funcion = $modelo->consultarBeca();
        require_once('app/views/diagnostico_trabajo_social_consultar_beca.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function mostrarImagenBeca()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_GET['id'];
        $modelo->mostrarImagenBeca($id);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function editarBeca()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_POST['id'];
        if (isset($_FILES['planilla']['tmp_name']) && $_FILES['planilla']['error'] == 0) {
            $planilla = $_FILES['planilla'];
        }
        $imagen_actual = $_POST['imagen_actual'];
        $ctabcv = $_POST['ctabcv'];
        $tipo_banco = $_POST['tipo_banco'];

        $ruta_archivo = $imagen_actual;

        if ($planilla) {
            $ruta_nueva = 'uploads/trabajo social/becas/planillas de inscripcion/' . uniqid() . '.' . pathinfo($planilla['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($planilla['tmp_name'], $ruta_nueva)) {
                if (file_exists($imagen_actual)) {
                    unlink($imagen_actual);
                }
                $ruta_archivo = $ruta_nueva;
            }
        }

        if ($modelo->editarBeca($id, $ruta_archivo, $ctabcv, $tipo_banco)) {
            $_SESSION['mensaje'] = "Edición exitosa";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "FALLO";
            $_SESSION['tipo_mensaje'] = 'error';
        }
        header('Location: index.php?action=consulta_trabajo_social&seleccion=becas');
        exit();
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function beca_constancia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id_beca = $_GET['id'];
        $bd = $modelo->mostrarFormularioEditar($id_beca);
        require_once 'pdf/constancia/procesar.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function beca_referencia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id_beca = $_GET['id'];
        $bd = $modelo->mostrarFormularioEditar($id_beca);
        require_once 'pdf/referencia/procesar.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}


function mostrarFormularioEditar()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_GET['id'];
        $bd = $modelo->mostrarFormularioEditar($id);
        require_once('app/views/diagnostico_trabajo_social_editar_beca.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function eliminarBeca()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_POST['id'];
        $imagen_actual = $_POST['direccion_imagen'];
        $id_solicitud_serv = $_POST['id_solicitud_serv'];

        $resultado = $modelo->eliminarBeca($id, $id_solicitud_serv);

        if (file_exists($imagen_actual)) {
            unlink($imagen_actual);
        }

        if ($resultado) {
            $mensaje = "Eliminación exitosa";
            $tipoMensaje = 'exito';
        } else {
            $mensaje = "Error al eliminar";
            $tipoMensaje = 'error';
        }
        $respuesta = [
            'success' => $resultado,
            'message' => $mensaje,
            'type' => $tipoMensaje
        ];

        echo json_encode($respuesta);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

//---------------------------------------EXONERACIÓN -----------------------------

function crearEx()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $motivo = $_POST['motivo_ex'];
        $otro_motivo = $_POST['discapacitado'];
        $id_beneficiario = $_POST['id_beneficiario_ex'];
        $id_servicios = $_POST['id_servicios_ex'];
        $carnetDiscapacidad = $_POST['carnet_discapacidad'];

        if (preg_match('/^D-\s+(.+)$/', $carnetDiscapacidad, $matches)) {
            $carnetDiscapacidad = 'D- ' . trim($matches[1]);
        } else {
            $carnetDiscapacidad = "N/A";
        }

        if (isset($_FILES['carta']) && $_FILES['carta']['error'] === UPLOAD_ERR_OK) {

            $carpetaDestino = 'uploads/trabajo social/exoneracion/cartas/';
            $extensionImagen = pathinfo($_FILES['carta']['name'], PATHINFO_EXTENSION);
            $nombreImagen = uniqid() . '.' . $extensionImagen;
            $direccion_carta = $carpetaDestino . $nombreImagen;

            $direccion_estudiose = null;
            if ($otro_motivo === 'no') {

                require_once 'PDF/EstudioSE/procesar.php';
                $direccion_estudiose = 'uploads/trabajo social/exoneracion/estudiose/' . uniqid() . '_estudioSE.pdf';

                GenerarPDF::crearPDF($direccion_estudiose);

                move_uploaded_file($_FILES['carta']['tmp_name'], $direccion_carta);

                $modelo->crearEx($id_beneficiario, $id_servicios, $motivo, $direccion_carta, $direccion_estudiose, $otro_motivo, $carnetDiscapacidad);
                $_SESSION['mensaje'] = "Resgistro exitoso CON Estudio Socio-Economico.";
                $_SESSION['tipo_mensaje'] = 'exito';
                header('location: index.php?action=vista_trabajo_social' . '&formulario=' . $_POST['formulario']);
                exit();
            }

            if ($otro_motivo === 'si') {

                $rutaPDF = null;

                move_uploaded_file($_FILES['carta']['tmp_name'], $direccion_carta);

                $modelo->crearEx($id_beneficiario, $id_servicios, $motivo, $direccion_carta, $direccion_estudiose, $otro_motivo, $carnetDiscapacidad);
                $_SESSION['mensaje'] = "Resgistro exitoso SIN Estudio Socio-Economico.";
                $_SESSION['tipo_mensaje'] = 'exito';

                header('location: index.php?action=vista_trabajo_social' . '&formulario=' . $_POST['formulario']);
                exit();
            }
        }
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function consultarEx()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $funcion = $modelo->consultarEx();
        require_once('app/views/diagnostico_trabajo_social_consultar_exoneracion.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function editarEx()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_POST['id'];
        $motivo = $_POST['motivo_ex'];
        $carta = $_FILES['carta'];
        $direccion_carta_actual = $_POST['direccion_carta'];
        $otro_motivo = $_POST['otro_motivo'];

        $carnetDiscapacidad = $_POST['carnet_discapacidad'];

        if (preg_match('/^D-\s+(.+)$/', $carnetDiscapacidad, $matches)) {
            $carnetDiscapacidad = 'D- ' . trim($matches[1]);
        } else {
            $carnetDiscapacidad = "N/A";
        }

        $ruta_carta = $direccion_carta_actual;

        if ($carta) {
            $ruta_nueva_img = 'uploads/trabajo social/exoneracion/cartas/' . uniqid() . '.' . pathinfo($carta['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($carta['tmp_name'], $ruta_nueva_img)) {

                if (file_exists($direccion_carta_actual)) {
                    unlink($direccion_carta_actual);
                }
                $ruta_carta = $ruta_nueva_img;
            }
        }

        $modelo->editarEx($id, $motivo, $ruta_carta, $otro_motivo, $carnetDiscapacidad);

        $_SESSION['mensaje'] = "Edición exitosa";
        $_SESSION['tipo_mensaje'] = 'exito';

        header('Location: index.php?action=consulta_trabajo_social&seleccion=exoneracion');
        exit();
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function eliminarEx()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_POST['id'];
        $imagen_actual = $_POST['direccion_imagen'];
        $pdf_actual = $_POST['direccion_pdf'];
        $id_solicitud_serv = $_POST['id_solicitud_serv'];

        $resultado = $modelo->eliminarEx($id, $id_solicitud_serv);

        // ELIMINA LA IMAGEN SI EXISTE
        if (file_exists($imagen_actual)) {
            unlink($imagen_actual);
        }

        // ELIMINA EL PDF SI EXISTE
        if (file_exists($pdf_actual)) {
            unlink($pdf_actual);
        }

        if ($resultado) {
            $mensaje = "Eliminación exitosa";
            $tipoMensaje = 'exito';
        } else {
            $mensaje = "Error al eliminar";
            $tipoMensaje = 'error';
        }
        $respuesta = [
            'success' => $resultado,
            'message' => $mensaje,
            'type' => $tipoMensaje
        ];

        echo json_encode($respuesta);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function ex_constancia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id_ex = $_GET['id'];

        $bd = $modelo->mostrarFormularioEditarEx($id_ex);
        require_once 'pdf/constancia/procesar.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function ex_referencia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id_ex = $_GET['id'];

        $bd = $modelo->mostrarFormularioEditarEx($id_ex);
        require_once 'pdf/referencia/procesar.php';
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function mostrarFormularioEditarEx()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_GET['id'];

        $bd = $modelo->mostrarFormularioEditarEx($id);
        require_once('app/views/diagnostico_trabajo_social_editar_ex.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

//---------------------------------------------- FAMES ---------------------------

function crearFames()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $patologia = $_POST['patologia'];
        $tipo_ayuda = $_POST['tipo_ayuda'];
        $otro_tipo = $_POST['otro_tipo'];
        $id_beneficiario = $_POST['id_beneficiario_fames'];
        $id_servicios = $_POST['id_servicios_fames'];

        if (!$otro_tipo) {
            $otro_tipo = 'N/A';
        }

        $resultado = $modelo->crearFames($id_beneficiario, $id_servicios, $patologia, $tipo_ayuda, $otro_tipo);

        if ($resultado) {
            $_SESSION['mensaje'] = "Registro exitoso.";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "Error en el registro.";
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('location: index.php?action=vista_trabajo_social' . '&formulario=' . $_POST['formulario']);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function obtenerPatologiasFames()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $funcion = $modelo->obtenerPatologiasFames();
        require_once('app/views/diagnostico_trabajo_social.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function consultarFames()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $funcion = $modelo->consultarFames();
        require_once('app/views/diagnostico_trabajo_social_consultar_fames.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function fames_constancia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_GET['id'];
        $bd = $modelo->mostrarFormularioEditarFames($id);
        require_once 'pdf/constancia/procesar.php';
    }
}

function fames_referencia()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_GET['id'];
        $bd = $modelo->mostrarFormularioEditarFames($id);
        require_once 'pdf/referencia/procesar.php';
    }
}

function editarFames()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_POST['id'];
        $patologia = $_POST['patologia'];
        $tipo_ayuda = $_POST['tipo_ayuda'];
        $otro_tipo = $_POST['otro_tipo'];
        $id_solicitud_serv = $_POST['id_solicitud_serv'];
        $id_beneficiario_actual = $_POST['id_beneficiario_actual'];
        $id_beneficiario_nuevo = $_POST['id_beneficiario_nuevo'];
        $id_detalle_patologia = $_POST['id_detalle_patologia'];

        if ($id_beneficiario_nuevo) {
            $id_beneficiario_resultado = $id_beneficiario_nuevo;
        } else {
            $id_beneficiario_resultado = $id_beneficiario_actual;
        }

        if ($tipo_ayuda === "economica" || $tipo_ayuda === "operaciones" || $tipo_ayuda === "examenes") {
            $otro_tipo = "N/A";
        }

        $resultado = $modelo->editarFames($id_solicitud_serv, $id_beneficiario_resultado, $id, $patologia, $tipo_ayuda, $otro_tipo, $id_detalle_patologia);

        if ($resultado) {
            $_SESSION['mensaje'] = "Edición exitosa";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "Error en la edición";
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?action=consulta_trabajo_social&seleccion=fames');
        exit();
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function eliminarFames()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_POST['id'];
        $id_solicitud_serv = $_POST['id_solicitud_serv'];
        $id_detalle_patologia = $_POST['id_detalle_patologia'];
        $resultado = $modelo->eliminarFames($id, $id_solicitud_serv, $id_detalle_patologia);

        if ($resultado) {
            $mensaje = "Eliminación exitosa";
            $tipoMensaje = 'exito';
        } else {
            $mensaje = "Error al eliminar";
            $tipoMensaje = 'error';
        }
        $respuesta = [
            'success' => $resultado,
            'message' => $mensaje,
            'type' => $tipoMensaje
        ];

        echo json_encode($respuesta);
    } else {
        header('location:index.php?action=login');
        exit();
    }
}

function mostrarFormularioEditarFames()
{
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Trabajador Social') {

        $modelo = new TrabajoSocial();

        $id = $_GET['id'];
        $funcion = $modelo->obtenerPatologiasFames();
        $bd = $modelo->mostrarFormularioEditarFames($id);
        require_once('app/views/diagnostico_trabajo_social_editar_fames.php');
    } else {
        header('location:index.php?action=login');
        exit();
    }
}
