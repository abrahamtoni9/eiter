<?php

    require_once("../config/conexion.php");

    require_once("../modelos/categorias.modelo.php");

    $categorias = new Categorias();

    $id_categoria = isset($_POST["id_categoria"]);
    $id_usuario = isset($_POST["id_usuario"]);
    $categoria = isset($_POST["categoria"]);
    $estado = isset($_POST["estado"]);

    switch($_GET["op"])
    {
        case "guardaryeditar":

            // var_dump($_POST);
            // die();

            $datos = $categorias->get_nombre_categoria($_POST["categoria"]);

            // var_dump($datos);
            // exit();

            if(empty($_POST["id_categoria"]))
            {
                // var_dump($datos);
                // // exit();
                // die();
                if(is_array($datos)==true and count($datos) == 0)
                {
                    // var_dump($datos);
                    // exit();
                    $categorias->registrar_categoria($categoria,$estado,$id_usuario);

                    $messages[]="La categoria se registró correctamente";
                } 
                else 
                {
                    $errors[]="La categoria ya existe";
                }
            }
            else 
            {
                $categorias->editar_categoria($id_categoria,$categoria,$estado,$id_usuario);

                $messages[]="La categoria se editó correctamente";
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

            $datos = $categorias->get_categoria_por_id($_POST["id_categoria"]);
            // var_dump($datos);

            if(is_array($datos) == true and count($datos) > 0)
            {

                foreach($datos as $row)
                {  
                    $output["categoria"] = $row["categoria"];
                    $output["estado"] = $row["estado"];
                    $output["id_usuario"] = $row["id_usuario"];
                }

                echo json_encode($output);
            } 
            else 
            {
                $errors[]="La categoria no existe";
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

           //fin de mensaje de error

        break;

        case "activarydesactivar":

            $datos = $categorias->get_categoria_por_id($_POST["id_categoria"]);

            // var_dump($datos);
            
                if(is_array($datos)==true and count($datos)>0)
                {
                    $categorias->editar_estado($_POST["id_categoria"],$_POST["est"]);
                }
        break;

        case "listar":
        
            $datos = $categorias->get_categorias();

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

                $sub_array[]= $row["categoria"];

                $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_categoria"].','.$row["estado"].');" name="estado" id="'.$row["id_categoria"].'" class="'.$atrib.'">'.$est.'</button>';

                $sub_array[] = '<button type="button" onClick="mostrar('.$row["id_categoria"].');"  id="'.$row["id_categoria"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';

                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_categoria"].');"  id="'.$row["id_categoria"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
            
                $data[]=$sub_array;

            }

            $results= array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);

            echo json_encode($results);

        break;
    }
