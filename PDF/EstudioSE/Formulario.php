<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Estudio Socioeconómico</title>
</head>

<body>
    <hr>
    <div class="content">
        <div class="container-fluid">
            <h1 class="text-center mb-4">Formulario de Estudio Socioeconómico</h1>

            <!-- Card para Foto -->
            <div class="card">
                <div class="card-header text-white bg-navy">
                    <h3 class="card-title">Foto</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="imagen">Foto del solicitante:</label>
                        <input type="file" class="form-control" name="imagen" id="imagen_se" accept="image/*">
                        <div id="imagen_error" class="text-danger"></div>
                    </div>
                </div>
            </div>

            <!-- Card para Solicitud -->
            <div class="card mt-3">
                <div class="card-header text-white bg-navy">
                    <h3 class="card-title">Solicitud</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>SOLICITUD:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="renovacion" id="solicitud_renovacion"
                                    value="X">
                                <label class="form-check-label" for="solicitud_renovacion">Renovación</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nueva" id="solicitud_nueva"
                                    value="X">
                                <label class="form-check-label" for="solicitud_nueva">Nueva</label>
                            </div>
                            <div id="solicitud_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="beneficio">BENEFICIO SOLICITADO:</label>
                            <input type="text" class="form-control" name="beneficio" id="beneficio"
                                onkeypress="soloLetras(event)">
                            <div id="beneficio_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="fecha">FECHA:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha">
                            <div id="fecha_error" class="text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card para Identificación del Solicitante -->
            <div class="card mt-3">
                <div class="card-header text-white bg-navy">
                    <h3 class="card-title">Identificación del Solicitante</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Apellidos y Nombres:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" onkeypress="soloLetras(event)">
                        <div id="nombre_error" class="text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="nacimiento">Lugar y Fecha de Nacimiento:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nacimiento" id="nacimiento">
                                <div id="nacimiento_error" class="text-danger"></div>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
                                <div id="fecha_nacimiento_error" class="text-danger"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="edad">Edad:</label>
                            <input type="text" class="form-control" name="edad" id="edad"
                                onkeypress="soloNumeros(event)" maxlength="2">
                            <div id="edad_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="estado_civil">Estado Civil:</label>
                            <select class="form-control" name="estado_civil" id="estado_civil">
                                <option value="" disabled selected>Seleccione un estado civil:</option>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viudo">Viudo</option>
                            </select>
                            <div id="estado_civil_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="ci">CI:</label>
                            <input type="text" class="form-control" name="ci" id="ci" onkeypress="soloNumeros(event)" maxlength="8">
                            <div id="ci_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono"
                                onkeypress="soloNumeros(event)" maxlength="11">
                            <div id="telefono_error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Trabaja:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tr_si" id="trabaja_si" value="X">
                                <label class="form-check-label" for="trabaja_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tr_no" id="trabaja_no" value="X">
                                <label class="form-check-label" for="trabaja_no">No</label>
                            </div>
                            <div id="trabaja_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="ocupacion">Ocupación:</label>
                            <input type="text" class="form-control" name="ocupacion" id="ocupacion"
                                onkeypress="soloTexto(event)">
                            <div id="ocupacion_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="lugar_trabajo">Lugar de Trabajo:</label>
                            <input type="text" class="form-control" name="lugar_trabajo" id="lugar_trabajo">
                            <div id="lugar_trabajo_error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sueldo">Sueldo:</label>
                        <input type="text" class="form-control" name="sueldo" id="sueldo"
                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)">
                        <div id="sueldo_error" class="text-danger"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>¿Tiene carga familiar?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cf_si" id="carga_familiar_si"
                                    value="X">
                                <label class="form-check-label" for="carga_familiar_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cf_no" id="carga_familiar_no"
                                    value="X">
                                <label class="form-check-label" for="carga_familiar_no">No</label>
                            </div>
                            <div id="carga_familiar_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="hijos">Número de hijos:</label>
                            <input type="text" class="form-control" name="hijos" id="hijos" onkeypress="soloNumeros(event)" maxlength="2">
                            <div id="hijos_error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dir_hab">Dirección de Habitación:</label>
                        <input type="text" class="form-control" name="dir_hab" id="dir_hab">
                        <div id="dir_hab_error" class="text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="dir_res">Dirección de Residencia:</label>
                        <input type="text" class="form-control" name="dir_res" id="dir_res">
                        <div id="dir_res_error" class="text-danger"></div>
                    </div>
                </div>
            </div>

            <!-- Card para Datos Educativos -->
            <div class="card mt-3">
                <div class="card-header text-white bg-navy">
                    <h3 class="card-title">Datos Educativos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="especialidad">Especialidad:</label>
                            <input type="text" class="form-control" name="especialidad" id="especialidad"
                                onkeypress="soloLetras(event)">
                            <div id="especialidad_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="sem_tra">Semestre o Trayecto:</label>
                            <input type="text" class="form-control" name="sem_tra" id="sem_tra"
                                onkeypress="soloNumeros(event)" maxlength="1">
                            <div id="sem_tra_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="turno">Turno:</label>
                            <select class="form-control" name="turno" id="turno">
                                <option value="" selected disabled>Seleccione una opcion...</option>
                                <option value="Diurno">Diurno</option>
                                <option value="Nocturno">Nocturno</option>
                            </select>
                            <div id="turno_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="seccion">Sección:</label>
                            <input type="text" class="form-control" name="seccion" id="seccion">
                            <div id="seccion_error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="correo">Correo Electrónico:</label>
                            <input type="email" class="form-control" name="correo" id="correo">
                            <div id="correo_error" class="text-danger"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="redes">Facebook/Twitter:</label>
                            <input type="text" class="form-control" name="redes" id="redes">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla para Grupo Familiar -->
            <div class="card mt-3">
                <div class="card-header bg-navy text-white">
                    <h3 class="card-title">Grupo Familiar</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>Apellido y Nombre</th>
                                    <th>Edad</th>
                                    <th>Parentesco</th>
                                    <th>Edo. Civil</th>
                                    <th>Grado de Instrucción</th>
                                    <th>Ocupación</th>
                                    <th>Lugar de Trabajo</th>
                                    <th>Sueldo</th>
                                    <th>Aporte al Hogar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Repetir las filas según sea necesario -->
                                <tr>
                                    <td><input type="text" name="nombre1" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="edad1" class="form-control"
                                            onkeypress="soloNumeros(event)"></td>
                                    <td><input type="text" name="parentesco1" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><select class="form-control" name="edoCivil1" id="edoCivil1">
                                            <option value="" disabled selected>Seleccione un estado civil:</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select></td>
                                    <td><input type="text" name="gradoInstruccion1" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="ocupacion1" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="lugarTrabajo1" class="form-control"></td>
                                    <td><input type="text" name="sueldo1" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td><input type="text" name="aporteHogar1" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="nombre2" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="edad2" class="form-control"
                                            onkeypress="soloNumeros(event)"></td>
                                    <td><input type="text" name="parentesco2" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><select class="form-control" name="edoCivil2" id="edoCivil2">
                                            <option value="" disabled selected>Seleccione un estado civil:</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select></td>
                                    <td><input type="text" name="gradoInstruccion2" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="ocupacion2" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="lugarTrabajo2" class="form-control"></td>
                                    <td><input type="text" name="sueldo2" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td><input type="text" name="aporteHogar2" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="nombre3" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="edad3" class="form-control"
                                            onkeypress="soloNumeros(event)"></td>
                                    <td><input type="text" name="parentesco3" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><select class="form-control" name="edoCivil3" id="edoCivil3">
                                            <option value="" disabled selected>Seleccione un estado civil:</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select></td>
                                    <td><input type="text" name="gradoInstruccion3" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="ocupacion3" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="lugarTrabajo3" class="form-control"></td>
                                    <td><input type="text" name="sueldo3" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td><input type="text" name="aporteHogar3" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="nombre4" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="edad4" class="form-control"
                                            onkeypress="soloNumeros(event)"></td>
                                    <td><input type="text" name="parentesco4" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><select class="form-control" name="edoCivil4" id="edoCivil4">
                                            <option value="" disabled selected>Seleccione un estado civil:</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select></td>
                                    <td><input type="text" name="gradoInstruccion4" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="ocupacion4" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="lugarTrabajo4" class="form-control"></td>
                                    <td><input type="text" name="sueldo4" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td><input type="text" name="aporteHogar4" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="nombre5" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="edad5" class="form-control"
                                            onkeypress="soloNumeros(event)"></td>
                                    <td><input type="text" name="parentesco5" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><select class="form-control" name="edoCivil5" id="edoCivil5">
                                            <option value="" disabled selected>Seleccione un estado civil:</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select></td>
                                    <td><input type="text" name="gradoInstruccion5" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="ocupacion5" class="form-control"
                                            onkeypress="soloLetras(event)"></td>
                                    <td><input type="text" name="lugarTrabajo5" class="form-control"></td>
                                    <td><input type="text" name="sueldo5" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td><input type="text" name="aporteHogar5" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabla para Ingresos y Egresos del Hogar -->
            <div class="card mt-3">
                <div class="card-header bg-navy text-white">
                    <h3 class="card-title">Ingresos y Egresos del Hogar</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>Ingresos de Hogar</th>
                                    <th>Bs.</th>
                                    <th>Egresos</th>
                                    <th>Bs.</th>
                                    <th colspan="2">Tenencia de la Vivienda</th>
                                    <th colspan="2">Tipo de Vivienda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sueldo</td>
                                    <td><input type="text" name="ingreso_sueldo" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Alimentación</td>
                                    <td><input type="text" name="egreso_alimentacion" class="form-control" onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Propia</td>
                                    <td><input type="radio" name="propia" value="Propia"></td>
                                    <td>Casa</td>
                                    <td><input type="radio" name="casa" value="Casa"></td>
                                </tr>
                                <tr>
                                    <td>Trabajos Particulares</td>
                                    <td><input type="text" name="ingreso_trabajos" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Vivienda</td>
                                    <td><input type="text" name="egreso_vivienda" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Opción a Compra</td>
                                    <td class="radio-cell"><input type="radio" name="opcion_compra" value="X"></td>
                                    <td>Quinta</td>
                                    <td class="radio-cell"><input type="radio" name="quinta" value="X"></td>
                                </tr>
                                <tr>
                                    <td>Renta de Propiedades</td>
                                    <td><input type="text" name="ingreso_renta" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Serv. Públicos</td>
                                    <td><input type="text" name="egreso_servicios" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Alquilada</td>
                                    <td class="radio-cell"><input type="radio" name="alquilada" value="X"></td>
                                    <td>Apartamento</td>
                                    <td class="radio-cell"><input type="radio" name="apto" value="X"></td>
                                </tr>
                                <tr>
                                    <td>Pensiones y Jubil.</td>
                                    <td><input type="text" name="ingreso_pensiones" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Educación</td>
                                    <td><input type="text" name="egreso_educacion" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Prestada o Alajada</td>
                                    <td class="radio-cell"><input type="radio" name="prestada" value="X"></td>
                                    <td>Vivienda Rural</td>
                                    <td class="radio-cell"><input type="radio" name="rural" value="X"></td>
                                </tr>
                                <tr>
                                    <td>Ayudas Familiares</td>
                                    <td><input type="text" name="ingreso_ayudas" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Transporte</td>
                                    <td><input type="text" name="egreso_transporte" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Hipotecada</td>
                                    <td class="radio-cell"><input type="radio" name="hipoteca" value="X"></td>
                                    <td>Vivienda INAVI</td>
                                    <td class="radio-cell"><input type="radio" name="inavi" value="X"></td>
                                </tr>
                                <tr>
                                    <td>Otros</td>
                                    <td><input type="text" name="ingreso_otros" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Salud</td>
                                    <td><input type="text" name="egreso_salud" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Pagando Actualmente</td>
                                    <td class="radio-cell"><input type="radio" name="pagando" value="X"></td>
                                    <td>Rancho Rural</td>
                                    <td class="radio-cell"><input type="radio" name="r_r" value="X"></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><input type="text" name="total_ingresos" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Total</td>
                                    <td><input type="text" name="total_egresos" class="form-control"
                                            onkeypress="soloSueldos(event)" value="BsD " oninput="mantenerPrefijo(event)"></td>
                                    <td>Otros</td>
                                    <td class="radio-cell"><input type="radio" name="tenencia_otros" value="X"></td>
                                    <td>Rancho Urbano</td>
                                    <td class="radio-cell"><input type="radio" name="r_u" value="X"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="card mt-3">
                <div class="card-header bg-navy text-white">
                    <h3 class="card-title">Observaciones</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="observaciones">Observaciones:</label>
                        <textarea class="form-control" name="observaciones" id="observaciones" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Escuchar el evento de cambio en todos los radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function(event) {
                // Si el radio button que se cambió es parte de "trabaja"
                if (event.target.name === 'tr_si' || event.target.name === 'tr_no') {
                    const trabajaRadios = document.querySelectorAll('input[name="tr_si"], input[name="tr_no"]');
                    trabajaRadios.forEach(function(r) {
                        if (r !== event.target) {
                            r.checked = false; // Deselecciona los demás radios de "trabaja"
                        }
                    });
                }

                // Si el radio button que se cambió es parte de "carga_familiar"
                if (event.target.name === 'cf_si' || event.target.name === 'cf_no') {
                    const cargaRadios = document.querySelectorAll('input[name="cf_si"], input[name="cf_no"]');
                    cargaRadios.forEach(function(r) {
                        if (r !== event.target) {
                            r.checked = false; // Deselecciona los demás radios de "carga_familiar"
                        }
                    });


                }

                if (event.target.name === 'renovacion' || event.target.name === 'nueva') {
                    const cargaRadios = document.querySelectorAll('input[name="renovacion"], input[name="nueva"]');
                    cargaRadios.forEach(function(r) {
                        if (r !== event.target) {
                            r.checked = false; // Deselecciona los demás radios de "carga_familiar"
                        }
                    });
                }

                if (event.target.name === 'propia' || event.target.name === 'opcion_compra' || event.target.name === 'alquilada' || event.target.name === 'prestada' || event.target.name === 'hipoteca' || event.target.name === 'pagando' || event.target.name === 'tenencia_otros') {
                    const cargaRadios = document.querySelectorAll('input[name="propia"], input[name="opcion_compra"], input[name="alquilada"], input[name="prestada"], input[name="hipoteca"], input[name="pagando"], input[name="tenencia_otros"]');
                    cargaRadios.forEach(function(r) {
                        if (r !== event.target) {
                            r.checked = false; // Deselecciona los demás radios de "carga_familiar"
                        }
                    });
                }

                if (event.target.name === 'casa' || event.target.name === 'quinta' || event.target.name === 'apto' || event.target.name === 'rural' || event.target.name === 'inavi' || event.target.name === 'r_r' || event.target.name === 'r_u') {
                    const cargaRadios = document.querySelectorAll('input[name="casa"], input[name="quinta"], input[name="apto"], input[name="rural"], input[name="inavi"], input[name="r_r"], input[name="r_u"]');
                    cargaRadios.forEach(function(r) {
                        if (r !== event.target) {
                            r.checked = false; // Deselecciona los demás radios de "carga_familiar"
                        }
                    });
                }
            });



        });

        function soloNumeros(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key).toString();
            const numeros = "0123456789";

            const especiales = [8, 13]; // backspace, enter
            let tecla_especial = false;

            for (const i in especiales) {
                if (key === especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (numeros.indexOf(tecla) === -1 && !tecla_especial) {
                e.preventDefault();
            }
        }

        function soloLetras(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key).toString();
            const letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ";

            const especiales = [8, 13, 32]; // backspace, enter, space
            let tecla_especial = false;

            for (const i in especiales) {
                if (key === especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) === -1 && !tecla_especial) {
                e.preventDefault();
            }
        }

        function soloSueldos(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key).toString();
            const validos = "0123456789.,";
            const especiales = [8, 13];

            let tecla_especial = false;

            for (const i in especiales) {
                if (key === especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (validos.indexOf(tecla) === -1 && !tecla_especial) {
                e.preventDefault();
            }
        }

        function mantenerPrefijo(event) {
            const input = event.target;
            const prefijo = "BsD ";
            if (!input.value.startsWith(prefijo)) {
                input.value = prefijo + input.value.slice(prefijo.length).replace(prefijo, '');
            }
        }
    </script>
</body>

</html>