<?php

    require_once("../config/conexion.php");

    require_once("../modelos/perfiles.modelo.php");

    $perfil = new Perfiles();

    $id_usuario_perfil = isset($_POST["id_usuario_perfil"]);
    $nombre_perfil=isset($_POST["nombre_perfil"]);
    $apellido_perfil=isset($_POST["apellido_perfil"]);
    $cedula_perfil=isset($_POST["cedula_perfil"]);
    $telefono_perfil=isset($_POST["telefono_perfil"]);
    $email_perfil=isset($_POST["email_perfil"]);
    $direccion_perfil=isset($_POST["direccion_perfil"]);
    $usuario_perfil=isset($_POST["usuario_perfil"]);
    $password1_perfil=isset($_POST["password1_perfil"]);
    $password2_perfil=isset($_POST["password2_perfil"]);

    switch($_GET["op"])
    {
        case "mostrar_perfil":

            $datos = $perfil->getUsuarioPorId($_POST["id_usuario"]);
            // var_dump($datos);
            // die();

            if(is_array($datos)==true and count($datos)>0)
            {
                foreach($datos as $row)
                {  
                    $output["cedula"] = $row["cedula"];
                    $output["nombre"] = $row["nombres"];
                    $output["apellido"] = $row["apellidos"];
                    $output["usuario"] = $row["usuario"];
                    $output["password1"] = $row["password"];
                    $output["password2"] = $row["password2"];
                    $output["telefono"] = $row["telefono"];
                    $output["correo"] = $row["correo"];
                    $output["direccion"] = $row["direccion"];
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

        case "editar_perfil":

            $datos = $perfil->get_cedula_correo_del_usuario($_POST["cedula_perfil"],$_POST["email_perfil"]);
            // var_dump($datos);
            // die();
                
            if($_POST["password1_perfil"] == $_POST["password2_perfil"])
            {
                if(is_array($datos) == true and count($datos) > 0)
                {
                    //var_dump($datos);
                    // die();
                    $perfil->editar_perfil($id_usuario_perfil, $nombre_perfil,$apellido_perfil,$cedula_perfil,$telefono_perfil,$email_perfil,$direccion_perfil,$usuario_perfil,$password1_perfil,$password2_perfil);

                    // var_dump($datos);
                    // die();

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
    }
