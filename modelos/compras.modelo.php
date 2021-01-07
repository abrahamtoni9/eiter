<?php

    require_once("../config/conexion.php");

    class Compras extends Conectar
    {
        public function numero_compra()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql="select numero_compra from detalle_compras;";

            $sql=$conectar->prepare($sql);

            $sql->execute();
            $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($resultado as $k=>$v)
            {
                $numero_compra["numero"]=$v["numero_compra"];
            }
            
            if(empty($numero_compra["numero"]))
            {
                echo 'F000001';
            }
            else
            {
                $num     = substr($numero_compra["numero"] , 1);
                $dig     = $num + 1;
                $fact = str_pad($dig, 6, "0", STR_PAD_LEFT);
                echo 'F'.$fact;
            } 
        } 
        
        






        // =====================================================================
                            // METODO PARA AGREGAR LA COMPRA
        // =====================================================================
        public function agrega_detalle_compra()
        {
            //echo json_encode($_POST['arrayCompra']);
            $str = '';
            $detalles = array();
            $detalles = json_decode($_POST['arrayCompra']);

            $conectar=parent::conexion();
            parent::set_names();

            // =============================================================
                        // RECORREMOS EL DETALLE DE COMPRAS
            // =============================================================
            foreach ($detalles as $k => $v) 
            {
                // =============================================================
                    // RECUPERAMOS LOS DATOS DEL DETALLE DE COMPRAS
                // =============================================================
                $cantidad = $v->cantidad;
                $codProd = $v->codProd;
                $codCat = $v->codCat;
                $producto = $v->producto;
                $moneda = $v->moneda;
                $precio = $v->precio; 
                $dscto = $v->dscto;
                $importe = $v->importe;
                //$total = $v->total;
                $estado = $v->estado;

                // =============================================================
                    // RECUPERAMOS LOS DATOS DE LA CABECERA DE COMPRAS
                // =============================================================
        
                $numero_compra = $_POST["numero_compra"];
                $cedula_proveedor = $_POST["cedula"];
                $proveedor = $_POST["razon"];
                $direccion = $_POST["direccion"];
                $total = $_POST["total"];
                $comprador = $_POST["comprador"];
                $tipo_pago = $_POST["tipo_pago"];
                $id_usuario = $_POST["id_usuario"];
                $id_proveedor = $_POST["id_proveedor"];   
                /*IMPORTANTE: no me imprimia porque tenia estas variables que no usaba*/

                //$subtotal_compra = $_POST["subtotal_compra"];
                //$total_compra = $_POST["total_compra"];

                /*$sql="insert into detalle_compra
                values(null,'".$numero_compra."','".$producto."','".$precio."','".$cantidad."','".$dscto."','".$cedula_proveedor."','".$fecha_compra."','".$estado."');";

                echo $sql;*/

                //fecha 

                //$fecha_compra= date("d/m/Y");

                //estado 
                //si estado es igual a 1 entonces la compra esta pagada
                //$estado = 1;

                // =============================================================
                    // INSERTAMOS LOS REGISTROS EN EL DETALLE DE COMPRAS
                // =============================================================
        
                $sql="INSERT INTO detalle_compras
                VALUES(NULL,?,?,?,?,?,?,?,?,?,NOW(),?,?,?,?);";
        
                $sql=$conectar->prepare($sql);
                /*importante:se ingresó el id_producto=$codProd ya que se necesita para relacionar las tablas compras con detalle_compras para cuando se vaya a hacer la consulta de la existencia del producto y del stock para cuando se elimine un detalle compra y se reintegre la cantidad de producto*/       
                $sql->bindValue(1,$numero_compra);
                $sql->bindValue(2,$cedula_proveedor);
                $sql->bindValue(3,$codProd);
                $sql->bindValue(4,$producto);
                $sql->bindValue(5,$moneda);
                $sql->bindValue(6,$precio);
                $sql->bindValue(7,$cantidad);
                $sql->bindValue(8,$dscto);
                $sql->bindValue(9,$importe);
                $sql->bindValue(10,$id_usuario);
                $sql->bindValue(11,$id_proveedor);
                $sql->bindValue(12,$estado);
                $sql->bindValue(13,$codCat);

                $sql->execute();  //print_r($_POST[]);

                //print_r($_POST);
                /*IMPORTANTE:esta linea $resultado=$sql->fetch(PDO::ASSOC); debe comentarse sino se insertaria una sola fila

                Esta linea "$resultado=$sql->fetch(PDO::ASSOC);" se utliza cuando la consulta devuelva algún valor(osea si quieres imprimir un campo de la tabla de la bd) Pero la sentencia insert no deuelve nada
                Y esperar que devuelva despues del insert es un error en el codigo por eso es que solo ejecuta 1 producto y no el resto, por lo tanto se comenta dicha linea  */

            //$resultado=$sql->fetch(PDO::ASSOC);


                /*$sql2="insert into compras 
                values(null,'".$fecha_compra."','".$numero_compra."','".$proveedor."','".$cedula_proveedor."','".$total."');";*/
            

                //si existe el producto entonces actualiza la cantidad, en caso contrario no lo inserta

                // =============================================================
                        // RECUPERAMOS EL STOCK ACTUAL DE CADA PRODUCTO
                // =============================================================
        
                $sql3="SELECT * FROM producto WHERE id_producto=?;";
                
                $sql3=$conectar->prepare($sql3);

                $sql3->bindValue(1,$codProd);
                $sql3->execute();

                $resultado = $sql3->fetchAll(PDO::FETCH_ASSOC);
        
                foreach($resultado as $b=>$row)
                {
                    $re["existencia"] = $row["stock"];//captura el stock del producto
                }
        
                $cantidad_total = $cantidad + $row["stock"];


                // =============================================================
                            // ACTUALIZAMOS EL STOCK DEL PRODUCTO
                // =============================================================
        
                if(is_array($resultado)==true and count($resultado)>0) 
                {    
                    $sql4 = "UPDATE producto SET stock=? WHERE id_producto=?";

                    $sql4 = $conectar->prepare($sql4);
                    $sql4->bindValue(1,$cantidad_total);
                    $sql4->bindValue(2,$codProd);
                    $sql4->execute();

                } //cierre la condicional
                
            }//cierre del foreach

            /*IMPORTANTE: hice el procedimiento de imprimir la consulta y me di cuenta a traves del mensaje alerta que la variable total no estaba definida y tube que agregarla en el arreglo y funcionó*/

            //SUMO EL TOTAL DE IMPORTE SEGUN EL CODIGO DE DETALLES DE COMPRA


            // ====================================================================
                // SUMO EL TOTAL DE IMPORTE SEGUN EL CODIGO DE DETALLES DE COMPRA
            // ====================================================================

            $sql5="SELECT SUM(importe) AS total FROM detalle_compras WHERE numero_compra=?";

            $sql5=$conectar->prepare($sql5);

            $sql5->bindValue(1,$numero_compra);

            $sql5->execute();

            $resultado2 = $sql5->fetchAll();

            foreach($resultado2 as $c=>$d)
            {
                $row["total"]=$d["total"];
            }

            $subtotal=$d["total"];

            // =================================================================
                            // REALIZO EL CALCULO A REGISTRAR
            // =================================================================
            
            $iva= 20/100;
            $total_iv=$subtotal*$iva;
            $total_iva=round($total_iv);
            $tot=$subtotal+$total_iva;
            $total=round($tot);	

            //IMPORTANTE: hay que sacar la consulta INSERT INTO COMPRAS fuera del foreach sino se repetiria el registro en la tabla compras

            //fecha 
            
            //estado 
            //si estado es igual a 1 entonces la compra esta pagada
            //$estado = 1;


            //la fecha no se puede formatear por es un objeto date, solo se formatea en el select, cuando se va a obtener una fecha, por lo tanto la fecha queda en el formato y/m/d en la tabla de la bd	

            // =================================================================
                            // INSERTAMOS EN LA CABECERA DE COMPRAS
            // =================================================================
        
            $sql2="INSERT INTO compras VALUES(NULL,NOW(),?,?,?,?,?,?,?,?,?,?,?,?);";

            $sql2=$conectar->prepare($sql2);
        
            $sql2->bindValue(1,$numero_compra);
            $sql2->bindValue(2,$proveedor);
            $sql2->bindValue(3,$cedula_proveedor);
            $sql2->bindValue(4,$comprador);
            $sql2->bindValue(5,$moneda);
            $sql2->bindValue(6,$subtotal);
            $sql2->bindValue(7,$total_iva);
            $sql2->bindValue(8,$total);
            $sql2->bindValue(9,$tipo_pago);
            $sql2->bindValue(10,$estado);
            $sql2->bindValue(11,$id_usuario);
            $sql2->bindValue(12,$id_proveedor);
            
            $sql2->execute();
        }











        // =====================================================================
                            // SELECCIONAR COMPRAS
        // =====================================================================
        public function get_compras()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM compras";

            $sql=$conectar->prepare($sql);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }















        // =====================================================================
        // RECUPERAR DATOS DE LA CABECERA DE COMPRA
        // =====================================================================
        public function get_detalle_proveedor($numero_compra)
        {

            $conectar=parent::conexion();
            parent::set_names();

            $sql="SELECT c.fecha_compra,c.numero_compra, c.proveedor, c.cedula_proveedor,c.total, p.id_proveedor, p.cedula, p.razon_social, p.telefono, p.correo, p.direccion, p.fecha, p.estado
            FROM 
                compras AS c, proveedor AS p
            WHERE 
                c.cedula_proveedor=p.cedula
            AND
                c.numero_compra=?;";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1,$numero_compra);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }
























        // =====================================================================
                // RECUPERAR EL DETALLE EN UNA COMPRA
        // =====================================================================

        public function get_detalle_compras_proveedor($numero_compra)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql="SELECT d.numero_compra,d.cedula_proveedor,d.producto, d.moneda, d.precio_compra,d.cantidad_compra,d.descuento,d.importe, d.fecha_compra,c.numero_compra, c.moneda, c.subtotal, c.total_iva,c.total,p.id_proveedor,p.cedula,p.razon_social,p.telefono,p.correo,p.direccion,p.fecha,p.estado
            FROM 
                detalle_compras AS d, compras AS c, proveedor AS p
            WHERE 
                d.numero_compra=c.numero_compra
            AND 
                d.cedula_proveedor=p.cedula
            AND
                d.numero_compra=?;";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1,$numero_compra);
            $sql->execute();
            $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);

            $html= "<thead style='background-color:#A9D0F5'>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio Compra</th>
                        <th>Descuento (%)</th>
                        <th>Importe</th>
                    </thead>";

            foreach($resultado as $row)
            { 
                $html.="<tr class='filas'>
                            <td>".$row['cantidad_compra']."</td>
                            <td>".$row['producto']."</td>
                            <td>".$row["moneda"]." ".$row['precio_compra']."</td>
                            <td>".$row['descuento']."</td> 
                            <td>".$row["moneda"]." ".$row['importe']."</td>
                        </tr>";
                            
                $subtotal= $row["moneda"]." ".$row["subtotal"];
                $subtotal_iva= $row["moneda"]." ".$row["total_iva"];
                $total= $row["moneda"]." ".$row["total"];
            }

            $html .=    "<tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <p>SUB-TOTAL</p>
                                <p>IVA(20%)</p>
                                <p class='margen_total'>TOTAL</p>
                            </th>
                            <th>
                                <p><strong>".$subtotal."</strong></p>
                                <p><strong>".$subtotal_iva."</strong></p>
                                <p><strong>".$total."</strong></p>
                            </th> 
                        </tfoot>";
    
            echo $html;

        }
























    // =====================================================================
            // RECUPERAR LA COMPRA POR ID
    // =====================================================================

    public function get_compras_por_id($id_compras){

        $conectar= parent::conexion();

        $sql="SELECT * FROM compras WHERE id_compras=?";
        
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$id_compras);
        $sql->execute();

        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    }


























        // ======================================================================================================================================================
                //CAMBIAR EL ESTADO DE LA COMPRA, SOLO SI SE CAMBIA SI SE QUIERE ELMINAR UNA COMPRA Y REVERTIRIA LA CANTIDAD DE COMPRA AL STOCK
        // =======================================================================================================================================================

        public function cambiar_estado($id_compras, $numero_compra, $est)
        {
            $conectar=parent::conexion();
            parent::set_names();

            //si estado es igual a 0 entonces lo cambia a 1
            $estado = 0;
            
            /*si el estado es ==0 cambiaria a PAGADO Y SE EJECUTARIA TODO LO QUE ESTA ABAJO*/
            if($_POST["est"] == 0)
            {
                $estado = 1;
            
                $numero_compra=$_POST["numero_compra"];
            
                $sql="UPDATE compras SET estado=? WHERE id_compras=?";
            
                $sql=$conectar->prepare($sql);
    
                $sql->bindValue(1,$estado);
                $sql->bindValue(2,$_POST["id_compras"]);
                $sql->execute();
    
                $resultado= $sql->fetch(PDO::FETCH_ASSOC);
            
                $sql_detalle= "UPDATE detalle_compras SET estado=? WHERE numero_compra=?";
            
                $sql_detalle=$conectar->prepare($sql_detalle);
    
                $sql_detalle->bindValue(1,$estado);
                $sql_detalle->bindValue(2,$numero_compra);
                $sql_detalle->execute();
    
                $resultado= $sql_detalle->fetch(PDO::FETCH_ASSOC);    
    
                // =============================================================
                // //INICIO CONSULTA DE DETALLE DE COMPRAS Y COMPRAS
                // =============================================================
            
                $sql2="SELECT * FROM detalle_compras WHERE numero_compra=?";
            
                $sql2=$conectar->prepare($sql2);
            
                $sql2->bindValue(1,$numero_compra);
                $sql2->execute();
            
                $resultado=$sql2->fetchAll();

                foreach($resultado as $row)
                {
                    $id_producto=$output["id_producto"]=$row["id_producto"];
                    //selecciona la cantidad comprada
                    $cantidad_compra=$output["cantidad_compra"]=$row["cantidad_compra"];

                    //si el id_producto existe entonces que consulte si la cantidad de productos existe en la tabla producto
                    if(isset($id_producto) == true and count($id_producto) > 0)
                    {
                        $sql3="SELECT * FROM producto WHERE id_producto=?";

                        $sql3=$conectar->prepare($sql3);

                        $sql3->bindValue(1, $id_producto);
                        $sql3->execute();

                        $resultado=$sql3->fetchAll();

                        foreach($resultado as $row2)
                        {
                            //este es la cantidad de stock para cada producto
                            $stock=$output2["stock"]=$row2["stock"];
                            
                            //esta debe estar dentro del foreach para que recorra el $stock de los productos, ya que es mas de un producto que está asociado a la compra
                            //cuando das click a estado pasa a PAGADO Y SUMA la cantidad de stock con la cantidad de compra
                            $cantidad_actual= $stock + $cantidad_compra;
                        }
                    }
            
                    //LE ACTUALIZO LA CANTIDAD DEL PRODUCTO 
                    $sql6="UPDATE producto SET stock=? WHERE id_producto=?";
                    
                    $sql6=$conectar->prepare($sql6);   
                    
                    $sql6->bindValue(1,$cantidad_actual);
                    $sql6->bindValue(2,$id_producto);
    
                    $sql6->execute();

                }//cierre del foreach
    
            }//cierre del if del estado
            else 
            {
                /*si el estado es igual a 1, entonces pasaria a ANULADO y restaria la cantidad de productos al stock*/
                if($_POST["est"] == 1)
                {
                    $estado = 0;
                
                    //declaro $numero_compra, viene via ajax
                    $numero_compra=$_POST["numero_compra"];
                
                    $sql="UPDATE compras SET estado=? WHERE id_compras=?"; 
                
                    $sql=$conectar->prepare($sql);
        
                    $sql->bindValue(1,$estado);
                    $sql->bindValue(2,$_POST["id_compras"]);
                    $sql->execute();
        
                    $resultado= $sql->fetch(PDO::FETCH_ASSOC);
                
                    $sql_detalle= "UPDATE detalle_compras SET estado=? WHERE numero_compra=?";
                
                    $sql_detalle=$conectar->prepare($sql_detalle);
        
                    $sql_detalle->bindValue(1,$estado);
                    $sql_detalle->bindValue(2,$numero_compra);
                    $sql_detalle->execute();
        
                    $resultado= $sql_detalle->fetch(PDO::FETCH_ASSOC);
                
                    /*una vez se cambie de estado a ACTIVO entonces actualizamos la cantidad de stock en productos*/
                    //INICIO ACTUALIZAR LA CANTIDAD DE PRODUCTOS COMPRADOS EN EL STOCK
                    $sql2="SELECT * FROM detalle_compras WHERE numero_compra=?";

                    $sql2=$conectar->prepare($sql2);

                    $sql2->bindValue(1,$numero_compra);
                    $sql2->execute();

                    $resultado=$sql2->fetchAll();
            
                    foreach($resultado as $row)
                    {
                        $id_producto=$output["id_producto"]=$row["id_producto"];
                        //selecciona la cantidad comprada
                        $cantidad_compra=$output["cantidad_compra"]=$row["cantidad_compra"];
                
                        //si el id_producto existe entonces que consulte si la cantidad de productos existe en la tabla producto
                        if(isset($id_producto)==true and count($id_producto)>0)
                        {
                            $sql3="SELECT * FROM producto WHERE id_producto=?";
        
                            $sql3=$conectar->prepare($sql3);
        
                            $sql3->bindValue(1, $id_producto);
                            $sql3->execute();
        
                            $resultado=$sql3->fetchAll();
        
                            foreach($resultado as $row2)
                            {     
                                //este es la cantidad de stock para cada producto
                                $stock=$output2["stock"]=$row2["stock"];
                                
                                //esta debe estar dentro del foreach para que recorra el $stock de los productos, ya que es mas de un producto que está asociado a la compra
                                //cuando le da click al estado pasa de PAGADO A ANULADO y resta la cantidad de stock en productos con la cantidad de compra de detalle_compras, disminuyendo de esta manera la cantidad actual de productos en el stock de productos
                                $cantidad_actual= $stock - $cantidad_compra;
                            }
                        }
            
                        //LE ACTUALIZO LA CANTIDAD DEL PRODUCTO 
                        $sql6="UPDATE producto SET stock=? WHERE id_producto=?";
                        
                        $sql6=$conectar->prepare($sql6);   
                        
                        $sql6->bindValue(1,$cantidad_actual);
                        $sql6->bindValue(2,$id_producto);
        
                        $sql6->execute();
            
                    }//cierre del foreach

                }//cierre del if del estado del else
            
            }

        }//CIERRE DEL METODO
            
            



































            
    // =========================================================================
                        // //BUSCA REGISTROS COMPRAS-FECHA
    // =========================================================================

    public function lista_busca_registros_fecha($fecha_inicial, $fecha_final)
    {
        $conectar= parent::conexion();

        $date_inicial = $_POST["fecha_inicial"];
        $date = str_replace('/', '-', $date_inicial);
        $fecha_inicial = date("Y-m-d", strtotime($date));

        $date_final = $_POST["fecha_final"];
        $date = str_replace('/', '-', $date_final);
        $fecha_final = date("Y-m-d", strtotime($date));

        $sql= "SELECT * FROM compras WHERE fecha_compra>=? and fecha_compra<=? ";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$fecha_inicial);
        $sql->bindValue(2,$fecha_final);
        $sql->execute();
        
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    }


























    // =========================================================================
                    // //BUSCA REGISTROS COMPRAS-FECHA-MES
    // =========================================================================

    public function lista_busca_registros_fecha_mes($mes, $ano)
    {
        $conectar= parent::conexion();
        $mes=$_POST["mes"];
        $ano=$_POST["ano"];
        
        $fecha= ($ano."-".$mes."%");

        //la consulta debe hacerse asi para seleccionar el mes/ano
        /*importante: explicacion de cuando se pone el like y % en una consulta: like sirve para buscar una palabra en especifica dentro de la columna, por ejemplo buscar 09 dentro de 2017-09-04. Los %% se ocupan para indicar en que parte se quiere buscar, si se pone like '%queBusco' significa que lo buscas al final de una cadena, si pones 'queBusco%' significa que se busca al principio de la cadena y si pones '%queBusco%' significa que lo busca en medio, asi la imprimo la consulta en phpmyadmin SELECT * FROM compras WHERE fecha_compra like '2017-09%'*/
        $sql= "SELECT * FROM compras WHERE fecha_compra LIKE ? ";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$fecha);
        $sql->execute();
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    }
}




?>

