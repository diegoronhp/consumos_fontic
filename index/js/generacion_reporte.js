/**
 * Created by dmmancera on 20/05/22.
 */
function comprobar_rango_fechas(desde,hasta){
    var fecha_desde = new Date(desde.split("-"));
    var fecha_hasta = new Date(hasta.split("-"));
    console.log("fecha_desde = "+Date.parse(fecha_desde));
    console.log("fecha_hasta = "+Date.parse(fecha_hasta));
    var cumple = (Date.parse(fecha_hasta) >= Date.parse(fecha_desde)) ? true : false;
    console.log("rango cumple ? ");
    console.log(cumple == true ? "true":"false");
    return cumple;
}

$(function(){
    $('#cerrar_modal, #cerrar_x').click(function(event){
        $("#respuesta").prop('style','display: none');
    });

    $('#consultar_reporte').click(function(event){
        var mensaje = "";
        var fecha_desde = $("#fecha_desde").val();
        var fecha_hasta = $("#fecha_hasta").val();
        console.log("fecha_desde = "+fecha_desde);
        console.log("fecha_hasta = "+fecha_hasta);

        if((fecha_desde == "")||(fecha_hasta == "")){
            mensaje = "Alguno de los campos de fecha se encuentra vacio, por favor complete un rango de fechas para generar el reporte";
            console.log(mensaje);
            $("#mensaje").text(mensaje);
            $("#respuesta").prop('style','display: block');
        }else{
            var cumple = comprobar_rango_fechas(fecha_desde,fecha_hasta);

            if(cumple){
                var datos_form = new FormData;
                datos_form.append("fecha_desde",fecha_desde);
                datos_form.append("fecha_hasta",fecha_hasta);

                $.ajax({
                    url: 'ConsultaReportePeriodo.php',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datos_form,
                    beforeSend: function(){
                        console.log("ESPERANDO RESPUESTA DEL SERVIDOR");
                        $("#esperando").addClass('preloader_r');
                    },
                    //CODIGO PROBADO EN LA VERSION DE LINUX
                    success: function(data){
                        var respuesta = JSON.parse(data);
                        console.log("data = "+data);
                        var blob=new Blob([data]);
                        var link=document.createElement('a');
                        link.click();
                        //window.location.replace("/reportes_consumos/Reporte_consumos_periodo.xlsx"); //RUTA EN LINUX
                        window.location.replace("../reportes_consumos/Reporte_consumos_periodo.xlsx");  //RUTA EN WINDOWS
                        $("#esperando").removeClass('preloader_r');
                        $("#mensaje").text(respuesta.mensaje);
                        $("#respuesta").prop('style','display: block');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    },

                    /*
                    //RESPUESTA DEL SERVIDOR PARA DESPLEGAR VENTANA MODAL CON MENSAJE DE RESPUESTA DESDE EL SERVIDOR
                    success: function(data){
                        var respuesta = JSON.parse(data);
                        console.log("mensaje = "+respuesta.mensaje);
                        $("#mensaje").text(respuesta.mensaje);
                        $("#respuesta").prop('style','display: block');
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    },*/
                    /*
                    //OPCION 1 => RESPUESTA DEL SERVIDOR PARA DESCARGAR ARCHIVO
                    success: function(response){
                        console.log("response = "+response.data);
                        format = "xlsx";
                        var linkSource = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'+ response.data ;
                        var downloadLink = document.createElement("a");
                        var fileName = 'pruebareporte.' + format;
                        downloadLink.href = linkSource;
                        downloadLink.download = fileName;
                        downloadLink.click();
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    },*/
                    /*
                    //OPCION 2 => RESPUESTA DEL SERVIDOR PARA DESCARGAR ARCHIVO
                    success: function(data){
                        console.log("data = "+data);
                        var blob=new Blob([data]);
                        var link=document.createElement('a');
                        link.href=window.URL.createObjectURL(blob);
                        link.download="Reporte_consumos_periodo.xlsx";
                        link.click();
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    },*/
                    /*
                    //OPCION 3 => RESPUESTA DEL SERVIDOR PARA DESCARGAR ARCHIVO
                    success: function(response, status, xhr){
                        // check for a filename
                        var filename = "";
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);

                            if (matches != null && matches[1])
                                filename = matches[1].replace(/['"]/g, '');
                        }

                        var type = xhr.getResponseHeader('Content-Type');
                        var blob = new Blob([response], { type: type });

                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);

                            if (filename) {
                                var a = document.createElement("a");

                                if (typeof a.download === 'undefined') {
                                    window.location = downloadUrl;
                                } else {
                                    a.href = downloadUrl;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click(); }
                            } else {
                                window.location = downloadUrl;
                            }
                            setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100);
                        }
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    },*/
                    error: function(){
                        mensaje = "Error de conexion con el servidor de la aplicacion";
                        $("#mensaje").text(mensaje);
                        $("#respuesta").prop('style','display: block');
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    }
                })
            }else{
                mensaje = "La fecha final ("+fecha_hasta+") debe ser mayor a la fecha inicial ("+fecha_desde+")";
                console.log(mensaje);
                $("#mensaje").text(mensaje);
                $("#respuesta").prop('style','display: block');
                $("#fecha_desde").val('');
                $("#fecha_hasta").val('');
            }
        }
    })

})