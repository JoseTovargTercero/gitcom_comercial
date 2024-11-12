<?php
include('../config/conexion.php');
session_start();


if (!$_SESSION['nombre']) {
    header('Location: ../index.php');
}



$query55 = $conexion->query("select * from local_comunas");
$countries55 = array();
while ($r55 = $query55->fetch_object()) {
    $countries55[] = $r55;
}


?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Gitcom</title>

    <!-- CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />


    <!-- JS de Leaflet -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>


    <!-- CSS para Estilos Personalizados -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Íconos Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS y JS de Leaflet Locate Control -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="dist/L.Control.Locate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .btn-h {
            align-items: center;
        }

        .btn {
            white-space: nowrap;
            height: max-content;
        }

        input {
            height: max-content !important;
        }

        .center-marker {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            pointer-events: none;
            z-index: 1000;
        }

        .center-marker::before {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            background-image: url('../img/crosshair.png');
            background-size: contain;
            background-repeat: no-repeat;
        }

        #center-coords {
            padding: 3px;
            border-radius: 8px;
        }

        .bartop {
            height: fit-content;
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            padding: 5px !important;
        }

        .barbot {
            height: fit-content;
            position: fixed;
            bottom: 0;
            z-index: 9999;
            width: 100%;
            padding: 5px !important;
        }

        .fz-16 {
            font-size: 16px;
        }


        .leaflet-control-locate {
            box-shadow: none !important;
            background-color: #f5f5f5 !important;
            margin-right: 8px !important;
            padding: 2px !important;
        }

        #censoForm {
            background: #ffffffed;
            position: fixed;
            z-index: 1042;
            width: 100%;
            height: 100%;
            overflow-y: auto;
        }

        .hide {
            display: none !important;
        }

        #btn-registrar {
            height: 30px !important;
            width: 30px !important;
            display: grid !important;
            place-items: center !important;
            padding: 0 !important;
        }

        .bg-light-danger {
            background-color: #fdd9d7 !important;
            border-color: #fdd9d7 !important;

        }
    </style>
</head>

<body>




    <form id="censoForm" class="hide p-4" onsubmit="submitForm(event)">

        <!-- Campo RIF -->
        <div class="mb-3">
            <label for="rif" class="form-label">RIF</label>
            <input type="text" class="form-control" id="rif" name="RIF" onkeyup="formatRIF()" required>
        </div>


        <!-- Campo PARROQUIA -->
        <div class="mb-3">
            <label for="parroquia" class="form-label">Parroquia</label>
            <input type="text" class="form-control" id="parroquia" name="PARROQUIA" required>
        </div>
        <!-- Campo COMUNA -->
        <div class="mb-3">
            <label for="comuna" class="form-label">Comuna</label>
            <select style="height: 31px;" type="text" class="form-control" id="comuna" name="COMUNA" required>
                <option value="">Seleccione</option>

                <?php foreach ($countries55 as $c) : ?>
                    <option value="<?php echo $c->id_Comuna; ?>"><?php echo $c->nombre_comuna; ?></option>
                <?php endforeach; ?>


            </select>
        </div>
        <!-- Campo COMUNIDAD -->
        <div class="mb-3">
            <label for="comunidad" class="form-label">Comunidad</label>
            <select style="height: 31px;" type="text" class="form-control" id="comunidad" name="COMUNIDAD" required>
                <option value="">Seleccione</option>

            </select>
        </div>
        <!-- Campo DIRECCION_COMPLETA -->
        <div class="mb-3">
            <label for="direccion_completa" class="form-label">Dirección Completa</label>
            <input class="form-control" id="direccion_completa" name="DIRECCION_COMPLETA" required>
        </div>
        <!-- Campo RAZON_SOCIAL -->
        <div class="mb-3">
            <label for="razonSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" name="RAZON_SOCIAL" required>
        </div>
        <!-- Campo SUJETO -->
        <div class="mb-3">
            <label for="sujeto" class="form-label">Sujeto</label>
            <input type="text" class="form-control" id="sujeto" name="SUJETO" required>
        </div>

        <!-- Campo PROPETARIO -->
        <div class="mb-3">
            <label for="propietario" class="form-label">Propietario</label>
            <input type="text" class="form-control" id="propietario" name="PROPETARIO" required>
        </div>
        <!-- Campo CI -->
        <div class="mb-3">
            <label for="ci" class="form-label">Cédula de Identidad</label>
            <input type="text" class="form-control" id="ci" name="CI" required>
        </div>
        <!-- Campo TELEFONO -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="TELEFONO" required>
        </div>
        <!-- Campo CORREO -->
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="text" class="form-control" id="correo" name="CORREO" required>
        </div>
        <!-- Campo SECTOR_COMERCIAL -->
        <div class="mb-3">
            <label for="sectorComercial" class="form-label">Sector Comercial</label>
            <input type="text" class="form-control" id="sectorComercial" name="SECTOR_COMERCIAL" required>
        </div>
        <!-- Campo ACTIVIDAD_COMERCIAL -->
        <div class="mb-3">
            <label for="actividadComercial" class="form-label">Actividad Comercial</label>
            <input type="text" class="form-control" id="actividadComercial" name="ACTIVIDAD_COMERCIAL" required>
        </div>
        <!-- Campo REFERENCIA -->
        <div class="mb-3">
            <label for="referencia" class="form-label">Referencia</label>
            <input type="text" class="form-control" id="referencia" name="REFERENCIA">
        </div>
        <!-- Campo REFERENCIA_1 -->
        <div class="mb-3">
            <label for="referencia1" class="form-label">Referencia Alternativa</label>
            <input type="text" class="form-control" id="referencia1" name="REFERENCIA_1">
        </div>
        <!-- Campo M2 -->
        <div class="mb-3">
            <label for="m2" class="form-label">Área (M2)</label>
            <input type="number" class="form-control" id="m2" name="M2" required>
        </div>
        <!-- Campo CAPACIDAD_OPERATIVA -->
        <div class="mb-3">
            <label for="capacidadOperativa" class="form-label">Capacidad Operativa</label>
            <select class="form-control" id="capacidadOperativa" name="CAPACIDAD_OPERATIVA" required>
                <option value="">Seleccione</option>
                <option value="0 A 20">0 A 20</option>
                <option value="21 - 50">21 - 50</option>
                <option value="> 50">> 50</option>
            </select>
        </div>
        <!-- Campo ESTATUS -->
        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus</label>
            <select class="form-control" id="estatus" name="ESTATUS" required>
                <option value="">Seleccione</option>
                <option value="ACTIVO">ACTIVO </option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
        </div>
        <!-- Campo GAS -->
        <div class="mb-3">
            <label for="gas" class="form-label">Bombonas pequeñas</label>
            <input type="number" name="gas_p" id="gas_p" class="form-control" value="0">
        </div>
        <div class="mb-3">
            <label for="gas" class="form-label">Bombonas medianas</label>
            <input type="number" name="gas_m" id="gas_m" class="form-control" value="0">
        </div>
        <div class="mb-3">
            <label for="gas" class="form-label">Bombonas grandes</label>
            <input type="number" name="gas_g" id="gas_g" class="form-control" value="0">
        </div>

        <!-- Campo BASURA -->
        <div class="mb-3">
            <label for="basura" class="form-label">Disposición de la basura</label>
            <select class="form-control" id="basura" name="BASURA" required>
                <option value="">Seleccione</option>
                <option value="privado">Servicio privado</option>
                <option value="saneamiento">Saneamiento ambiental</option>
            </select>
        </div>

        <script>
            document.getElementById('basura').addEventListener('change', function() {
                if (this.value === 'saneamiento') {
                    document.getElementById('section_frecuencia').classList.remove('hide');
                } else {
                    document.getElementById('section_frecuencia').classList.add('hide');
                }
            })
        </script>

        <div class="mb-3 hide sectiones_hide" id="section_frecuencia">
            <label for="frecuencia" class="form-label">Frecuencia de recolección</label>
            <select class="form-control" id="frecuencia" name="FRECUENCIA_RECOLECCION">
                <option value="">Seleccione</option>
                <option value="DIARIO">DIARIO</option>
                <option value="SEMANAL">SEMANAL</option>
                <option value="QUINCENAL">QUINCENAL</option>
                <option value="MENSUAL">MENSUAL</option>
            </select>

        </div>

        <div class="mb-3">
            <label for="agua" class="form-label">Acceso al agua</label>
            <select class="form-control" id="agua" name="AGUA" required>
                <option value="">Seleccione</option>
                <option value="TUBERIA">TUBERIA</option>
                <option value="POZO">POZO</option>
                <option value="TUBERIA Y POZO">TUBERIA Y POZO</option>
                <option value="CISTERNA">CISTERNA</option>
                <option value="VECINO">VECINO</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="agua" class="form-label">Uso del agua</label>
            <select class="form-control" id="uso_agua" name="USO_AGUA" required>
                <option value="">Seleccione</option>
                <option value="MATERIA PRIMA">MATERIA PRIMA</option>
                <option value="MERCANCIA SECA">MERCANCIA SECA</option>
                <option value="ninguno">NINGUNO</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="agua" class="form-label">Almacenamiento del agua</label>
            <select class="form-control" id="almacenamiento_agua" name="ALMACENAMIENTO_AGUA" required>
                <option value="">Seleccione</option>
                <option value="TOBOS">TOBOS</option>
                <option value="PIPOTE 35 L">PIPOTE 35 L</option>
                <option value="PIPOTE 50 L">PIPOTE 50 L</option>
                <option value="PIPOTE 150 L">PIPOTE 150 L</option>
                <option value="PIPOTE 200 L">PIPOTE 200 L</option>
                <option value="TANQUE 500 L">TANQUE 500 L</option>
                <option value="TANQUE 700 L">TANQUE 700 L</option>
                <option value="TANQUE 1000L">TANQUE 1000L</option>
                <option value="TANQUE 5000L">TANQUE 5000L</option>
            </select>
        </div>

        <!-- Campo AGUAS_SERVIDAS -->
        <div class="mb-3">
            <label for="aguasServidas" class="form-label">Disposición de aguar servidas</label>
            <select class="form-control" id="aguasServidas" name="AGUAS_SERVIDAS" required>
                <option value="">Seleccione</option>
                <option value="CLOACA">CLOACA</option>
                <option value="POZO SEPTICO">POZO SEPTICO</option>
                <option value="AL AIRE LIBRE">AL AIRE LIBRE</option>
            </select>
        </div>

        <input type="text" hidden id="LAT" name="LAT" required>
        <input type="text" hidden id="LON" name="LON" required>
        <!-- Botón de Envío -->

        <div class="d-flex justify-content-between">
            <button type="button" onclick="cerrarVista()" class="btn btn-danger">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

    </form>




    <section class="w-100 cuerpo-pagina">
        <nav class="bg-white d-flex justify-content-between p-2 bg-white w-100 bartop animate__animated animate__fadeInDown">
            <span class="navbar-brand text-danger ps-2" href="#">GITCOM</span>
            <a href="../controller/logoutController.php" class="btn btn-light me-2 text-danger">
                <i class='bx bx-log-out-circle fz-16'></i>
            </a>
        </nav>

        <div id="map" style="height: 95vh;"></div>

        <div class="d-flex bg-white text-center p-1 w-100 barbot animate__animated animate__fadeInUp">
            <div class="m-auto d-flex">
                <div id="locate-control-container">
                </div>
                <div id="center-coords" style="font-size: 11px; margin-right: 8px; background-color: #f5f5f5;display: grid;place-items: center;"></div>
                <button id="btn-registrar" class="btn btn-white" style=" border: 2px solid #f5f5f5 !important">
                    <i class='bx bx-map text-danger fz-16'></i>
                </button>
            </div>
        </div>
    </section>

    <script>
        const updateField = (fieldName, value) => {
            // Selecciona el campo usando el atributo name en lugar del id
            const field = document.querySelector(`[name="${fieldName}"]`);

            if (field) {
                if (value !== '-' && value !== '') {
                    field.value = value;
                    field.classList.remove('bg-light-danger'); // Remover la clase si hay un valor
                } else {
                    field.value = ''; // Asegurarse de que el campo esté vacío
                    field.classList.add('bg-light-danger'); // Agregar la clase si está vacío
                }
            }
        };


        document.getElementById('rif').addEventListener('change', function() {
            // validar que rif siempre emiece por una letra seguido va solo numeros
            if (!formatRIF()) {
                alert('El formato del rif no es valido')
                return
            }
            fetch('../config/get_info.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        'rif': this.value
                    })
                })
                .then(response => response.json()) // Convertir la respuesta a JSON
                .then(data => {
                    if (data.message) {
                        console.log(data.message);
                    } else {
                        document.getElementById(`comuna`).classList.add('bg-light-danger'); // Agregar la clase si está vacío
                        document.getElementById(`comunidad`).classList.add('bg-light-danger'); // Agregar la clase si está vacío
                        updateField('PARROQUIA', data.PARROQUIA);
                        updateField('DIRECCION_COMPLETA', data.DIRECCION_COMPLETA);
                        updateField('RAZON_SOCIAL', data.RAZON_SOCIAL);
                        updateField('SUJETO', data.SUJETO);
                        updateField('PROPETARIO', data.PROPETARIO);
                        updateField('CI', data.CI);
                        updateField('TELEFONO', data.TELEFONO);
                        updateField('CORREO', data.CORREO);
                        updateField('SECTOR_COMERCIAL', data.SECTOR_COMERCIAL);
                        updateField('ACTIVIDAD_COMERCIAL', data.ACTIVIDAD_COMERCIAL);
                        updateField('REFERENCIA', data.REFERENCIA);
                        updateField('REFERENCIA_1', data.REFERENCIA_1);
                        updateField('M2', data.M2);
                        updateField('CAPACIDAD_OPERATIVA', data.CAPACIDAD_OPERATIVA);
                        updateField('ESTATUS', data.ESTATUS);
                        updateField('BASURA', data.BASURA);
                        updateField('AGUA', data.AGUA);
                        updateField('AGUAS_SERVIDAS', data.AGUAS_SERVIDAS);
                        updateField('gas_p', data.gas_p);
                        updateField('gas_m', data.gas_m);
                        updateField('gas_g', data.gas_g);
                        updateField('FRECUENCIA_RECOLECCION', data.FRECUENCIA_RECOLECCION);
                        updateField('USO_AGUA', data.USO_AGUA);
                        updateField('ALMACENAMIENTO_AGUA', data.ALMACENAMIENTO_AGUA);
                    }
                })
                .catch(error => console.error('Error:', error));
        });


        function formatRIF() {
            const rif = document.getElementById('rif').value.toUpperCase(); // Quitar espacios y pasar a mayúsculas

            // Validación: No permitir espacios ni letras minúsculas
            if (/\s/.test(rif)) { // Si contiene espacios
                input.classList.add('bg-light-danger');
                return false
            }

            // Expresión regular para verificar que comienza con una letra seguida de números
            const rifPattern = /^[A-Za-z]\d+$/;

            if (!rifPattern.test(rif)) {
                // Si no coincide con el patrón de letra seguida de números
                document.getElementById('rif').classList.add('bg-light-danger');
                return false
            } else {
                // Si pasa la validación, quitar la clase de error
                document.getElementById('rif').classList.remove('bg-light-danger');
            }

            // Actualizar el valor del campo a mayúsculas
            document.getElementById('rif').value = rif;
            return true
        }




        async function submitForm(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('censoForm'));
            const data = Object.fromEntries(formData.entries());

            if ($('#basura').val() == 'saneamiento' && $('#frecuencia').val() == '') {
                alert('Frecuencia de recolección no puede estar vacía');
                return
            }


            //try {
            const response = await fetch('../config/guardar_censo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById('censoForm').classList.add('hide')
                $('.bartop').removeClass('hide')
                $('.barbot').removeClass('hide')
                get_puntos()

                document.getElementById('censoForm').reset()

                Swal.fire({
                    title: "Éxito",
                    icon: 'success',
                    html: result.success,
                    confirmButtonText: "Ok",
                }).then((result) => {});
            } else {
                console.log(response)
            }
        }



        /**
         * Select all elements with the class 'form-control' and attach an 'input' event listener
         * Check if the element that triggered the event has the 'border-danger' class
         * If it does, remove the 'border-danger' class from the element
         */

        $(document).ready(function() {
            $(".form-control").on("input", function() {
                if ($(this).hasClass("bg-light-danger")) {
                    $(this).removeClass("bg-light-danger");
                }
            });
        });



        $(document).ready(function() {
            $("#comuna").change(function() {
                $.get("../select/selec_comunidad.php", "comuna=" + $("#comuna").val(), function(data) {
                    $("#comunidad").html(data);
                });
            });
        });


        function cerrarVista() {
            Swal.fire({
                title: "Esta seguro?",
                html: 'Se cancelara el registro y se perderá el avance',
                showDenyButton: true,
                confirmButtonText: "Volver al mapa",
                denyButtonText: `Seguir con el registro`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    document.getElementById('censoForm').classList.add('hide')
                    $('.bartop').removeClass('hide')
                    $('.barbot').removeClass('hide')

                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        // Inicializar el mapa con configuración mínima
        var map = new L.Map('map', {
            minZoom: 1,
            maxZoom: 28,
            zoomControl: false,
            preferCanvas: true
        });

        // Configurar vista inicial
        map.setView([5.65336, -67.62504], 8, false);
        map.attributionControl.setPrefix(' ');

        // Capa de mapa satelital con toponimia
        L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            minZoom: 2,
            maxZoom: 28,
            attribution: '',
            subdomains: ["mt0", "mt1", "mt2", "mt3"]
        }).addTo(map);

        // Crear un elemento HTML para la mira en el centro
        var centerMarker = document.createElement('div');
        centerMarker.className = 'center-marker';
        document.getElementById('map').appendChild(centerMarker);

        // Función para actualizar las coordenadas del centro en el div
        function updateCenterCoordinates() {
            var center = map.getCenter();
            document.getElementById('center-coords').innerHTML = 'Lat: ' + center.lat.toFixed(5) + ', Lng: ' + center.lng.toFixed(5);
        }

        // Llamar a la función al cargar el mapa
        updateCenterCoordinates();

        // Actualizar las coordenadas del centro cada vez que el mapa se mueva
        map.on('move', updateCenterCoordinates);

        // Crear el control de localización sin agregarlo aún al mapa
        var lc = L.control.locate({
            strings: {
                title: "Mostrar mi ubicación"
            },
            icon: 'fas fa-crosshairs', // Icono usando FontAwesome
            iconLoading: 'fas fa-spinner fa-spin', // Icono de carga
            flyTo: true, // Centra el mapa al encontrar la ubicación
            locateOptions: {
                enableHighAccuracy: true
            }
        });
        document.getElementById('locate-control-container').appendChild(lc.onAdd(map));
        //locate-control-container


        // Evento para capturar las coordenadas del centro cuando se presiona el botón
        document.getElementById('btn-registrar').addEventListener('click', function() {
            var center = map.getCenter();
            var lat = center.lat.toFixed(5);
            var lng = center.lng.toFixed(5);

            document.getElementById('LAT').value = lat
            document.getElementById('LON').value = lng

            document.getElementById('censoForm').classList.remove('hide')
            $('.bartop').addClass('hide')
            $('.barbot').addClass('hide')

        });



        var redMarker = L.icon({
            iconUrl: 'images/red.png',
            iconSize: [8, 8],
            iconAnchor: [4, 4]
        });

        function get_puntos() {
            fetch('../config/get_puntos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json()) // Convertir la respuesta a JSON
                .then(data => {
                    if (data.message) {
                        console.log(data.message);
                    } else {
                        const result = data.data;
                        for (const key in result) {
                            if (Object.prototype.hasOwnProperty.call(result, key)) {
                                const item = result[key];

                                L.marker([item.LAT, item.LON], {
                                    icon: redMarker
                                }).bindPopup(`
                                     ${item.RAZON_SOCIAL} <br>
                                     ${item.SUJETO} <br>
                                `).addTo(map)
                            }
                        }

                    }
                })
                .catch(error => console.error('Error:', error));
        }
        get_puntos()
    </script>
</body>

</html>