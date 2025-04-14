<?php require 'app/models/InventarioModel.php';

function inventario_crear(){

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
        $modelo = new InventarioModel();

        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
            $presentaciones = $modelo->Presentaciones();
            require_once 'app/views/inventario_crear.php';
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

function inventario_consulta(){

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new InventarioModel();

        if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
            $insumos = $modelo->consultar_insumos();
            require_once 'app/views/inventario_consulta.php';
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

function inventario_movimientos()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new InventarioModel();

        $movimientos = $modelo->inventario_movimientos();
        require_once 'app/views/inventario_movimientos.php';
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function registrar_inventario() {
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
        $modelo = new InventarioModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_presentacion = $_POST['id_presentacion'];
            $nombre_insumo = $_POST['nombre_insumo'];
            $descripcion = $_POST['descripcion'];
            $tipo_insumo = $_POST['tipo_insumo'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $cantidad = $_POST['cantidad'];

            $resultado = $modelo->inventario_registrar($id_presentacion, $nombre_insumo, $descripcion, $tipo_insumo, $fecha_vencimiento, $cantidad);

            if ($resultado) {
                $_SESSION['mensaje'] = "Insumo registrado y agregado al inventario con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al registrar el insumo. Puede que ya exista un insumo con las mismas características.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=inventario_crear');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}


function actualizar_inventario()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new InventarioModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_insumo = $_POST['id_insumo'];
            $id_presentacion = $_POST['id_presentacion'];
            $nombre_insumo = $_POST['nombre_insumo'];
            $descripcion = $_POST['descripcion'];
            $tipo_insumo = $_POST['tipo_insumo'];
            $fecha_vencimiento = $_POST['fecha_vencimiento'];
            $estatus = $_POST['estatus'];
            $es_desbloqueo = isset($_POST['desbloquear']);
            $resultado = $modelo->inventario_actualizar($id_insumo, $id_presentacion, $nombre_insumo, $descripcion, $tipo_insumo, $fecha_vencimiento, $estatus, $es_desbloqueo);

            if($es_desbloqueo) {
                $_SESSION['mensaje'] = "Insumo desbloqueado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            }

            if ($resultado) {
                $_SESSION['mensaje'] = "Insumo actualizado en el inventario con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el insumo en el inventario.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        header('Location: index.php?action=inventario_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function inventario_editar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new InventarioModel();

        if (isset($_GET['id_insumo'])) {
            $id_insumo = $_GET['id_insumo'];

            $detalles = $modelo->consultar_insumo_por_id($id_insumo);

            if ($detalles) {
                $presentaciones = $modelo->Presentaciones();
                include 'app/views/inventario_editar.php';
            } else {
                $_SESSION['mensaje'] = "Error al obtener los detalles del inventario.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=inventario_consulta');
                exit();
            }
        } else {
            $_SESSION['mensaje'] = "ID de inventario o insumo no proporcionado.";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inventario_consulta');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function inventario_eliminar() {
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {

        $modelo = new InventarioModel();

        if (isset($_GET['id_insumo'])) {
            $id_insumo = $_GET['id_insumo'];

            // Validar que el insumo no tenga stock
            if ($modelo->validar_stock($id_insumo)) {
                $_SESSION['mensaje'] = "El insumo tiene stock disponible y no se puede eliminar.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=inventario_consulta');
                exit();
            }

            // Validar que el insumo no haya sido utilizado en consultas (o en detalle_insumo)
            if ($modelo->validar_insumo_medicina($id_insumo)) {
                $_SESSION['mensaje'] = "El insumo ya ha sido utilizado en una consulta y no se puede eliminar.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?action=inventario_consulta');
                exit();
            }

            // Si pasa las validaciones, intentar eliminar
            $resultado = $modelo->inventario_eliminar($id_insumo);

            if ($resultado) {
                $_SESSION['mensaje'] = "Insumo eliminado con éxito.";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el insumo.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        } else {
            $_SESSION['mensaje'] = "Parámetros inválidos para la eliminación del insumo.";
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?action=inventario_consulta');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=login');
        exit();
    }
}



function inventario_entrada(){
    $modelo = new InventarioModel();
    if ($_SESSION['tipo_empleado'] === 'Administrador' || $_SESSION['tipo_empleado'] === 'Medico') {
        $inventario = $modelo->consultar_insumos_entrada();
        require_once 'app/views/inventario_entrada.php';
    }else {
        $_SESSION['mensaje'] = "No tienes permisos de Administrador para realizar esta acción.";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=inicio');
        exit();
    }
}

function registrar_entrada() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $modelo = new InventarioModel();
        
        $id_insumo = $_POST['id_insumo'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];

        // Validaciones básicas
        if (empty($id_insumo) || empty($cantidad) || empty($descripcion)) {
            $_SESSION['mensaje'] = "Todos los campos son obligatorios";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inventario_entrada');
            exit();
        }

        if ($cantidad <= 0) {
            $_SESSION['mensaje'] = "La cantidad debe ser mayor que 0";
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?action=inventario_entrada');
            exit();
        }


        if ($modelo->registrarEntrada($id_insumo, $cantidad, $descripcion)) {
            $_SESSION['mensaje'] = "Entrada registrada exitosamente";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "Error al registrar la entrada" ;
            $_SESSION['tipo_mensaje'] = 'error';
        }
        
        header('Location: index.php?action=inventario_entrada');
        exit();
    }
}