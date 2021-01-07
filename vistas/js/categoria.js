

var tabla;

init();

function init()
{
    listar();

      //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
	$("#categoria_form").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	 //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function()
    {		
		$(".modal-title").text("Agregar categoria");	
	});
}

function limpiar()
{
    $("#categoria").val("");
	$('#estado').val("");
	$('#id_categoria').val("");
}



function listar()
{
    tabla=$('#categoria_data').dataTable(
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
            url: '../ajax/categoria.ajax.php?op=listar',
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