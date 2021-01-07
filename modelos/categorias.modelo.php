<?php

    require_once("../config/conexion.php");

    class Categorias extends Conectar
    {

        // =====================================================================
                            // SELECCIONAR CATEGORIA 
        // =====================================================================
        public function get_categorias()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM categoria";

            $sql=$conectar->prepare($sql);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }












        // =====================================================================
                            // RECUPERAR CATEGORIA POR ID
        // =====================================================================
        public function get_categoria_por_id($id_categoria)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM categoria WHERE id_categoria = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $id_categoria);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }












        // =====================================================================
                        // // GUARDAR CATEGORIA
        // =====================================================================
        public function registrar_categoria($categoria, $estado, $id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "INSERT INTO categoria VALUES (NULL,?,?,?)";

            echo $sql;

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $_POST['categoria']);
            $sql->bindValue(2, $_POST['estado']);
            $sql->bindValue(3, $_POST['id_usuario']);

            $sql->execute();

            // print_r($sql);
        }












        // =====================================================================
                        // // EDITAR CATEGORIA
        // =====================================================================
        public function editar_categoria($id_categoria, $categoria, $estado, $id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "UPDATE categoria SET categoria = ?, estado = ?, id_usuario = ? WHERE id_categoria = ? ";

            // echo $sql;
            $sql=$conectar->prepare($sql);
            
            // echo $sql;
            $sql->bindValue(1, $_POST['categoria']);
            $sql->bindValue(2, $_POST['estado']);
            $sql->bindValue(3, $_POST['id_usuario']);
            $sql->bindValue(4, $_POST['id_categoria']);

            $sql->execute();

            // echo $sql;
        }













        // =====================================================================
                                // EDITAR ESTADO CATEGORIA
        // =====================================================================
        public function editar_estado($id_categoria, $estado)
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

            $sql = "UPDATE categoria  SET  estado = ? WHERE id_categoria = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $id_categoria);

            $sql->execute();
        }














        // =====================================================================
                        // VALIDAR DUPLICIDAD DE CATEGORIA
        // =====================================================================
        public function get_nombre_categoria($categoria)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM categoria WHERE categoria = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $categoria);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }


        
    }

