/**
 * Created by dmmancera on 7/06/22.
 */
$(function(){
    $("#respuesta").prop('style','display: none');

    $('#cerrar_modal, #cerrar_x').click(function(event){
        $("#respuesta").prop('style','display: none');
    });

    $('#importar_lineas').click(function(event){
        var archivo = $("#archivo_lineas").val();
        console.log("archivo = "+archivo);
        if(archivo != ""){
            var tipo_insercion =  $("#tipo_insercion option:selected").val();
            var nombre_archivo = $("#archivo_lineas").prop('files')[0];
            //console.log("tipo_insercion = "+tipo_insercion);
            //console.log("nombre_archivo = "+nombre_archivo);
            var datos_form = new FormData;
            datos_form.append("nombre_archivo",nombre_archivo);
            datos_form.append("tipo_insercion",tipo_insercion);

            $.ajax({
                url: "GestionViewLineas.php",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: datos_form,
                beforeSend: function(){
                    console.log("ESPERANDO RESPUESTA DEL SERVIDOR");
                    $("#esperando").addClass('preloader');
                },
                success: function(data){
                    var respuesta = JSON.parse(data);
                    console.log("MENSAJE = "+respuesta.mensaje);
                    $("#mensaje").text(respuesta.mensaje);
                    $("#respuesta").prop('style','display: block');
                    $("#esperando").removeClass('preloader');
                    $("#archivo_lineas").val('');
                },
                error: function(){
                    var respuesta = "Error de conexion con el servidor de la aplicacion";
                    $("#mensaje").text(respuesta);
                    $("#respuesta").prop('style','display: block');
                    $("#esperando").removeClass('preloader');
                    $("#archivo_lineas").val('');
                }
            })
        }else{
            var respuesta = "Primero debe seleccionar un archivo de su PC y presionar el boton Cargar Archivo";
            $("#mensaje").text(respuesta);
            $("#respuesta").prop('style','display: block');
            $("#esperando").removeClass('preloader');
        }
    })
})