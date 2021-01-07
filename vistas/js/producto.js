var tabla_en_ventas;
var tabla_en_compras;
var tabla;

init();

function init()
{
    listar();

    listar_en_compras();

    listar_en_ventas();

      //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
	$("#producto_form").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	 //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function()
    {		
		$(".modal-title").text("Agregar producto");	
	});
}

function limpiar()
{
    $("#id_producto").val("");
	//$("#id_usuario").val("");//no lo vamos a borrar osino no se registra
    $("#categoria").val("");
	$('#producto').val("");
    $('#presentacion').val("");
    $('#unidad').val("");
    $('#moneda').val("");
    $('#precio_compra').val("");
	$('#precio_venta').val("");
	$('#stock').val("");
	$('#estado').val("");
	$('#datepicker').val("");
	$('#producto_imagen').val("");
}



function listar()
{
    tabla=$('#producto_data').dataTable(
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
            url: '../ajax/producto.ajax.php?op=listar',
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
    // //MOSTRAR DATOS DEL PRODUCTO EN LA VENTANA MODAL DEL FORMULARIO
 // ============================================================================

function mostrar(id_producto)
{
    $.post("../ajax/producto.ajax.php?op=mostrar",{id_producto : id_producto}, function(data, status)   
    { 
        console.log(data);
        data = JSON.parse(data);

        $('#productoModal').modal('show');
        $('#categoria').val(data.categoria);
        $('#producto').val(data.producto);
        $('#presentacion').val(data.presentacion);
        $('#unidad').val(data.unidad);
        $('#moneda').val(data.moneda);
        $('#precio_compra').val(data.precio_compra);
        $('#precio_venta').val(data.precio_venta);
        $('#stock').val(data.stock);
        $('#estado').val(data.estado);
        $('#datepicker').val(data.fecha_vencimiento);
        $('#id_producto').val(id_producto);
        $('#producto_uploaded_image').html(data.producto_imagen);
        $('#resultados_ajax').html(data);
        $('.modal-title').text("Editar Producto");
        $("#producto_data").DataTable().ajax.reload();
    });
}














// =============================================================================
// //LA FUNCION guardaryeditar(e); SE LLAMA CUANDO SE DA CLICK AL BOTON SUBMIT
// =============================================================================

function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#producto_form")[0]);

    $.ajax(
    {
        url: "../ajax/producto.ajax.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            console.log(datos);

            $('#producto_form')[0].reset();
            $('#productoModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#producto_data').DataTable().ajax.reload();
    
            limpiar();
        }
    });
}  















// =============================================================================
                    // //EDITAR ESTADO DEL PRODUCTO
// =============================================================================
function cambiarEstado(id_categoria, id_producto,est)
{      
    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result)
    {
        if(result)
        {
            $.ajax(
            {
                url:"../ajax/producto.ajax.php?op=activarydesactivar",
                method:"POST",
                
                //toma el valor del id y del estado
                data:{id_categoria:id_categoria, id_producto:id_producto, est:est},
                
                success: function(data)
                {
                    $('#producto_data').DataTable().ajax.reload();
                }
            });
        }
    });//bootbox
} 

















// ===============================================================================
            // MOSTRAR DATOS DEL PRODUCTO EN LA VENTANA MODAL DE COMPRAS
// ===============================================================================
function listar_en_compras()
{
	tabla_en_compras=$('#lista_productos_data').dataTable(
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
					url: '../ajax/producto.ajax.php?op=listar_en_compras',
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















// ===============================================================================
                        // AGREGAR PRODUCTO EN EL DETALLE
// ===============================================================================

var detalles = [];

function agregarDetalle(id_producto,producto, estado)
{
    $.ajax({
        url:"../ajax/producto.ajax.php?op=buscar_producto",
        method:"POST",
        data:{id_producto:id_producto, producto:producto, estado:estado},
        cache: false,
        dataType:"json",
        success:function(data)
        {
            if(data.id_producto)
            {
                if (typeof data == "string")
                {
                    data = $.parseJSON(data);
                }
                // console.log(data);
            
                var obj = 
                {
                    cantidad : 1,
                    codProd  : id_producto,
                    codCat   : data.id_categoria,
                    producto : data.producto,
                    moneda   : data.moneda,
                    precio   : data.precio_compra,
                    stock    : data.stock,
                    dscto    : 0,
                    importe  : 0,
                    estado   : data.estado
                };                
                
                // console.log(codigoProducto);
                // console.log(detalles);
                // console.log(detalles.length);
                codigoProducto = obj.codProd;
                
                if(detalles.length == 0)
                {
                    detalles.push(obj);
                    listarDetalles();
                }
                else
                {
                    for (let index = 0; index < detalles.length; index++) 
                    {
                        const element = detalles[index]['codProd'];
                        // console.log(element);
                        if (codigoProducto == element) 
                        {
                            // detalles.pop();//elimina el ultimo indice 
                            console.log("valor duplicado");
                            // console.log(detalles);
                            bootbox.alert("El producto ya existe en el detalle");
                            return;
                        }
                    }
                    detalles.push(obj);
                    listarDetalles();
                    // console.log(detalles[0]['codProd']);
                }
                

                $('#lista_productosModal').modal("hide");
            }//if validacion id_producto
            else 
            {
                //si el producto está inactivo entonces se muestra una ventana modal
                bootbox.alert(data.error);
            }
        }//fin success		
    });//fin de ajax
}// fin de funcion


//***********************************************************************



















// ===============================================================================
                        // ESTRUCTURA HTML EN EL DETALLE
// ===============================================================================

function listarDetalles()
{
    $('#listProdCompras').html('');
    var filas = "";
    var subtotal = 0;
    var total = 0;
    var subtotalFinal = 0;
    var totalFinal = 0;
    var iva = 20;
    var igv = (iva/100);

    for(var i=0; i<detalles.length; i++)
    {
        if( detalles[i].estado == 1 )
        {
            var importe = detalles[i].importe = detalles[i].cantidad * detalles[i].precio;

            importe = detalles[i].importe = detalles[i].importe - (detalles[i].importe * detalles[i].dscto/100);
            var filas = filas + "<tr><td>"+(i+1)+"</td> <td name='producto[]'>"+detalles[i].producto+"</td> <td name='precio[]' id='precio[]'>"+detalles[i].moneda+" "+detalles[i].precio+"</td> <td>"+detalles[i].stock+"</td> <td><input type='number' class='cantidad input-group-sm' name='cantidad[]' id='cantidad[]' onClick='setCantidad(event, this, "+(i)+");' onKeyUp='setCantidad(event, this, "+(i)+");' value='"+detalles[i].cantidad+"'></td>  <td><input type='number' name='descuento[]' id='descuento[]' onClick='setDescuento(event, this, "+(i)+");' onKeyUp='setDescuento(event, this, "+(i)+");' value='"+detalles[i].dscto+"'></td> <td> <span name='importe[]' id='importe"+i+"'>"+detalles[i].moneda+" "+detalles[i].importe+"</span> </td> <td>  <button href='#' class='btn btn-danger btn-lg' role='button' onClick='eliminarProd(event, "+(i)+");' aria-pressed='true'><span class='glyphicon glyphicon-trash'></span> </button></td> </tr>";
            subtotal = subtotal + importe;

            //concatenar para poner la moneda con el subtotal
            subtotalFinal = detalles[i].moneda+" "+subtotal;

            var su = subtotal*igv;
            var or=parseFloat(su);
            var total= Math.round(or+subtotal);

            //concatenar para poner la moneda con el total
            totalFinal = detalles[i].moneda+" "+total;
        }
    }

    $('#listProdCompras').html(filas);

    //subtotal
    $('#subtotal').html(subtotalFinal);
    $('#subtotal_compra').html(subtotalFinal);

    //total
    $('#total').html(totalFinal);
    $('#total_compra').html(totalFinal);

}











// ===============================================================================
                        // CALCULAR CANTIDAD
// ===============================================================================
function setCantidad(event, obj, idx)
{
    event.preventDefault();
    detalles[idx].cantidad = parseInt(obj.value);
    recalcular(idx);
}














// ===============================================================================
                        // CALCULAR DESCUENTO
// ===============================================================================
function setDescuento(event, obj, idx)
{
    event.preventDefault();
    detalles[idx].dscto = parseFloat(obj.value);
    recalcular(idx);
}













// ===============================================================================
                        // RECALCULAR TOTALES
// ===============================================================================
function recalcular(idx)
{
    //alert('holaaa:::' + obj.value);
    //var asd = document.getElementById('cantidad');
    //console.log(detalles[idx].cantidad);
    //detalles[idx].cantidad = parseInt(obj.value);
    console.log(detalles[idx].cantidad);
    console.log((detalles[idx].cantidad * detalles[idx].precio));
    //var objImp = 'importe'+idx;
    //console.log(objImp);

    var importe =detalles[idx].importe = detalles[idx].cantidad * detalles[idx].precio;
    importe = detalles[idx].importe = detalles[idx].importe - (detalles[idx].importe * detalles[idx].dscto/100);

    importeFinal = detalles[idx].moneda+" "+importe;

    $('#importe'+idx).html(importeFinal);
    calcularTotales();
}






// ===============================================================================
                        // CALCULAR TOTALES
// ===============================================================================
function calcularTotales()
{
    var subtotal = 0;
    var total = 0;
    var subtotalFinal = 0;
    var totalFinal = 0;
    var iva = 20;
    var igv = (iva/100);

    for(var i=0; i<detalles.length; i++)
    {
        if(detalles[i].estado == 1)
        {
            subtotal = subtotal + (detalles[i].cantidad * detalles[i].precio) - (detalles[i].cantidad*detalles[i].precio*detalles[i].dscto/100);
            
            //concatenar para poner la moneda con el subtotal
            subtotalFinal = detalles[i].moneda+" "+subtotal;

            var su = subtotal*igv;
            var or=parseFloat(su);
            var total = Math.round(or+subtotal);

            //concatenar para poner la moneda con el total
            totalFinal = detalles[i].moneda+" "+total;
        }
    }

    //subtotal
    $('#subtotal').html(subtotalFinal);
    $('#subtotal_compra').html(subtotalFinal);

    //total
    $('#total').html(totalFinal);
    $('#total_compra').html(totalFinal);
}













// ===============================================================================
                        // ELIMINAR PRODUCTO DEL DETALLE
// ===============================================================================
function  eliminarProd(event, idx)
{
    event.preventDefault();
    //console.log('ELIMINAR EYTER');
    detalles[idx].estado = 0;
    detalles.splice(idx, 1);//removemos el indice del objeto
    listarDetalles();
}

//********************************************************************


















// ===============================================================================
                        // REGISTRAR COMPRAS
// ===============================================================================
function registrarCompra()
{
    var numero_compra = $("#numero_compra").val();
    var cedula = $("#cedula").val();
    var razon = $("#razon").val();
    var direccion = $("#direccion").val();
    var total = $("#total").html();
    var comprador = $("#comprador").html();
    var tipo_pago = $("#tipo_pago").val();
    var id_usuario = $("#id_usuario").val();
    var id_proveedor = $("#id_proveedor").val();

    if(cedula!="" && razon!="" && direccion!="" && tipo_pago!="" && detalles!="")
    {
        $.ajax({
            url:"../ajax/producto.ajax.php?op=registrar_compra",
            method:"POST",
            data:{'arrayCompra':JSON.stringify(detalles), 'numero_compra':numero_compra,'cedula':cedula,'razon':razon,'direccion':direccion,'total':total,'comprador':comprador,'tipo_pago':tipo_pago,'id_usuario':id_usuario,'id_proveedor':id_proveedor},
            cache: false,
            dataType:"html",
                
            success:function(data)
            {
                // if (typeof data == "string"){
                //     data = $.parseJSON(data);
                // }
                console.log(data);
            
                var cedula = $("#cedula").val("");
                var razon = $("#razon").val("");
                var direccion = $("#direccion").val("");
                var subtotal = $("#subtotal").html("");
                var total = $("#total").html("");
            
                detalles = []; //inicializamos a valor vacio
                $('#listProdCompras').html('');//limpiamos el detalle

                setTimeout("bootbox.alert('Se ha registrado la compra con éxito');", 100); 

                setTimeout ("explode();", 2000); 
            },
            error:function(x,y,z)
            {
                console.log(x);
                console.log(y);
                console.log(z);
            }
        });	
    } 
    else
    {
        bootbox.alert("Debe agregar un producto, los campos del proveedor y el tipo de pago");
        return false;
    } 	
	
}


















// =========================================================================
            // RESFRESCA LA PAGINA DESPUES DE REGISTRAR LA COMPRA
// =========================================================================
function explode()
{
    location.reload();//recarga la pagina
}





















// ===============================================================================
            // MOSTRAR DATOS DEL PRODUCTO EN LA VENTANA MODAL DE VEWTAS
// ===============================================================================
function listar_en_ventas()
{
	tabla_en_compras=$('#lista_productos_ventas_data').dataTable(
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
					url: '../ajax/producto.ajax.php?op=listar_en_ventas',
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

















