<?php

include "app/models/ConfigModel.php";

function config_crear()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador') {

        $modelo = new Configuracion();

        if ($_SESSION['tipo_empleado'] === 'Administrador') {
            include "app/views/config_crear.php";
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

function config_registrar() {
    if ($_SESSION['tipo_empleado'] === 'Administrador') {
        $modelo = new Configuracion();

        $tabla = $_POST['tabla'];
        $datos = $_POST['datos'];

        $resultado = $modelo->config_crear($tabla, $datos);

        if ($resultado) {
            $_SESSION['mensaje'] = "Configuración creada con éxito";
            $_SESSION['tipo_mensaje'] = 'exito';
        } else {
            $_SESSION['mensaje'] = "El nombre ya existe.";
            $_SESSION['tipo_mensaje'] = 'error';
        }
        header("Location: index.php?action=config_crear");
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}



function config_listar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador') {

        $modelo = new Configuracion();

        if ($_SESSION['tipo_empleado'] === 'Administrador') {
            $tablas = ['presentacion_insumo', 'patologia', 'pnf', 'servicio', 'tipo_empleado'];
            $registros = [];
            foreach ($tablas as $tabla) {
                $registros[$tabla] = $modelo->config_listar($tabla);
            }
            include "app/views/config_listar.php";
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

function getColumnasPorTabla($tabla)
{

    if ($_SESSION['tipo_empleado'] === 'Administrador') {

        $modelo = new Configuracion();

        $columnas = [
            'presentacion_insumo' => ['nombre_presentacion'], 
            'patologia' => ['nombre_patologia'],
            'pnf' => ['nombre_pnf', 'estatus'],
            'servicio' => ['nombre_serv', 'estatus'],
            'tipo_empleado' => ['tipo', 'estatus']
        ];

        return $columnas[$tabla] ?? [];
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function config_editar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador') {

        $modelo = new Configuracion();

        $tabla = $_GET['tabla'] ?? null;
        $id = $_GET['id'] ?? null;

        if ($tabla && $id) {
            $registro = $modelo->obtenerPorId($tabla, $id);
            $columnas = getColumnasPorTabla($tabla); 

            if ($registro) {
                include "app/views/config_editar.php";
            } else {
                echo "Registro no encontrado.";
            }
        } else {
            echo "Parámetros inválidos para la edición.";
        }
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}

function config_actualizar()
{

    if ($_SESSION['tipo_empleado'] === 'Administrador') {

        $modelo = new Configuracion();

        
        $id = $_POST['id'] ?? null;
        $tabla = $_POST['tabla'] ?? null;
        $datos = $_POST['datos'] ?? null;

        if ($id && $tabla && $datos) {
            $resultado = $modelo->config_actualizar($tabla, $id, $datos);

            if ($resultado) {
                $_SESSION['mensaje'] = "Edición de configuración exitosa";
                $_SESSION['tipo_mensaje'] = 'exito';
            } else {
                $_SESSION['mensaje'] = "Error al editar la configuración, este nombre ya existe";
                $_SESSION['tipo_mensaje'] = 'error';
            }
        } else {
            $_SESSION['mensaje'] = "Datos incompletos para la edición";
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?action=config_listar');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}


function config_eliminar(){
    if ($_SESSION['tipo_empleado'] === 'Administrador') {
        $_SESSION['mensaje'] = "No se puede eliminar este registro, ya que es un valor protegido del sistema.";
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: index.php?action=config_listar');
        exit();
    } else {
        $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción."; 
        $_SESSION['tipo_mensaje'] = 'error';
        header('location:index.php?action=login');
        exit();
    }
}


