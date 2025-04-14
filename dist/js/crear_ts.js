/* ESTO FUNCIONA PARA CUANDO SE VA A CREAR UN REGISTRO DE FAMES, PARA CUANDO SE SELECCIONES OTROS
SE MUESTRE EL CAMPO PARA ESCRIBIR OTRO TIPO DE AYUDA*/
document.addEventListener('DOMContentLoaded', function () {
    console.log('El DOM ha sido cargado');
    const selectElement = document.getElementById('tipo_ayuda');
    const campoOtros = document.getElementById('campoOtros');

    // Verifica el valor inicial al cargar la página
    if (selectElement.value === 'otros') {
        campoOtros.style.display = 'block';
    }

    selectElement.addEventListener('change', function () {
        console.log('Cambio en el select detectado:', this.value);
        if (this.value === 'otros') {
            campoOtros.style.display = 'block';
        } else {
            campoOtros.style.display = 'none';
        }
    });
});

function obtenerParametroURL(parametro) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(parametro);
}

function mostrarFormularioCrear(valor) {
    var formularioBecas = document.getElementById("formulario-becas");
    var formularioExoneracion = document.getElementById("formulario-exoneracion");
    var formularioFames = document.getElementById("formulario-fames");

    formularioBecas.style.display = "none";
    formularioExoneracion.style.display = "none";
    formularioFames.style.display = "none";

    switch (valor) {
        case "becas":
            formularioBecas.style.display = "block";
            break;
        case "exoneracion":
            formularioExoneracion.style.display = "block";
            break;
        case "fames":
            formularioFames.style.display = "block";
            break;
        default:
        // No hacer nada
    }
}


window.onload = function () {
    var formularioEnviado = obtenerParametroURL('formulario');
    let seleccion_consultar = obtenerParametroURL('seleccion');
    console.log("Formulario enviado:", formularioEnviado); // Verifica el valor

    // ESTA PARTE DE LA FUNCION SIRVE PARA MOSTRAR EL FORMULARIO PARA CREAR UNA CONSULTA EN TRABAJO SOCIAL
    if (formularioEnviado) {
        mostrarFormularioCrear(formularioEnviado);
    }

    //ESTA PARTE DE LA FUNCION SIRVE PARA MOSTRAR LAS CONSULTAS DE BECAS O EXONERACION   

    console.log("Valor de seleccion: ", seleccion_consultar); // Debug para ver qué valor llega
    if (seleccion_consultar && document.getElementById('miSelect')) {
        document.getElementById('miSelect').value = seleccion_consultar;  // Selecciona el valor en el select
        mostrarFormulario(seleccion_consultar);  // Llama a la función AJAX para cargar el contenido
    }

};

// FUNCION PARA QUE SE MUESTREN DINAMICAMENTE LAS VISTAS DE CONSULTAS
function mostrarFormulario(valor) {
    let url = '';
    switch (valor) {
        case "becas":
            url = "index.php?action=consultar_beca";
            break;
        case "exoneracion":
            url = "index.php?action=consultar_exoneracion";
            break;
        case "fames":
            url = "index.php?action=consultar_fames";
            break;
        default:
            return;
    }

    // Petición AJAX para cargar el formulario
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            $('#contenidoFormulario').html(data);  // Mostrar contenido dinámico en el div

        }
    });
}

// ESTA FUNCION ES PARA ELIMINAR UN REGISTRO EN LA CONSULTA DE BECAS
function confirmarEliminacionBeca(id, direccion_imagen, id_solicitud_serv) {
    console.log('ID:', id);
    console.log('Dirección de imagen:', direccion_imagen);
    console.log('ID de solicitud de servicio:', id_solicitud_serv);
    if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
        $.ajax({
            url: 'index.php?action=eliminar_beca', // URL al backend para eliminar
            type: 'POST',
            data: {
                id: id,
                direccion_imagen: direccion_imagen,
                id_solicitud_serv: id_solicitud_serv
            },
            dataType: 'json', // Especificamos que esperamos una respuesta JSON
            success: function (response) {
                console.log('error:', response);
                // Verifica si la eliminación fue exitosa
                if (response.success) {
                    // Mostrar mensaje de éxito
                    toastr.success(response.message, "Excelente");
                } else {
                    // Mostrar mensaje de error
                    toastr.error(response.message, "Error");
                }

                // Recargar o actualizar el contenido de la tabla
                mostrarFormulario('becas');
            },
            error: function () {
                alert('Hubo un error al intentar eliminar la beca.');
            }
        });
    }
}

// ESTA FUNCION ES PARA ELIMINAR UN REGISTRO EN LA CONSULTA DE EXONERACION
function confirmarEliminacionEx(id, direccion_imagen, direccion_pdf, id_solicitud_serv) {
    if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
        // Petición AJAX para eliminar la beca
        $.ajax({
            url: 'index.php?action=eliminar_ex', // URL al backend para eliminar
            type: 'POST',
            data:
            {
                id: id,
                direccion_imagen: direccion_imagen,
                direccion_pdf: direccion_pdf,
                id_solicitud_serv: id_solicitud_serv
            }, // Enviar cédula como parámetro
            dataType: 'json', // Especificamos que esperamos una respuesta JSON
            success: function (response) {
                // Verifica si la eliminación fue exitosa
                if (response.success) {
                    // Mostrar mensaje de éxito
                    toastr.success(response.message, "Excelente");
                } else {
                    // Mostrar mensaje de error
                    toastr.error(response.message, "Error");
                }

                mostrarFormulario('exoneracion'); // Esta función recarga el contenido de la tabla
            },
            error: function () {
                alert('Hubo un error al intentar eliminar el registro.');
            }
        });
    }
}

function confirmarEliminacionFames(id, id_solicitud_serv, id_detalle_patologia) {
    if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
        // Petición AJAX para eliminar la beca
        $.ajax({
            url: 'index.php?action=eliminar_fames', // URL al backend para eliminar
            type: 'POST',
            data: { id: id,
                id_solicitud_serv: id_solicitud_serv,
                id_detalle_patologia: id_detalle_patologia
            }, // Enviar cédula como parámetro
            dataType: 'json', // Especificamos que esperamos una respuesta JSON
            success: function (response) {
                // Verifica si la eliminación fue exitosa
                if (response.success) {
                    // Mostrar mensaje de éxito
                    toastr.success(response.message, "Excelente");
                } else {
                    // Mostrar mensaje de error
                    toastr.error(response.message, "Error");
                }

                mostrarFormulario('fames'); // Esta función recarga el contenido de la tabla
            },
            error: function () {
                alert('Hubo un error al intentar eliminar el registro.');
            }
        });
    }
}

// ESTA FUNCION ES PARA QUE SE HABRA UN POPUP EN LAS CONSULTAS DE BECAS Y MUESTRE EL PDF O IMAGEN
function abrirPopupBeca(ruta) {
    const extension = ruta.split('.').pop().toLowerCase();

    // Verificamos si es un PDF
    if (extension === 'pdf') {
        // Verificamos si el archivo PDF está disponible
        fetch(ruta, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    // Si el PDF está disponible, lo abrimos en una nueva pestaña
                    window.open(ruta, '_blank');  // Abre el PDF en una nueva pestaña
                } else {
                    toastr.error('La planilla de inscripcion no está disponible.', 'Error');
                }
            })
            .catch(() => {
                toastr.error('Error al intentar cargar la planilla de inscripcion.', 'Error');
            });
    } else {
        toastr.error('El archivo no es ni una imagen ni un PDF válido.', 'Error');
    }
}

// ESTA FUNCION ES PARA LAS CONSULTAS DE EXONERACION, PARA QUE LOS POPUPS ABRAN LA IMAGEN
document.addEventListener("DOMContentLoaded", function () {
    window.abrirPopupEx = function (ruta) {
        const extension = ruta.split('.').pop().toLowerCase();

        // Verificamos si es un PDF
        if (extension === 'pdf') {
            // Verificamos si el archivo PDF está disponible
            fetch(ruta, { method: 'HEAD' })
                .then(response => {
                    if (response.ok) {
                        // Si el PDF está disponible, lo abrimos en una nueva pestaña
                        window.open(ruta, '_blank');  // Abre el PDF en una nueva pestaña
                    } else {
                        toastr.error('El Estudio Socio-Economico no está disponible.', 'Error');
                    }
                })
                .catch(() => {
                    toastr.error('Error al intentar cargar el Estudio Socio-Economico.', 'Error');
                });
        } else {
            toastr.error('El archivo no es ni una imagen ni un PDF válido.', 'Error');
        }
    };
});


//ESTO FUNCIONA PARA LOS INPUT RADIO DE SI Y NO DE LA SELECCION DE DISCAPACIDAD
document.addEventListener('DOMContentLoaded', function () {
    // Obtener los elementos de los botones de radio
    const siRadioDiscapacitado = document.getElementById('siRadioDiscapacitado');
    const noRadioDiscapacitado = document.getElementById('noRadioDiscapacitado');
    const seleccionEstudioSE = document.getElementById('seleccionEstudioSE');

    // Verifica el valor inicial al cargar la página
    if (noRadioDiscapacitado.checked) {
        seleccionEstudioSE.style.display = 'block';
    }

    // Agregar eventos de cambio a los botones de radio
    noRadioDiscapacitado.addEventListener('change', function () {
        if (noRadioDiscapacitado.checked) {
            seleccionEstudioSE.style.display = 'block'; // Mostrar formulario si "Si" está seleccionado
        }
    });

    siRadioDiscapacitado.addEventListener('change', function () {
        if (siRadioDiscapacitado.checked) {
            seleccionEstudioSE.style.display = 'none'; // Ocultar formulario si "No" está seleccionado
        }
    });
});