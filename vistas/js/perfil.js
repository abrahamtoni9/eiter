
$("#perfil_form").on("submit",function(e)
{
    editar_perfil(e);	
})







 // ============================================================================
    // //MOSTRAR DATOS DEL USUARIO EN LA VENTANA MODAL DEL FORMULARIO
 // ============================================================================

function mostrar_perfil(id_usuario)
{
    $.post("../ajax/perfil.ajax.php?op=mostrar_perfil",{id_usuario : id_usuario}, function(data, status)   
    { 
        data = JSON.parse(data);

        $("#perfilModal").modal("show");//abre el modal
        $("#cedula_perfil").val(data.cedula);
        $('#nombre_perfil').val(data.nombre);
        $('#apellido_perfil').val(data.apellido);
        $('#cargo_perfil').val(data.cargo);
        $('#usuario_perfil').val(data.usuario);
        $('#password1_perfil').val(data.password1);
        $('#password2_perfil').val(data.password2);
        $('#telefono_perfil').val(data.telefono);
        $('#email_perfil').val(data.correo);
        $('#direccion_perfil').val(data.direccion);
        $('#estado_perfil').val(data.estado);
        $('.modal-title').text("Editar Perfil");
        $('#id_usuario_perfil').val(id_usuario);
        $('#action').val("Edit");
    });
}














// =============================================================================
// //LA FUNCION guardaryeditar(e); SE LLAMA CUANDO SE DA CLICK AL BOTON SUBMIT
// =============================================================================

function editar_perfil(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#perfil_form")[0]);

    var password1= $("#password1_perfil").val();
    var password2= $("#password2_perfil").val();

       //si el password conincide entonces se envia el formulario
    if(password1 == password2)
    {
        $.ajax(
        {
            url: "../ajax/perfil.ajax.php?op=editar_perfil",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos)
            {
                console.log(datos);

                $('#perfilModal').modal('hide');
                $('#resultados_ajax').html(datos);
            }
        });
    } //cierre de la validacion
    else 
    {
        bootbox.alert("No coincide el password");
    }
}  















// =============================================================================
                    // //EDITAR ESTADO DEL USUARIO
// =============================================================================

//importante:id_usuario, est se envia por post via ajax
function cambiarEstado(id_usuario,est)
{      
    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result)
    {
        if(result)
        {
            $.ajax(
            {
                url:"../ajax/usuario.ajax.php?op=activarydesactivar",
                method:"POST",
                
                //toma el valor del id y del estado
                data:{id_usuario:id_usuario, est:est},
                
                success: function(data)
                {
                    $('#usuario_data').DataTable().ajax.reload();
                }
            });
        }
    });//bootbox
} 