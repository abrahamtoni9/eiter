
var tabla_en_compras;
var tabla;

init();

function init()
{
    listar();

    listar_en_compras();

      //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
	$("#proveedor_form").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	 //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function()
    {		
		$(".modal-title").text("Agregar proveedor");	
	});
}

function limpiar()
{
    $('#cedula').val("");
	$('#razon').val("");
	$('#telefono').val("");
	$('#email').val("");
	$('#direccion').val("");
	$('#datepicker').val("");
	$('#estado').val("");
	$('#cedula_proveedor').val("");
}



function listar()
{
    tabla=$('#proveedor_data').dataTable(
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
            url: '../ajax/proveedor.ajax.php?op=listar',
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
    // //MOSTRAR DATOS DEL PROVEEDOR EN LA VENTANA MODAL DEL FORMULARIO
 // ============================================================================

function mostrar(cedula_proveedor)
{
    $.post("../ajax/proveedor.ajax.php?op=mostrar",{cedula_proveedor : cedula_proveedor}, function(data, status)   
    { 
        console.log(data);
        data = JSON.parse(data);

        $('#proveedorModal').modal('show');
        $('#cedula').val(cedula_proveedor);
        $('#razon').val(data.proveedor);
        $('#telefono').val(data.telefono);
        $('#email').val(data.correo);
        $('#direccion').val(data.direccion);
        $('#datepicker').val(data.fecha);
        $('#estado').val(data.estado);
        $('#cedula_proveedor').val(cedula_proveedor);
        $('.modal-title').text("Editar Proveedor");
    });
}














// =============================================================================
// //LA FUNCION guardaryeditar(e); SE LLAMA CUANDO SE DA CLICK AL BOTON SUBMIT
// =============================================================================

function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#proveedor_form")[0]);

    $.ajax(
    {
        url: "../ajax/proveedor.ajax.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            console.log(datos);

            $('#proveedor_form')[0].reset();
            $('#proveedorModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#proveedor_data').DataTable().ajax.reload();
    
            limpiar();
        }
    });
}  















// =============================================================================
                    // //EDITAR ESTADO DEL PROVEEDOR
// =============================================================================

//importante:id_usuario, est se envia por post via ajax
function cambiarEstado(id_proveedor,est)
{      
    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result)
    {
        if(result)
        {
            $.ajax(
            {
                url:"../ajax/proveedor.ajax.php?op=activarydesactivar",
                method:"POST",
                
                //toma el valor del id y del estado
                data:{id_proveedor:id_proveedor, est:est},
                
                success: function(data)
                {
                    $('#proveedor_data').DataTable().ajax.reload();
                }
            });
        }
    });//bootbox
} 



















// =============================================================================
                    // //LISTAR PROVEEDOR EN COMPRAS
// =============================================================================

function listar_en_compras(){

	tabla_en_compras=$('#lista_proveedores_data').dataTable(
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
					url: '../ajax/proveedor.ajax.php?op=listar_en_compras',
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





















// =============================================================================
                    // //BUSCAR PROVEEDOR
// =============================================================================

function agregar_registro(id_proveedor,est)
{
    $.ajax
    ({
        url:"../ajax/proveedor.ajax.php?op=buscar_proveedor",
        method:"POST",
        data:{id_proveedor:id_proveedor,est:est},
        dataType:"json",
        success:function(data)
        {
            if(data.estado)
            {
                $('#modalProveedor').modal('hide');
                $('#cedula').val(data.cedula);
                $('#razon').val(data.razon_social);
                $('#direccion').val(data.direccion);
                $('#datepicker').val(data.fecha);
                $('#id_proveedor').val(id_proveedor);
            } 
            else
            {    
                bootbox.alert(data.error);
            } //cierre condicional error
        }
    })
}
