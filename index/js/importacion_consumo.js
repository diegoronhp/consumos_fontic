/**
 * Created by dmmancera on 5/05/22.
 */
 
$(function(){
    $("#respuesta").prop('style','display: none');

    $('#importar_tigo').click(function(event){
        var nombre_archivo = $("#archivo_dashboard").val();
        var tipo_insercion =  $("#tipo_insercion option:selected").val();
        console.log("ARCHIVO = "+nombre_archivo);
        console.log("INSERCION = "+tipo_insercion);

        $.ajax({
            url: "ConsumoViewTigo.php",
            data: {nombre_archivo : nombre_archivo, tipo_insercion : tipo_insercion},
            type: "POST",
            beforeSend: function(){
                console.log("ESPERANDO RESPUESTA DEL SERVIDOR");
                $("#esperando").prop('style','display: block');
                //$("#esperando").prop('style','text-align: center');
                //$("#esperando").html('<img id="cuadro" src="cargando.gif">');
                //$("#esperando").prop('style','width: 1000px');
                //$("#esperando").prop('style','height: 600px');
                //$("#esperando").prop('style','position: absolute');
                //$("#esperando").prop('style','left: 50px');
                //$("#esperando").prop('style','top: 50px');
            },
            success: function(data){
                var respuesta = JSON.parse(data);
                console.log("MENSAJE = "+respuesta.mensaje);
                $("#mensaje").text(respuesta.mensaje);
                $("#respuesta").prop('style','display: block');
                $("#esperando").prop('style','display: none');
            },
            error: function(){
                var respuesta = "Error de conexion con el servidor de la aplicacion";
                $("#mensaje").text(respuesta);
                $("#respuesta").prop('style','display: block');
                $("#esperando").prop('style','display: none');
            }
        })
    });

    $('#cerrar_modal, #cerrar_x').click(function(event){
        $("#respuesta").prop('style','display: none');
    })
})

