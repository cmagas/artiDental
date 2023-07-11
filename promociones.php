<?php
    include("conexionBD.php");
    $fechaActual=date("Y-m-d");

    $consulta="SELECT titulo,url_doc FROM 3008_promociones WHERE situacion='1' AND '".$fechaActual."' BETWEEN fechaPublicacion AND fechaFin ORDER BY fechaRegistro";
    $resp=$con->obtenerFilas($consulta);
?>

<!doctype html>
<html lang="es">

<head>
    <title>ARTIDENT | Cuidamos tus dientes.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">

    <!-- Carga del CSS de "Bootstrap" -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Carga del CSS de "Font Awesome" -->
    <link rel="stylesheet" href="css/all.css">

    <!-- Carga del CSS de "Swiper" -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!-- Carga del CSS de "VenoBox" -->
    <link rel="stylesheet" href="css/venobox.css">

    <!-- Carga del CSS de "Jarallax" -->
    <link rel="stylesheet" href="css/jarallax.css">

    <!-- Carga del CSS de "Pickadate.js" -->
    <link rel="stylesheet" href="js/pickadate.js/themes/default.css">


    <!-- Carga del CSS de "Date Picker" -->
    <link rel="stylesheet" href="js/pickadate.js/themes/default.date.css">

    <!-- Carga del CSS de "Time Picker" -->
    <link rel="stylesheet" href="js/pickadate.js/themes/default.time.css">

    <!-- Carga de Fuentes de google-->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- Style of the plugin -->
    <link rel="stylesheet" href="plugin/components/Font Awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="plugin/whatsapp-chat-support.css">

    <!-- Carga del CSS personalizado -->
    <link rel="stylesheet" href="css/estilos.css">

    <!-- Carga del CSS Servicios -->
    <link rel="stylesheet" href="css/estilosServicios.css">

    <link rel="stylesheet" href="vista/css/promociones.css">


</head>

<body>
    <!-- Seccion #barra-contacto -->
    <section id="barra-contacto" class="bg-primary text-white py-3 py-lg-1 text-center">
        <div class="container">
            <div class="row justify-content-sm-between align-items-sm-center">
                <div class="col-12 col-sm-auto">
                    <i class="fas fa-map-marker-alt mr-1"></i><span>Av. Villahermosa #1116 Col. progreso</span>
                </div>

                <div class="col-12 col-sm-auto">
                    <ul class="redes-sociales list-unstyled d-inline-flex mb-0">
                        <li><a href="https://www.facebook.com/arti.dent.xalapa"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección #detalles-encabezado -->
    <section id="detalles-encabezado" class="d-none d-md-block py-3">
        <div class="container">
            <div class="row justify-content-md-between align-items-md-center">
                <div class="col-auto">
                    <a href="#" class="logo">
                        <img src="images/logo_ArtDent.png" alt="Logo del sitio" width="150" class="img-fluid">
                    </a>
                </div>

                <div class="col-auto ml-md-auto">
                    <i class="fas fa-phone fa-flip-horizontal fa-2x align-middle text-primary"></i>
                    <span class="font-weight-bold h5 ml-2"> +228 814 21 90</span>
                </div>
                <div class="col-auto">
                    <i class="fas fa-envelope fa-2x align-middle text-primary"></i>
                    <span class="font-weight-bold h5 ml-2">arti.dent@hotmail.com</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección #menu-navegacion -->
    <nav id="menu-navegacion" class="navbar navbar-dark bg-secondary navbar-expand-md">
        <div class="container">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu-principal"
                aria-expanded="false" aria-label="Botón Menú principal">
                <span class="boton-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu-principal">
                <ul class="navbar-nav mt-3 mt-md-0">
                    <li class="nav-item mb-1 mb-md-0 mr-md-2"><a href="index.html" class="nav-link active">Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Sección de Servicios -->
    <section id="servicios" class="contenedorPromociones">
        <header class="py-5 bg-primary text-white text-center position-relative">
            <h2 class="display-4 font-weight-bold">PROMOCIONES</h2>
            <h6 class="text-white-50">Ofrecemos una amplia gama de procedimientos para ayudarlo a obtener la sonrisa
                perfecta.</h6>
            <div class="detalle-rectangulo"></div>
        </header>

        <div class="tz-gallery">
            <div class="row">
                <?php
                    while($fila=mysql_fetch_row($resp))
                    {
                        $titulo=$fila[0];
                        $nomImagen=$fila[1];
                    
                ?>
                    <div class="col-sm-6 col-md-4">
                        <h4 class="text-center"><?php echo $titulo ?></h4>
                        <img src="vista/promociones/<?php echo $nomImagen ?>" alt="img-promo" class="contenido">
                    </div>

                <?php
                    }
                ?>

<!--
                <div class="col-sm-6 col-md-4">
                    <h4 class="text-center">TITULO</h4>
                    <img src="vista/promociones/limpieza.png" alt="img-promo" class="contenido">
                </div>
                <div class="col-sm-6 col-md-4">
                    <h4 class="text-center">TITULO</h4>
                    <img src="vista/promociones/servicios.png" alt="img-promo" class="contenido">
                </div>
                    -->
            </div>
        </div>

    </section>

    <!-- Sección #pie-de-pagina -->
    <footer id="pie-de-pagina" class="bg-dark  text-light text-truncate">
        <div class="container">
            <div class="row align-items-center">

                <div class="columna-inclinada col-12 col-md-6 col-xl-5 py-2">
                    <div class="row">

                        <div class="col-12">
                            <h2 class="text-white font-weight-bold h1">WhatsApp</h2>
                        </div>

                        <div class="col-auto text-black-50 ">
                            <i class="fas fa-briefcase-medical fa-4x"></i>
                        </div>

                        <div class="col-auto  text-black-50 pl-0">
                            <h3>2281 081825</h3>
                        </div>

                        <div class="col-auto  text-black-50 pl-0">
                            <p>Horario de servicio de 12:00 a 20:30 hrs - Sabado de 12:30 a 15:00 hrs</p>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-6 col-xl-7 py-2 text-center text-md-right small">
                    <ul class="enlaces-secundario list-unstyled d-inline-flex text-uppercase ">
                        <li><a href="#barra-contacto">Inicio</a></li>
                        <li><a href="#bienvenidos">Nosotros</a></li>
                        <li><a href="#">Políticas de Privacidad</a></li>
                    </ul>
                    <p>©2023. Todos los derechos reservados.(SGTecno)</p>
                </div>

            </div>
        </div>

    </footer>

    <!-- Carga de "Jquery" -->
    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- Carga de "Popper" -->
    <script src="js/popper.min.js"></script>

    <!-- Carga de "Bootstrap" -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Carga de "Swiper" -->
    <script src="js/swiper.min.js"></script>

    <!-- Carga de "VenoBox" -->
    <script src="js/venobox.min.js"></script>

    <!-- Carga de "Jarallax" -->
    <script src="js/jarallax.min.js"></script>

    <!-- Carga de "PictureFill" -->
    <script src="js/picturefill.min.js"></script>

    <!-- Carga de "Waypoints" -->
    <script src="js/jquery.waypoints.min.js"></script>

    <!-- Carga de "jquery.counterup" -->
    <script src="js/jquery.counterup.min.js"></script>

    <!-- Carga de "Picker.js" | Crea el selector de fecha y de hora-->
    <script src="js/pickadate.js/picker.js"></script>

    <!-- Carga de "parsley.js" | Crea la validación de formularios-->
    <script src="js/parsley.min.js"></script>
    <script src="js/parsley.es.js"></script>

    <!-- Carga de "Jquery Stickit.js" | Crean un encabezado fijo en la parte superior de la página-->
    <script src="js/jquery.stickit.min.js"></script>

    <!-- Carga de "page-scroll-to-id" | Crean el efecto de scroll entre los enlaces-->
    <script src="js/jquery.malihu.PageScroll2id.min.js"></script>

    <!-- Carga de "css_browser_selector" | Crean clases para identificar un disp.-->
    <script src="js/css_browser_selector.js"></script>

    <!-- Archivo para configurar e iniciar las funciones de los scripts -->
    <script src="js/mis-scripts.js"></script>

    <!--FullCalendar-->
    <script src="js/moment.min.js"></script>
    <script src="plugin/components/moment/moment-timezone-with-data.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="locales/es.js"></script>
    <script src='js/app.js'></script>

</body>

</html>