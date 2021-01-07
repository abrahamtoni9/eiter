

var tabla;

init();

var tabla_en_compras;

var tabla_compras_mes;


function init()
{
    listar();
}






function listar()
{
    tabla=$('#compras_data').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [		          
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],

        "ajax": 
        {
            url: '../ajax/compras.ajax.php?op=buscar_compras',
            type : "GET",
            dataType : "JSON",						
            error: function(e)
            {
                console.log(e.responseText);	
            }
        },

        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,//Por cada 10 registros hace una paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

        "language": 
        {
            "sProcessing":     "Procesando...",
            
            "sLengthMenu":     "Mostrar _MENU_ registros",
            
            "sZeroRecords":    "No se encontraron resultados",
            
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            
            "sInfoPostFix":    "",
            
            "sSearch":         "Buscar:",
            
            "sUrl":            "",
            
            "sInfoThousands":  ",",
            
            "sLoadingRecords": "Cargando...",
            
            "oPaginate": 
            {
                "sFirst":    "Primero",
            
                "sLast":     "Último",
            
                "sNext":     "Siguiente",
            
                "sPrevious": "Anterior"
            },
            
            "oAria": 
            {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }//cerrando language

    }).DataTable();
}










 // ============================================================================
    // //MOSTRAR DATOS DEL CATEGORIA EN LA VENTANA MODAL DEL FORMULARIO
 // ============================================================================

function mostrar(id_categoria)
{
    $.post("../ajax/categoria.ajax.php?op=mostrar",{id_categoria : id_categoria}, function(data, status)   
    { 
        console.log(data);
        data = JSON.parse(data);

        $("#categoriaModal").modal("show");//abre el modal
        $("#categoria").val(data.categoria);
        $('#estado').val(data.estado);
        $('.modal-title').text("Editar categoria");
        $('#id_categoria').val(id_categoria);
        $('#action').val("Edit");
    });
}














// =============================================================================
// //LA FUNCION guardaryeditar(e); SE LLAMA CUANDO SE DA CLICK AL BOTON SUBMIT
// =============================================================================

function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#categoria_form")[0]);

    $.ajax(
    {
        url: "../ajax/categoria.ajax.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            console.log(datos);

            $('#categoria_form')[0].reset();
            $('#categoriaModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#categoria_data').DataTable().ajax.reload();

            // $('#resultados_ajax').fadeIn();     
            setTimeout(function() { //podemos usar la libreria de Toastr para los mensajes flash
                $("#resultados_ajax").fadeOut();           
            },3000);
    
            limpiar();
        }
    });
}  















// =============================================================================
                    // //EDITAR ESTADO DEL USUARIO
// =============================================================================

//importante:id_usuario, est se envia por post via ajax
function cambiarEstado(id_categoria,est)
{      
    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result)
    {
        if(result)
        {
            $.ajax(
            {
                url:"../ajax/categoria.ajax.php?op=activarydesactivar",
                method:"POST",
                
                //toma el valor del id y del estado
                data:{id_categoria:id_categoria, est:est},
                
                success: function(data)
                {
                    $('#categoria_data').DataTable().ajax.reload();
                }
            });
        }
    });//bootbox
} 

















// =============================================================================
                        // VER DETALLE PROVEEDOR-COMPRA
// =============================================================================
$(document).on('click', '.detalle', function()
{
    var numero_compra = $(this).attr("id");

    $.ajax({
        url:"../ajax/compras.ajax.php?op=ver_detalle_proveedor_compra",
        method:"POST",
        data:{numero_compra:numero_compra},
        cache:false,
        dataType:"json",
        success:function(data)
        {
            $("#proveedor").html(data.proveedor);
            $("#numero_compra").html(data.numero_compra);
            $("#cedula_proveedor").html(data.cedula_proveedor);
            $("#direccion").html(data.direccion);
            $("#fecha_compra").html(data.fecha_compra);
        }
    })
});























// =============================================================================
                            // VER DETALLE COMPRA
// =============================================================================

$(document).on('click', '.detalle', function()
{
    var numero_compra = $(this).attr("id");

    $.ajax({
        url:"../ajax/compras.ajax.php?op=ver_detalle_compra",
        method:"POST",
        data:{numero_compra:numero_compra},
        cache:false,
        //dataType:"json",
        success:function(data)
        {
            $("#detalles").html(data);
        }
    })
});



















// =============================================================================
                        // CAMBIAR ESTADO DE LA COMPRA
// =============================================================================

function cambiarEstado(id_compras, numero_compra, est)
{
    bootbox.confirm("¿Estas seguro que quieres anular esta compra?", function(result)
    {
		if(result)
		{
			$.ajax({
				url:"../ajax/compras.ajax.php?op=cambiar_estado_compra",
                method:"POST",
				data:{id_compras:id_compras,numero_compra:numero_compra, est:est},
				cache: false,
				
                success:function(data)
                {
                    $('#compras_data').DataTable().ajax.reload();
                    $('#compras_fecha_data').DataTable().ajax.reload();//refresca el datatable de compras por fecha
                    $('#compras_fecha_mes_data').DataTable().ajax.reload(); //refresca el datatable de compras por fecha - mes
				}
			});
        } 
    });//bootbox
}
























// ==========================================================================
                // //CONSULTA COMPRAS-FECHA
// ==========================================================================
$(document).on("click","#btn_compra_fecha", function()
{
    var fecha_inicial= $("#datepicker").val();
    var fecha_final= $("#datepicker2").val();

    //validamos si existe las fechas entonces se ejecuta el ajax
    if(fecha_inicial!="" && fecha_final!="")
    {
        tabla_en_compras= $('#compras_fecha_data').DataTable({

            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: 
            [		          
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],

            "ajax":
            {
                url:"../ajax/compras.ajax.php?op=buscar_compras_fecha",
                type : "post",
                //dataType : "json",
                data:{fecha_inicial:fecha_inicial,fecha_final:fecha_final},						
                error: function(e)
                {
                    console.log(e.responseText);
                },
            },

            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

            "language": 
            {
                "sProcessing":     "Procesando...",
            
                "sLengthMenu":     "Mostrar _MENU_ registros",
            
                "sZeroRecords":    "No se encontraron resultados",
            
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
            
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            
                "sInfoPostFix":    "",
            
                "sSearch":         "Buscar:",
            
                "sUrl":            "",
            
                "sInfoThousands":  ",",
            
                "sLoadingRecords": "Cargando...",
            
                "oPaginate": 
                {
                    "sFirst":    "Primero",
            
                    "sLast":     "Último",
            
                    "sNext":     "Siguiente",
            
                    "sPrevious": "Anterior"
                },
            
                "oAria": 
                {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"        
                }

            }, //cerrando language

        }); //"scrollX": true

    }//cerrando condicional de las fechas

});




























// =============================================================================
                    // //FECHA COMPRA POR MES
// =============================================================================

$(document).on("click","#btn_compra_fecha_mes", function()
{
    var mes= $("#mes").val();
    var ano= $("#ano").val();
    
    //validamos si existe las fechas entonces se ejecuta el ajax
    if(mes!="" && ano!="")
    {
        // BUSCA LAS COMPRAS POR FECHA
        var tabla_compras_mes= $('#compras_fecha_mes_data').DataTable({
 
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: 
            [		          
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],

            "ajax":
            {
                url:"../ajax/compras.ajax.php?op=buscar_compras_fecha_mes",
                type : "post",
                //dataType : "json",
                data:{mes:mes,ano:ano},						
                error: function(e)
                {
                    console.log(e.responseText);
                },
            },

            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

            "language": 
            {
                "sProcessing":     "Procesando...",

                "sLengthMenu":     "Mostrar _MENU_ registros",

                "sZeroRecords":    "No se encontraron resultados",

                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix":    "",

                "sSearch":         "Buscar:",

                "sUrl":            "",

                "sInfoThousands":  ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": 
                {
                    "sFirst":    "Primero",

                    "sLast":     "Último",

                    "sNext":     "Siguiente",

                    "sPrevious": "Anterior"
                },

                "oAria": 
                {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }, //cerrando language
            //"scrollX": true
        });
    }//cerrando condicional de las fechas
});
