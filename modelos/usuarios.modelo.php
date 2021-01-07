<?php

    //conexion a la base de datos 
    require_once("../config/conexion.php");

    class Usuarios extends Conectar
    {
        // =====================================================================
                            // SELECCIONAR TODOS LOS USUARIOS
        // =====================================================================
        public function getUsuarios()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM usuarios";

            $sql=$conectar->prepare($sql);
            $sql->execute();

            return $resultado = $sql->fetchAll();
        }




        // =====================================================================
                                // INSERTAR USUARIO
        // =====================================================================
        public function registrar_usuario($nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $estado)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "INSERT INTO usuarios VALUES(null,?,?,?,?,?,?,?,?,?,?,now(),?)";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $_POST['nombre']);
            $sql->bindValue(2, $_POST['apellido']);
            $sql->bindValue(3, $_POST['cedula']);
            $sql->bindValue(4, $_POST['telefono']);
            $sql->bindValue(5, $_POST['email']);
            $sql->bindValue(6, $_POST['direccion']);
            $sql->bindValue(7, $_POST['cargo']);
            $sql->bindValue(8, $_POST['usuario']);
            $sql->bindValue(9, $_POST['password1']);
            $sql->bindValue(10, $_POST['password2']);
            $sql->bindValue(11, $_POST['estado']);

            $sql->execute();


        }






        // =====================================================================
                                // MODIFICAR USUARIO
        // =====================================================================
        public function editar_usuario($id_usuario, $nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $estado)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, cedula = ?, telefono = ?, correo = ?, direccion = ?, cargo = ?, usuario = ?, password = ?, password2 = ?, estado = ? WHERE id_usuario = ? ";

            // echo $sql;

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $_POST['nombre']);
            $sql->bindValue(2, $_POST['apellido']);
            $sql->bindValue(3, $_POST['cedula']);
            $sql->bindValue(4, $_POST['telefono']);
            $sql->bindValue(5, $_POST['email']);
            $sql->bindValue(6, $_POST['direccion']);
            $sql->bindValue(7, $_POST['cargo']);
            $sql->bindValue(8, $_POST['usuario']);
            $sql->bindValue(9, $_POST['password1']);
            $sql->bindValue(10, $_POST['password2']);
            $sql->bindValue(11, $_POST['estado']);
            $sql->bindValue(12, $_POST['id_usuario']);

            $sql->execute();

            // echo $sql;

            // print_r($_POST);
        }









         // =====================================================================
                    // SELECCIONAR TODOS LOS USUARIOS POR ID
        // =====================================================================
        public function getUsuarioPorId($id_usuario)
        {
            $conectar=parent::conexion();
            // parent::set_names();

            $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $_POST['id_usuario']);

            $sql->execute();

            return $resultado = $sql->fetchAll();
        }








        // =====================================================================
                        // VALIDAR CORREO Y CI DEL USUARIO
        // =====================================================================
        public function get_cedula_correo_del_usuario($cedula, $email)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM usuarios WHERE cedula = ? or correo = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $cedula);
            $sql->bindValue(2, $email);

            $sql->execute();

            return $resultado = $sql->fetchAll();

        }








        // =====================================================================
                                // EDITAR ESTADO USUARIO
        // =====================================================================
        public function editar_estado_usuario($id_usuario, $estado)
        {
            $conectar=parent::conexion();
            parent::set_names();

            if($_POST['est'] == '0')
            {
                $estado = 1;
            }
            else
            {
                $estado = 0;
                
            }

            $sql = "UPDATE usuarios  SET  estado = ? WHERE id_usuario = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $id_usuario);

            $sql->execute();
        }















        // =====================================================================    
                                // LOGIN
        // =====================================================================

        public function login()
		{
            $conectar=parent::conexion();
            parent::set_names();

            if(isset($_POST["enviar"]))
            {
                //INICIO DE VALIDACIONES
                $password = $_POST["password"];

                $correo = $_POST["correo"];

                $estado = "1";

                if(empty($correo) and empty($password))
                {
                    header("Location:".Conectar::ruta()."vistas/index.php?m=2");
                    exit();
                }
                // else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $password)) //pass Qw/*12345678
                // {
                //     header("Location:".Conectar::ruta()."vistas/index.php?m=1");
                //     exit();
                // }   
                else 
                {
                    $sql= "SELECT * FROM usuarios WHERE correo=? AND password=? AND estado=?";

                    $sql=$conectar->prepare($sql);

                    $sql->bindValue(1, $correo);
                    $sql->bindValue(2, $password);
                    $sql->bindValue(3, $estado);
                    $sql->execute();
                    $resultado = $sql->fetch();

                    // var_dump($resultado);
                    // die();

                    //si existe el registro entonces se conecta en session
                    if(is_array($resultado) and count($resultado)>0)
                    {
                        // var_dump($resultado);
                        // die();

                        /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
                        $_SESSION["id_usuario"] = $resultado["id_usuario"];
                        $_SESSION["correo"] = $resultado["correo"];
                        $_SESSION["cedula"] = $resultado["cedula"];
                        $_SESSION["nombre"] = $resultado["nombres"];

                        // var_dump($_SESSION["correo"]);
                        // die();

                        header("Location:".Conectar::ruta()."vistas/home.php");

                        exit();
                    } 
                    else 
                    {
                        //si no existe el registro entonces le aparece un mensaje
                        header("Location:".Conectar::ruta()."vistas/index.php?m=1");
                        exit();
                    } 

                }//cierre del else

            }//condicion enviar
        }



        
    }

