<?php
require_once 'app/models/InventarioMobiliarioModel.php';
require_once 'app/models/ConfigModel.php';
require_once 'app/models/EmpleadoModel.php';

function inventario_mobiliario_index() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para acceder a esta sección";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    $modelo = new InventarioMobiliarioModel();
    $configModel = new Configuracion();
    $empleadoModel = new EmpleadoModel();
    
    $servicios = $configModel->config_listar('servicio');
    $mobiliario = $modelo->obtenerMobiliarioPorServicio();
    $equipos = $modelo->obtenerEquiposPorServicio();
    $fichas = $modelo->obtenerFichasTecnicas();
    
    require_once 'app/views/inventario_mobiliario/index.php';
}

function inventario_mobiliario_registrar() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    $modelo = new InventarioMobiliarioModel();
    $configModel = new Configuracion();
    
    $servicios = $configModel->config_listar('servicio');
    $tiposMobiliario = $modelo->obtenerTiposMobiliario();
    $tiposEquipo = $modelo->obtenerTiposEquipo();
    
    require_once 'app/views/inventario_mobiliario/registrar.php';
}

function inventario_mobiliario_guardar() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $modelo = new InventarioMobiliarioModel();
        
        $tipo = $_POST['tipo'];
        $data = $_POST;
        
        if ($tipo == 'mobiliario') {
            $resultado = $modelo->registrarMobiliario($data);
            $mensaje_exito = "Mobiliario registrado con éxito";
            $mensaje_error = "Error al registrar mobiliario";
        } elseif ($tipo == 'equipo') {
            $resultado = $modelo->registrarEquipo($data);
            $mensaje_exito = "Equipo registrado con éxito";
            $mensaje_error = "Error al registrar equipo";
        }
        
        if ($resultado) {
            $_SESSION['mensaje'] = $mensaje_exito;
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = $mensaje_error;
            $_SESSION['tipo_mensaje'] = 'error';
        }
        
        header('Location: index.php?action=inventario_mobiliario_registrar');
        exit();
    }
}

function inventario_mobiliario_ficha() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    $modelo = new InventarioMobiliarioModel();
    $configModel = new Configuracion();
    $empleadoModel = new EmpleadoModel();
    
    $servicios = $configModel->config_listar('servicio');
    $empleados = $empleadoModel->empleados_listar();
    $mobiliario = $modelo->obtenerMobiliarioPorServicio();
    $equipos = $modelo->obtenerEquiposPorServicio();
    
    require_once 'app/views/inventario_mobiliario/ficha.php';
}

function inventario_mobiliario_guardar_ficha() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $modelo = new InventarioMobiliarioModel();
        
        $data = [
            'nombre_ficha' => $_POST['nombre_ficha'],
            'id_servicio' => $_POST['id_servicio'],
            'id_responsable' => $_POST['id_responsable'],
            'descripcion' => $_POST['descripcion'],
            'mobiliario' => json_decode($_POST['mobiliario'], true),
            'equipos' => json_decode($_POST['equipos'], true)
        ];
        
        $id_ficha = $modelo->crearFichaTecnica($data);
        
        if ($id_ficha) {
            $_SESSION['mensaje'] = "Ficha técnica creada con éxito";
            $_SESSION['tipo_mensaje'] = 'exito';
            header('Location: index.php?action=inventario_mobiliario_ver_ficha&id='.$id_ficha);
        } else {
            $_SESSION['mensaje'] = "Error al crear ficha técnica. Verifique la disponibilidad de los items.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inventario_mobiliario_ficha');
        }
        exit();
    }
}

function inventario_mobiliario_ver_ficha() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    if (!isset($_GET['id'])) {
        $_SESSION['mensaje'] = "Ficha no especificada";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inventario_mobiliario_index');
        exit();
    }

    $modelo = new InventarioMobiliarioModel();
    $ficha = $modelo->obtenerDetalleFicha($_GET['id']);
    
    if (!$ficha) {
        $_SESSION['mensaje'] = "Ficha no encontrada";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inventario_mobiliario_index');
        exit();
    }
    
    require_once 'app/views/inventario_mobiliario/ver_ficha.php';
}

function inventario_mobiliario_historial() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    $modelo = new InventarioMobiliarioModel();
    $historial = $modelo->obtenerHistorial();
    
    require_once 'app/views/inventario_mobiliario/historial.php';
}

function inventario_mobiliario_imprimir_ficha() {
    if ($_SESSION['tipo_empleado'] !== 'Administrador') {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }

    if (!isset($_GET['id'])) {
        $_SESSION['mensaje'] = "Ficha no especificada";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inventario_mobiliario_index');
        exit();
    }

    $modelo = new InventarioMobiliarioModel();
    $ficha = $modelo->obtenerDetalleFicha($_GET['id']);
    
    if (!$ficha) {
        $_SESSION['mensaje'] = "Ficha no encontrada";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inventario_mobiliario_index');
        exit();
    }
    
    require_once 'app/views/inventario_mobiliario/imprimir_ficha.php';
}
?>