<?php

    require_once("../config/conexion.php");

    require_once("../modelos/proveedores.modelo.php");

    $proveedores = new Proveedores();

    $id_usuario=isset($_POST["id_usuario"]);
    $cedula_proveedor=isset($_POST["cedula_proveedor"]);
    $cedula = isset($_POST["cedula"]);
    $proveedor=isset($_POST["razon"]);
    $telefono=isset($_POST["telefono"]);
    $correo=isset($_POST["email"]);
    $direccion=isset($_POST["direccion"]);
    $estado=isset($_POST["estado"]);


    switch($_GET["op"])
    {
        case "guardaryeditar":

            // var_dump($_POST);
            // die();

            $datos = $proveedores->get_datos_proveedor($_POST["cedula"], $_POST["razon"], $_POST["email"]);

            // var_dump($datos);
            // exit();

            if(empty($_POST["cedula_proveedor"]))
            {
                // var_dump($datos);
                // // exit();
                // die();
                if(is_array($datos)==true and count($datos) == 0)
                {
                    // var_dump($datos);
                    // exit();
                    $proveedores->registrar_proveedor($cedula,$proveedor,$telefono,$correo,$direccion,$estado,$id_usuario);

                    $messages[]="El proveedor se registró correctamente";
                } 
                else 
                {
                    $errors[]="El proveedor ya existe";
                }
            }
            else 
            {
                $proveedores->editar_proveedor($cedula,$proveedor,$telefono,$correo,$direccion,$estado,$id_usuario);

                $messages[]="El proveedor se editó correctamente";
            }

            if(isset($messages))
            {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>¡Bien hecho!</strong>
                    <?php
                        foreach($messages as $message) 
                        {
                                echo $message;
                        }
                    ?>
                </div>
                <?php
            }

            if(isset($errors))
            {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error!</strong> 
                            <?php
                                foreach($errors as $error)
                                {
                                        echo $error;
                                }
                            ?>
                    </div>
                <?php

            }

        break;

        case "mostrar":

            $datos = $proveedores->get_proveedor_por_cedula($_POST["cedula_proveedor"]);
            // var_dump($datos);

            if(is_array($datos) == true and count($datos) > 0)
            {
                foreach($datos as $row)
                {  
                    $output["cedula_proveedor"] = $row["cedula"];
                    $output["proveedor"] = $row["razon_social"];
                    $output["telefono"] = $row["telefono"];
                    $output["correo"] = $row["correo"];
                    $output["direccion"] = $row["direccion"];
                    $output["fecha"] = $row["fecha"];
                    $output["estado"] = $row["estado"];
                }

                echo json_encode($output);
            } 
            else 
            {
                $errors[]="El proveedor no existe";
            }

            if(isset($errors))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> 
                        <?php
                            foreach($errors as $error) 
                            {
                                echo $error;
                            }
                        ?>
                </div>
                <?php
            } 

        break;

        case "activarydesactivar":

            $datos = $proveedores->get_proveedor_por_id($_POST["id_proveedor"]);

            // var_dump($datos);
            
                if(is_array($datos)==true and count($datos)>0)
                {
                    $proveedores->editar_estado($_POST["id_proveedor"],$_POST["est"]);
                }
        break;

        case "listar":
        
            $datos = $proveedores->get_proveedores();

            $data = Array();

            foreach($datos as $row)
            {
                $sub_array= array();

                $est = '';

                $atrib = "btn btn-success btn-md estado";

                if($row["estado"] == 0)
                {
                    $est = 'INACTIVO';
                    $atrib = "btn btn-warning btn-md estado";
                }
                else
                {
                    if($row["estado"] == 1)
                    {
                        $est = 'ACTIVO';
                    } 
                }

                $sub_array[] = $row["cedula"];
                $sub_array[] = $row["razon_social"];
                $sub_array[] = $row["telefono"];
                $sub_array[] = $row["correo"];
                $sub_array[] = $row["direccion"];
                $sub_array[] = date("d-m-Y", strtotime($row["fecha"]));

                $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_proveedor"].','.$row["estado"].');" name="estado" id="'.$row["id_proveedor"].'" class="'.$atrib.'">'.$est.'</button>';

                $sub_array[] = '<button type="button" onClick="mostrar('.$row["cedula"].');"  id="'.$row["id_proveedor"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';

                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_proveedor"].');"  id="'.$row["id_proveedor"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
            
                $data[]=$sub_array;
            }

            $results= array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);

            echo json_encode($results);

        break;

        case "listar_en_compras":

            $datos=$proveedores->get_proveedores();

            $data= Array();

            foreach($datos as $row)
            {
                $sub_array = array();

                $est = '';
            
                $atrib = "btn btn-success btn-md estado";
                if($row["estado"] == 0)
                {
                    $est = 'INACTIVO';
                    $atrib = "btn btn-warning btn-md estado";
                }
                else
                {
                    if($row["estado"] == 1)
                    {
                        $est = 'ACTIVO';    
                    }	
                }
            
                //$sub_array = array();
                $sub_array[] = $row["cedula"];
                $sub_array[] = $row["razon_social"];
                $sub_array[] = date("d-m-Y", strtotime($row["fecha"]));
                
                $sub_array[] = '<button type="button"  name="estado" id="'.$row["id_proveedor"].'" class="'.$atrib.'">'.$est.'</button>';
                
                $sub_array[] = '<button type="button" onClick="agregar_registro('.$row["id_proveedor"].','.$row["estado"].');" id="'.$row["id_proveedor"].'" class="btn btn-primary btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>';
                
                $data[] = $sub_array;
            }

            $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);

            echo json_encode($results);

        break;

        case "buscar_proveedor";

            $datos=$proveedores->get_proveedor_por_id_estado($_POST["id_proveedor"],$_POST["est"]);

            if(is_array($datos)==true and count($datos)>0)
            {
                foreach($datos as $row)
                {
                    $output["cedula"] = $row["cedula"];
                    $output["razon_social"] = $row["razon_social"];
                    $output["direccion"] = $row["direccion"];
                    $output["fecha"] = $row["fecha"];
                    $output["estado"] = $row["estado"];
                    
                }
            }
            else
            {
                $output["error"]="El proveedor seleccionado está inactivo, intenta con otro";
            }

            echo json_encode($output);

        break;
    }
