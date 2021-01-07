

var tabla;
var tabla_en_ventas;

init();

function init()
{
    listar();

    listar_en_ventas();

      //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
	$("#cliente_form").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	 //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function()
    {		
		$(".modal-title").text("Agregar cliente");	
	});
}

function limpiar()
{
    $('#cedula').val("");
	$('#nombre').val("");
	$('#apellido').val("");
	$('#telefono').val("");
	$('#email').val("");
	$('#direccion').val("");
	$('#estado').val("");
	$('#cedula_cliente').val("");
}



function listar()
{
    tabla=$('#cliente_data').dataTable(
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
            url: '../ajax/cliente.ajax.php?op=listar',
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
    // //MOSTRAR DATOS DEL CLIENTE EN LA VENTANA MODAL DEL FORMULARIO
 // ============================================================================

function mostrar(cedula_cliente)
{
    $.post("../ajax/cliente.ajax.php?op=mostrar",{cedula_cliente : cedula_cliente}, function(data, status)   
    { 
        console.log(data);
        data = JSON.parse(data);

        $('#clienteModal').modal('show');
        $('#cedula').val(cedula_cliente);
        $('#nombre').val(data.nombre);
        $('#apellido').val(data.apellido);
        $('#telefono').val(data.telefono);
        $('#email').val(data.correo);
        $('#direccion').val(data.direccion);
        $('#estado').val(data.estado);
        $('.modal-title').text("Editar Cliente");
        $('#cedula_cliente').val(cedula_cliente);
    });
}














// =============================================================================
// //LA FUNCION guardaryeditar(e); SE LLAMA CUANDO SE DA CLICK AL BOTON SUBMIT
// =============================================================================

function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#cliente_form")[0]);

    $.ajax(
    {
        url: "../ajax/cliente.ajax.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            console.log(datos);

            $('#cliente_form')[0].reset();
            $('#clienteModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#cliente_data').DataTable().ajax.reload();

            // $('#resultados_ajax').fadeIn();     
            setTimeout(function() { //podemos usar la libreria de Toastr para los mensajes flash
                $("#resultados_ajax").fadeOut();           
            },3000);
    
            limpiar();
        }
    });
}  















// =============================================================================
                    // //EDITAR ESTADO DEL CLIENTE
// =============================================================================

function cambiarEstado(id_cliente,est)
{      
    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result)
    {
        if(result)
        {
            $.ajax(
            {
                url:"../ajax/cliente.ajax.php?op=activarydesactivar",
                method:"POST",
                // headers: {'X-CSRF-TOKEN': token},
                //toma el valor del id y del estado
                data:{id_cliente:id_cliente, est:est},
                
                success: function(data)
                {
                    $('#cliente_data').DataTable().ajax.reload();
                }
            });
        }
    });//bootbox
} 
















    // =========================================================================
                            // //LISTAR EN VENTAS
    // =========================================================================
    function listar_en_ventas()
    {
        tabla_en_ventas=$('#lista_clientes_data').dataTable(
        {
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
                        url: '../ajax/cliente.ajax.php?op=listar_en_ventas',
                        type : "get",
                        dataType : "json",						
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
    
    



















    // =========================================================================
            // //AUTOCOMPLETAR O LISTAR DATOS DEL CLIENTE EN VENTAS
    // =========================================================================
    function agregar_registro(id_cliente,est)
    {

        $.ajax({
            url:"../ajax/cliente.ajax.php?op=buscar_cliente",
            method:"POST",
            data:{id_cliente:id_cliente,est:est},
            dataType:"json",
            success:function(data)
            {
                /*si el cliente esta activo entonces se ejecuta, de lo contrario 
                el formulario no se envia y aparecerá un mensaje */
                if(data.estado)
                {

                    $('#modalCliente').modal('hide');
                    $('#cedula').val(data.cedula_cliente);
                    $('#nombre').val(data.nombre);
                    $('#apellido').val(data.apellido);
                    $('#direccion').val(data.direccion);
                    $('#id_cliente').val(id_cliente);

                } 
                else
                {
                    bootbox.alert(data.error);
                }   //cierre condicional error
            }
        })
        
    }