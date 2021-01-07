<?php

    require_once("../config/conexion.php");

    require_once("../modelos/usuarios.modelo.php");

    $usuarios = new Usuarios();

    $id_usuario = isset($_POST["id_usuario"]);
    $nombre=isset($_POST["nombre"]);
    $apellido=isset($_POST["apellido"]);
    $cedula=isset($_POST["cedula"]);
    $telefono=isset($_POST["telefono"]);
    $email=isset($_POST["email"]);
    $direccion=isset($_POST["direccion"]); 
    $cargo=isset($_POST["cargo"]);
    $usuario=isset($_POST["usuario"]);
    $password1=isset($_POST["password1"]);
    $password2=isset($_POST["password2"]);
    //este es el que se envia del formulario
    $estado=isset($_POST["estado"]);


    switch($_GET["op"])
    {
        case "guardaryeditar":

            $datos = $usuarios->get_cedula_correo_del_usuario($_POST["cedula"],$_POST["email"]);
                
            if($password1 == $password2)
            {
                if(empty($_POST["id_usuario"]))
                {

                    if(is_array($datos)==true and count($datos) == 0)
                    {
                        $usuarios->registrar_usuario($nombre,$apellido,$cedula,$telefono,$email,$direccion,$cargo,$usuario,$password1,$password2,$estado);

                        $messages[]="El usuario se registró correctamente";
                    } 
                    else 
                    {
                        $errors[]="La cédula o el correo ya existe";
                    }
                }
                else 
                {
                    $usuarios->editar_usuario($id_usuario,$nombre,$apellido,$cedula,$telefono,$email,$direccion,$cargo,$usuario,$password1,$password2,$estado);

                    $messages[]="El usuario se editó correctamente";
                }
            } 
            else
            {
                $errors[]="El password no coincide";
            }

            if(isset($messages))
            {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>¡Bien hecho!</strong>
                    <?php
                        foreach($messages as $message) {
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
                                foreach($errors as $error) {
                                        echo $error;
                                    }
                                ?>
                    </div>
                <?php

            }

        break;

        case "mostrar":

            $datos = $usuarios->getUsuarioPorId($_POST["id_usuario"]);
            // var_dump($datos);

            if(is_array($datos)==true and count($datos)>0)
            {

                foreach($datos as $row)
                {  
                    $output["cedula"] = $row["cedula"];
                    $output["nombre"] = $row["nombres"];
                    $output["apellido"] = $row["apellidos"];
                    $output["cargo"] = $row["cargo"];
                    $output["usuario"] = $row["usuario"];
                    $output["password1"] = $row["password"];
                    $output["password2"] = $row["password2"];
                    $output["telefono"] = $row["telefono"];
                    $output["correo"] = $row["correo"];
                    $output["direccion"] = $row["direccion"];
                    $output["estado"] = $row["estado"];
                }

                echo json_encode($output);
            } 
            else 
            {
                $errors[]="El usuario no existe";
            }

            if(isset($errors))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> 
                        <?php
                            foreach($errors as $error) {
                                    echo $error;
                                }
                            ?>
                </div>
                <?php
            }

           //fin de mensaje de error

        break;

        case "activarydesactivar":

            $datos = $usuarios->getUsuarioPorId($_POST["id_usuario"]);

            // var_dump($datos);
            
                if(is_array($datos)==true and count($datos)>0)
                {
                    $usuarios->editar_estado_usuario($_POST["id_usuario"],$_POST["est"]);
                }
        break;

        case "listar":
        
            $datos = $usuarios->getUsuarios();

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

                if($row["cargo"]==1)
                {
                    $cargo="ADMINISTRADOR";
                } 
                else
                {
                    if($row["cargo"]==0)
                    {
                        $cargo="EMPLEADO";
                    }
                }

                $sub_array[]= $row["cedula"];
                $sub_array[] = $row["nombres"];
                $sub_array[] = $row["apellidos"];
                $sub_array[] = $row["usuario"];
                $sub_array[] = $cargo;
                $sub_array[] = $row["telefono"];
                $sub_array[] = $row["correo"];
                $sub_array[] = $row["direccion"];
                $sub_array[] = date("d-m-Y",strtotime($row["fecha_ingreso"]));

                $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_usuario"].','.$row["estado"].');" name="estado" id="'.$row["id_usuario"].'" class="'.$atrib.'">'.$est.'</button>';

                $sub_array[] = '<button type="button" onClick="mostrar('.$row["id_usuario"].');"  id="'.$row["id_usuario"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';

                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_usuario"].');"  id="'.$row["id_usuario"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
            
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


