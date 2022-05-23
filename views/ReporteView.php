<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Consumo Reporte</title>
    <link rel="icon" type="image/x-icon" href="../index/assets/favicon.ico"/>
    <!--Version del jQuery-->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet"/>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css"
          rel="stylesheet"/>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../index/css/styles.css" rel="stylesheet"/>

    <!-- prueba div2 cargando -->
    <style>

        .preloader_r{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-image: url('cargando.gif');
            background-repeat: no-repeat;
            background-color: #c7d3e3b3;
            background-position: center;
        }
    </style>
</head>
<body id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/consumos_fontic/">Inicio</a>
    </div>
</nav>
<!-- End Navigation-->

<div id="esperando"></div>

<div class="preloader_r"></div>


<header class="masthead">


    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">


        <div class="d-flex justify-content-center">


            <div class="text-center">

                <div align="align-items-center"><img src="../index/assets/img/tigo.png" width="170" height="130">


                    <h1 class="mx-auto my-3 text-uppercase">Generar reporte</h1>
                    <br>

                    <form id="consultando" role="form">
                        <!-- inicio seleccion de fecha -->

                        <div class="form-group">
                            <div class='input-group date' >
                                <label for="example" class="text-white ">DESDE &nbsp; </label><br>
                                <input id='fecha_desde' type='date' class="form-control"/>


                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                        <br>

                        <div class='input-group date'>
                            <label for="example" class="text-white ">HASTA &nbsp;</label><br>
                            <input id='fecha_hasta' type='date' class="form-control"/>

                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                        </div>
                        <br>
                        <br>
                        <a class="btn btn-success" type="button" id="consultar_reporte" data-mdb-ripple-color="dark">Generar Reporte</a>
                    </form>

                </div>




                <br><br><br>

                <h2 class="text-white-50 mx-auto mt-2 mb-5">Debe seleccionar un rango de fecha desde y hasta para
                    generar el respectivo reporte en Excel.</h2>
            </div>
        </div>
    </div>
</header>


<div id="respuesta" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consumo Mintic</h5>
                <button id="cerrar_x" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="mensaje" class="modal-body">
            </div>
            <div class="modal-footer">
                <button id="cerrar_modal" type="button" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>


<!-- Footer-->
<footer class="footer bg-black small text-center text-white-50">
    <div class="container px-4 px-lg-4">Copyright &copy; Desarrollo Web TIGO 2022</div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../index/js/scripts.js"></script>
<script src="../index/js/generacion_reporte.js"></script>
<!-- // preloads -->
<script>
    $(window).load(function () {
        $('.preloader_r').fadeOut('slow');
        //$('#fecha_desde').datetimepicker();
        //$('#fecha_hasta').datetimepicker();
    });
</script>
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               DESARROLLO TIGO                               * *-->
<!-- * * *********************************************************************** * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
