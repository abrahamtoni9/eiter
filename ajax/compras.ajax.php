<?php

    require_once("../config/conexion.php");

    require_once("../modelos/compras.modelo.php");

    $compras = new Compras();
    
    switch($_GET["op"])
    {
        case "buscar_compras":

            $datos=$compras->get_compras();
            // var_dump($datos);die();

            //Vamos a declarar un array
            $data= Array();

            foreach($datos as $row)
            {
                $sub_array = array();

                $est = '';

                $atrib = "btn btn-danger btn-md estado";
                if($row["estado"] == 1)
                {
                    $est = 'PAGADO';
                    $atrib = "btn btn-success btn-md estado";
                }
                else
                {
                    if($row["estado"] == 0)
                    {
                        $est = 'ANULADO';
                        
                    }	
                }

                $sub_array[] = '<button class="btn btn-warning detalle"  id="'.$row["numero_compra"].'"  data-toggle="modal" data-target="#detalle_compra"><i class="fa fa-eye"></i></button>';
                $sub_array[] = date("d-m-Y", strtotime($row["fecha_compra"]));
                $sub_array[] = $row["numero_compra"];
                $sub_array[] = $row["proveedor"];
                $sub_array[] = $row["cedula_proveedor"];
                $sub_array[] = $row["comprador"];
                $sub_array[] = $row["tipo_pago"];
                $sub_array[] = $row["moneda"]." ".$row["total"];


                /*IMPORTANTE: poner \' cuando no sea numero, sino no imprime*/
                $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_compras"].',\''.$row["numero_compra"].'\','.$row["estado"].');" name="estado" id="'.$row["id_compras"].'" class="'.$atrib.'">'.$est.'</button>';

                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1, //InformaciÃ³n para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);

            // $registros = json_encode($results);
            // var_dump($registros);
            echo json_encode($results);

        break;


        case "ver_detalle_proveedor_compra":

            $datos= $compras->get_detalle_proveedor($_POST["numero_compra"]);	

            if(is_array($datos)==true and count($datos)>0)
            {
                foreach($datos as $row)
                { 
                    $output["proveedor"] = $row["proveedor"];
                    $output["numero_compra"] = $row["numero_compra"];
                    $output["cedula_proveedor"] = $row["cedula_proveedor"];
                    $output["direccion"] = $row["direccion"];
                    $output["fecha_compra"] = date("d-m-Y", strtotime($row["fecha_compra"]));
                }

                echo json_encode($output);

            } 
            else 
            {
                $errors[]="no existe";
            }

            if (isset($errors))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> 
                        <?php
                            foreach ($errors as $error) 
                            {
                                echo $error;
                            }
                        ?>
                </div>
                <?php
            }  

        break;


        case "ver_detalle_compra":

            $datos= $compras->get_detalle_compras_proveedor($_POST["numero_compra"]);	

        break;


        case "cambiar_estado_compra":

            $datos=$compras->get_compras_por_id($_POST["id_compras"]);

            if(is_array($datos)==true and count($datos)>0)
            {
                    $compras->cambiar_estado($_POST["id_compras"], $_POST["numero_compra"], $_POST["est"]);
            } 

        break;

        case "buscar_compras_fecha":

            $datos=$compras->lista_busca_registros_fecha($_POST["fecha_inicial"], $_POST["fecha_final"]);

            //Vamos a declarar un array
            $data= Array();

            foreach($datos as $row)
            {
                $sub_array = array();

                $est = '';
            
                $atrib = "btn btn-danger btn-md estado";
                if($row["estado"] == 1)
                {
                    $est = 'PAGADO';
                    $atrib = "btn btn-success btn-md estado";
                }
                else
                {
                    if($row["estado"] == 0)
                    {
                        $est = 'ANULADO';    
                    }	
                }

                $sub_array[] = '<button class="btn btn-warning detalle" id="'.$row["numero_compra"].'"  data-toggle="modal" data-target="#detalle_compra"><i class="fa fa-eye"></i></button>';

                $sub_array[] = date("d-m-Y", strtotime($row["fecha_compra"]));
                $sub_array[] = $row["numero_compra"];
                $sub_array[] = $row["proveedor"];
                $sub_array[] = $row["cedula_proveedor"];
                $sub_array[] = $row["comprador"];
                $sub_array[] = $row["tipo_pago"];
                $sub_array[] = $row["moneda"]." ".$row["total"];

                /*IMPORTANTE: poner \' cuando no sea numero, sino no imprime*/
                $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_compras"].',\''.$row["numero_compra"].'\','.$row["estado"].');" name="estado" id="'.$row["id_compras"].'" class="'.$atrib.'">'.$est.'</button>';

                $data[] = $sub_array;
            }

            $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);

                echo json_encode($results);

        break;

        case "buscar_compras_fecha_mes":

            $datos= $compras->lista_busca_registros_fecha_mes($_POST["mes"],$_POST["ano"]);

            $data= Array();

            foreach($datos as $row)
            {
                $sub_array = array();

                $est = '';
                //$atrib = 'activo';
                $atrib = "btn btn-danger btn-md estado";
                if($row["estado"] == 1)
                {
                    $est = 'PAGADO';
                    $atrib = "btn btn-success btn-md estado";
                }
                else
                {
                    if($row["estado"] == 0)
                    {
                        $est = 'ANULADO';
                    }	
                }

                $sub_array[] = '<button class="btn btn-warning detalle" id="'.$row["numero_compra"].'"  data-toggle="modal" data-target="#detalle_compra"><i class="fa fa-eye"></i></button>';
                
                $sub_array[] = date("d-m-Y", strtotime($row["fecha_compra"]));
                $sub_array[] = $row["numero_compra"];
                $sub_array[] = $row["proveedor"];
                $sub_array[] = $row["cedula_proveedor"];
                $sub_array[] = $row["comprador"];
                $sub_array[] = $row["tipo_pago"];
                $sub_array[] = $row["moneda"]." ".$row["total"];

                /*IMPORTANTE: poner \' cuando no sea numero, sino no imprime*/
                $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_compras"].',\''.$row["numero_compra"].'\','.$row["estado"].');" name="estado" id="'.$row["id_compras"].'" class="'.$atrib.'">'.$est.'</button>';

                $data[] = $sub_array;
            }

            $results = array(
                   "sEcho"=>1, //Información para el datatables
                   "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                   "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);

            echo json_encode($results);

        break;

    }
