<?php

    require_once("../config/conexion.php");

    class Clientes extends Conectar
    {

        // =====================================================================
                            // SELECCIONAR CLIENTES 
        // =====================================================================
        public function get_clientes()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM clientes";

            $sql=$conectar->prepare($sql);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }















        
        // =====================================================================
                        // // GUARDAR CATEGORIA
        // =====================================================================
        public function registrar_cliente($cedula,$nombre,$apellido,$telefono,$correo,$direccion,$estado,$id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "INSERT INTO clientes VALUES(null,?,?,?,?,?,?,NOW(),?,?);";

            echo $sql;

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $_POST["cedula"]);
            $sql->bindValue(2, $_POST["nombre"]);
            $sql->bindValue(3, $_POST["apellido"]);
            $sql->bindValue(4, $_POST["telefono"]);
            $sql->bindValue(5, $_POST["email"]);
            $sql->bindValue(6, $_POST["direccion"]);
            $sql->bindValue(7, $_POST["estado"]);
            $sql->bindValue(8, $_POST["id_usuario"]);
            $sql->execute();

            // print_r($sql);
        }


















        // =====================================================================
                            // SELECCIONAR CLIENTES POR ID
        // =====================================================================
        public function get_cliente_por_id($id_cliente)
        {
            $conectar= parent::conexion();

            $sql="SELECT * FROM clientes WHERE id_cliente=?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $id_cliente);
            $sql->execute();

            return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        } 











        // =====================================================================
                    // RECUPERAR CATEGORIA POR CEDULA PARA MODIFICAR
        // =====================================================================
        public function get_cliente_por_cedula($cedula)
        {
            $conectar= parent::conexion();
            parent::set_names();

            $sql="SELECT * FROM clientes WHERE cedula_cliente=?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $cedula);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
























        // =====================================================================
                                // // EDITAR CLIENTE
        // =====================================================================
        public function editar_cliente($cedula,$nombre,$apellido,$telefono,$correo,$direccion,$estado,$id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql="UPDATE clientes SET 
                cedula_cliente=?,
                nombre_cliente=?,
                apellido_cliente=?,
                telefono_cliente=?,
                correo_cliente=?,
                direccion_cliente=?,
                estado=?,
                id_usuario=?
            WHERE 
                cedula_cliente=?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $_POST["cedula"]);
            $sql->bindValue(2, $_POST["nombre"]);
            $sql->bindValue(3, $_POST["apellido"]);
            $sql->bindValue(4, $_POST["telefono"]);
            $sql->bindValue(5, $_POST["email"]);
            $sql->bindValue(6, $_POST["direccion"]);
            $sql->bindValue(7, $_POST["estado"]);
            $sql->bindValue(8, $_POST["id_usuario"]);
            $sql->bindValue(9, $_POST["cedula_cliente"]);
            $sql->execute();

        }





















        // =====================================================================
                        // SELECCIONAR CLIENTES POR ESTADO ACTIVO
        // =====================================================================
        public function get_cliente_por_id_estado($id_cliente,$estado)
        {
            $conectar= parent::conexion();

            $estado=1;

            $sql="SELECT * FROM clientes WHERE id_cliente=? AND estado=?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $id_cliente);
            $sql->bindValue(2, $estado);
            $sql->execute();

            return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }















        // =====================================================================
                                // EDITAR ESTADO CLIENTE
        // =====================================================================
        public function editar_estado($id_cliente,$estado)
        {
            $conectar=parent::conexion();
            
            if($_POST["est"]=="0")
            {
                $estado=1;
            } 
            else 
            {
                $estado=0;
            }

            $sql="UPDATE clientes SET estado=? WHERE id_cliente=?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1,$estado);
            $sql->bindValue(2,$id_cliente);

            $sql->execute();
        }














        // =====================================================================
                // VALIDAR DUPLICIDAD DE CATEGORIA POR CI NOMBRE Y CORREO
        // =====================================================================
        public function get_datos_cliente($cedula,$cliente,$correo)
        {
            $conectar=parent::conexion();

            $sql= "SELECT * FROM clientes WHERE cedula_cliente=? OR nombre_cliente=? OR correo_cliente=?;";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $cedula);
            $sql->bindValue(2, $cliente);
            $sql->bindValue(3, $correo);
            $sql->execute();

            //print_r($sql); exit();

            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

    }

