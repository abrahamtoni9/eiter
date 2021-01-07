<?php

    require_once("../config/conexion.php");

    class Perfiles extends Conectar
    {

        // =====================================================================
                    // SELECCIONAR USUARIO POR ID
        // =====================================================================
        public function getUsuarioPorId($id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $id_usuario);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }












        // =====================================================================
                                // MODIFICAR PERFIL DE USUARIO
        // =====================================================================
        public function editar_perfil($id_usuario, $nombre, $apellido, $cedula, $telefono, $email, $direccion, $usuario, $password1, $password2)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, cedula = ?, telefono = ?, correo = ?, direccion = ?, usuario = ?, password = ?, password2 = ? WHERE id_usuario = ? ";

            echo $sql;

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $_POST['nombre_perfil']);
            $sql->bindValue(2, $_POST['apellido_perfil']);
            $sql->bindValue(3, $_POST['cedula_perfil']);
            $sql->bindValue(4, $_POST['telefono_perfil']);
            $sql->bindValue(5, $_POST['email_perfil']);
            $sql->bindValue(6, $_POST['direccion_perfil']);
            $sql->bindValue(7, $_POST['usuario_perfil']);
            $sql->bindValue(8, $_POST['password1_perfil']);
            $sql->bindValue(9, $_POST['password2_perfil']);
            $sql->bindValue(10, $_POST['id_usuario_perfil']);

            $sql->execute();

            // echo $sql;

            // print_r($_POST);
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

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        }


        
    }

