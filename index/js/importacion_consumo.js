/**
 * Created by dmmancera on 5/05/22.
 */
 
$(function(){
    $("#respuesta").prop('style','display: none');

    $('#cerrar_modal, #cerrar_x').click(function(event){
        $("#respuesta").prop('style','display: none');
    });

    $('#importar_tigo').click(function(event){
        var archivo = $("#archivo_dashboard").val();
        console.log("archivo = "+archivo);
        if(archivo != ""){
            var tipo_insercion =  $("#tipo_insercion option:selected").val();
            var nombre_archivo = $("#archivo_dashboard").prop('files')[0];
            var datos_form = new FormData;
            datos_form.append("nombre_archivo",nombre_archivo);
            datos_form.append("tipo_insercion",tipo_insercion);

            $.ajax({
                url: "ConsumoViewTigo.php",
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
                    $("#archivo_dashboard").val('');
                },
                error: function(){
                    var respuesta = "Error de conexion con el servidor de la aplicacion";
                    $("#mensaje").text(respuesta);
                    $("#respuesta").prop('style','display: block');
                    $("#esperando").removeClass('preloader');
                    $("#archivo_dashboard").val('');
                }
            })
        }else{
            var respuesta = "Primero debe seleccionar un archivo de su PC y presioanr el boton Cargar Archivo";
            $("#mensaje").text(respuesta);
            $("#respuesta").prop('style','display: block');
            $("#esperando").removeClass('preloader');
        }

    });

    $('#importar_claro').click(function(event){
        var archivo = $("#archivo_claro").val();
        console.log("archivo = "+archivo);
        if(archivo != ""){
            var tipo_insercion =  $("#tipo_insercion option:selected").val();
            var nombre_archivo = $("#archivo_claro").prop('files')[0];
            var datos_form = new FormData;
            datos_form.append("nombre_archivo",nombre_archivo);
            datos_form.append("tipo_insercion",tipo_insercion);

            $.ajax({
                url: "ConsumoViewClaro.php",
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
                    $("#archivo_claro").val('');
                },
                error: function(){
                    var respuesta = "Error de conexion con el servidor de la aplicacion";
                    $("#mensaje").text(respuesta);
                    $("#respuesta").prop('style','display: block');
                    $("#esperando").removeClass('preloader');
                    $("#archivo_claro").val('');
                }
            })
        }else{
            var respuesta = "Primero debe seleccionar un archivo de su PC y presioanr el boton Cargar Archivo";
            $("#mensaje").text(respuesta);
            $("#respuesta").prop('style','display: block');
            $("#esperando").removeClass('preloader');
        }

    });

})

