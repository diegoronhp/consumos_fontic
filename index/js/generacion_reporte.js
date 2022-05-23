/**
 * Created by dmmancera on 20/05/22.
 */
function comprobar_rango_fechas(desde,hasta){
    var fecha_desde = new Date(desde.split("-"));
    var fecha_hasta = new Date(hasta.split("-"));
    console.log("fecha_desde = "+Date.parse(fecha_desde));
    console.log("fecha_hasta = "+Date.parse(fecha_hasta));
    var cumple = (Date.parse(fecha_hasta) >= Date.parse(fecha_desde)) ? true : false;
    console.log("rango cumple ? "+cumple == true ? "true":"false");
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

        //if((fecha_desde == "")&&(fecha_hasta == "")){
            //mensaje = "Alguno de los campos de fecha se encuentra vacio, por favor complete un rango de fechas para generar el reporte";
            //console.log(mensaje);
            //$("#mensaje").text(mensaje);
            //$("#respuesta").prop('style','display: block');
        //}else{
            //var cumple = comprobar_rango_fechas(fecha_desde,fecha_hasta);

            //if(cumple){
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
                    success: function(data){
                        //var respuesta = JSON.parse(data);
                        //console.log("MENSAJE = "+respuesta.mensaje);
                        //$("#mensaje").text(respuesta.mensaje);
                        //$("#respuesta").prop('style','display: block');
                        /*CODIGO QUE PERMITE DESCARGAR EL ARCHIVO DE EXCEL*/
                        //alert("peticion exitosa");
                        console.log("data = "+data);
                        window.open(data,'_blank');
                        //alert("redireccionado");
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    },
                    error: function(){
                        mensaje = "Error de conexion con el servidor de la aplicacion";
                        $("#mensaje").text(mensaje);
                        $("#respuesta").prop('style','display: block');
                        $("#esperando").removeClass('preloader_r');
                        $("#fecha_desde").val('');
                        $("#fecha_hasta").val('');
                    }
                })
            //}else{
                //mensaje = "La fecha final ("+fecha_hasta+") debe ser mayor a la fecha inicial ("+fecha_desde+")";
                //console.log(mensaje);
                //$("#mensaje").text(mensaje);
                //$("#respuesta").prop('style','display: block');
                //$("#fecha_desde").val('');
                //$("#fecha_hasta").val('');
            //}
        //}
    })

})