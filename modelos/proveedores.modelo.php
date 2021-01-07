<?php

    require_once("../config/conexion.php");

    class Proveedores extends Conectar
    {

        // =====================================================================
                            // SELECCIONAR PROVEEDORES 
        // =====================================================================
        public function get_proveedores()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM proveedor";

            $sql=$conectar->prepare($sql);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }












        // =====================================================================
                            // RECUPERAR PROVEEDOR POR ID
        // =====================================================================
        public function get_proveedor_por_id($id_proveedor)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM proveedor WHERE id_proveedor = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $id_proveedor);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }












        // =====================================================================
                        // // GUARDAR PROVEEDOR
        // =====================================================================
        public function registrar_proveedor($cedula,$proveedor,$telefono,$correo,$direccion,$estado,$id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "INSERT INTO proveedor VALUES (NULL,?,?,?,?,?,NOW(),?,?);";

            // echo $sql;

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $_POST["cedula"]);
            $sql->bindValue(2, $_POST["razon"]);
            $sql->bindValue(3, $_POST["telefono"]);
            $sql->bindValue(4, $_POST["email"]);
            $sql->bindValue(5, $_POST["direccion"]);
            $sql->bindValue(6, $_POST["estado"]);
            $sql->bindValue(7, $_POST["id_usuario"]);

            $sql->execute();

            // print_r($sql);
        }












        // =====================================================================
                        // // EDITAR PROVEEDOR
        // =====================================================================
        public function editar_proveedor($cedula,$proveedor,$telefono,$correo,$direccion,$estado,$id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "UPDATE proveedor SET  cedula=?, razon_social=?, telefono=?, correo=?, direccion=?, estado=?, id_usuario=? WHERE cedula=? ";

            // echo $sql;
            $sql=$conectar->prepare($sql);
            
            // echo $sql;
            $sql->bindValue(1, $_POST["cedula"]);
            $sql->bindValue(2, $_POST["razon"]);
            $sql->bindValue(3, $_POST["telefono"]);
            $sql->bindValue(4, $_POST["email"]);
            $sql->bindValue(5, $_POST["direccion"]);
            $sql->bindValue(6, $_POST["estado"]);
            $sql->bindValue(7, $_POST["id_usuario"]);
            $sql->bindValue(8, $_POST["cedula_proveedor"]);

            $sql->execute();

            // echo $sql;
        }













        // =====================================================================
                                // EDITAR ESTADO PROVEEDOR
        // =====================================================================
        public function editar_estado($id_proveedor, $estado)
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

            $sql = "UPDATE proveedor  SET  estado = ? WHERE id_proveedor = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $id_proveedor);

            $sql->execute();
        }














        // =====================================================================
                        // VALIDAR DUPLICIDAD DE PROVEEDOR
        // =====================================================================
        public function get_datos_proveedor($cedula, $proveedor, $correo)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM proveedor WHERE cedula = ? OR razon_social = ? OR correo = ?";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $cedula);
            $sql->bindValue(2, $proveedor);
            $sql->bindValue(3, $correo);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }














        // =====================================================================
                        // VALIDAR DUPLICIDAD DE PROVEEDOR
        // =====================================================================
        public function get_proveedor_por_cedula($cedula)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM proveedor WHERE cedula = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $cedula);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        













        // =====================================================================
                // VALIDAR DUPLICIDAD DE PROVEEDOR POR ID Y POR ESTADO
        // =====================================================================
        public function get_proveedor_por_id_estado($proveedor, $estado)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $estado = 1;

            $sql = "SELECT * FROM proveedor WHERE id_proveedor = ? OR estado = ?";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $proveedor);
            $sql->bindValue(2, $estado);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }


        
    }

