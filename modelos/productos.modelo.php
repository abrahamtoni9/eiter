<?php

    require_once("../config/conexion.php");

    class Productos extends Conectar
    {

        // =====================================================================
                            // SELECCIONAR PRODUCTOS 
        // =====================================================================
        public function get_productos()
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql= "SELECT p.id_producto,p.id_categoria,p.producto,p.presentacion,p.unidad, p.moneda, p.precio_compra, p.precio_venta, p.stock, p.estado, p.imagen, p.fecha_vencimiento as fecha_vencimiento,c.id_categoria, c.categoria as categoria

            FROM producto p 

            INNER JOIN categoria c ON p.id_categoria=c.id_categoria";

            $sql=$conectar->prepare($sql);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }












        // =====================================================================
                    // PONER LAS IMAGENES EN LA RUTA VISTAS/UPLOAD
        // =====================================================================
        public function upload_image() 
        {
            if(isset($_FILES["producto_imagen"]))
            {
                $extension = explode('.', $_FILES['producto_imagen']['name']);
                $new_name = rand() . '.' . $extension[1];
                $destination = '../vistas/upload/' . $new_name;
                move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $destination);
                return $new_name;
            }
        }














        // =====================================================================
                    // // GUARDAR PRODUCTO
        // =====================================================================

        public function registrar_producto($id_categoria,$producto,$presentacion,$unidad,$moneda,$precio_compra,$precio_venta,$stock,$estado,$imagen,$id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $stock = "";

            if($stock=="")
            {            
                $stocker=0;
            } 
            else 
            {
                $stocker = $_POST["stock"];
            }

            require_once("productos.modelo.php");

            $imagen_producto = new Productos();

            $image = '';
            if($_FILES["producto_imagen"]["name"] != '')
            {
                $image = $imagen_producto->upload_image();
            }

            //fecha 

            $date = $_POST["datepicker"];
            $date_inicial = str_replace('/', '-', $date);
            $fecha = date("Y-m-d",strtotime($date_inicial));

            $sql="INSERT INTO producto
            VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?);";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $_POST["categoria"]);
            $sql->bindValue(2, $_POST["producto"]);
            $sql->bindValue(3, $_POST["presentacion"]);
            $sql->bindValue(4, $_POST["unidad"]);
            $sql->bindValue(5, $_POST["moneda"]);
            $sql->bindValue(6, $_POST["precio_compra"]);
            $sql->bindValue(7, $_POST["precio_venta"]);
            $sql->bindValue(8, $stocker);
            $sql->bindValue(9, $_POST["estado"]);
            $sql->bindValue(10, $image);
            $sql->bindValue(11, $fecha);
            $sql->bindValue(12, $_POST["id_usuario"]);
            $sql->execute();
        }
    
    












        // =====================================================================
                            // RECUPERAR CATEGORIA POR ID
        // =====================================================================
        public function get_producto_por_id($id_producto)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM producto WHERE id_producto = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $id_producto);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }













        // =====================================================================
                        // // EDITAR PRODUCTO
        // =====================================================================
        public function editar_producto($id_producto,$id_categoria,$producto,$presentacion,$unidad,$moneda,$precio_compra,$precio_venta,$stock,$estado,$imagen,$id_usuario)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $stock = "";

            if($stock=="")
            {  
                $stocker=0;
            }
            else 
            {
                $stocker = $_POST["stock"];
            }

            require_once("productos.modelo.php");
            
            $imagen_producto = new Productos();

            $imagen = '';

            if($_FILES["producto_imagen"]["name"] != '')
            {
                $imagen = $imagen_producto->upload_image();
            }
            else
            {    
                $imagen = $_POST["hidden_producto_imagen"];
            }

            $fecha = $_POST["datepicker"];
            $date_inicial = str_replace('/', '-', $fecha);
            $fecha = date("Y-m-d",strtotime($date_inicial));

            $sql="UPDATE producto SET 
                    id_categoria=?,
                    producto=?,
                    presentacion=?,
                    unidad=?,
                    moneda=?,
                    precio_compra=?,
                    precio_venta=?,
                    stock=?,
                    estado=?,
                    imagen=?,
                    fecha_vencimiento=?
                    id_usuario=?
                    WHERE
                    id_producto=?
            ";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $_POST["categoria"]);
            $sql->bindValue(2, $_POST["producto"]);
            $sql->bindValue(3, $_POST["presentacion"]);
            $sql->bindValue(4, $_POST["unidad"]);
            $sql->bindValue(5, $_POST["moneda"]);
            $sql->bindValue(6, $_POST["precio_compra"]);
            $sql->bindValue(7, $_POST["precio_venta"]);
            $sql->bindValue(8, $stocker);
            $sql->bindValue(9, $_POST["estado"]);
            $sql->bindValue(10, $imagen);
            $sql->bindValue(11, $fecha);
            $sql->bindValue(12, $_POST["id_usuario"]);
            $sql->bindValue(13, $_POST["id_producto"]);

            $sql->execute();
        }













        // =====================================================================
                                // EDITAR ESTADO PRODUCTO
        // =====================================================================
        public function editar_estado($id_producto, $estado)
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

            $sql = "UPDATE producto  SET  estado = ? WHERE id_producto = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $id_producto);

            $sql->execute();
        }














        // =====================================================================
                        // VALIDAR DUPLICIDAD DE PRODUCTO
        // =====================================================================
        public function get_nombre_producto($producto)
        {
            $conectar=parent::conexion();
            parent::set_names();

            $sql = "SELECT * FROM producto WHERE producto = ? ";

            $sql=$conectar->prepare($sql);
            
            $sql->bindValue(1, $producto);

            $sql->execute();

            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }














        // =====================================================================
                // VALIDAR DUPLICIDAD DE PRODUCTO POR ID Y POR ESTADO
        // =====================================================================

        public function get_producto_por_id_estado($id_producto,$estado)
        {
            $conectar= parent::conexion();
            parent::set_names();

            //declaramos que el estado esté activo, igual a 1
            $estado=1;

            $sql="select * from producto where id_producto=? and estado=?";

            $sql=$conectar->prepare($sql);

            $sql->bindValue(1, $id_producto);
            $sql->bindValue(2, $estado);
            $sql->execute();

            return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }






















        // =====================================================================
                            // SELECCIONAR PRODUCTOS 
        // =====================================================================
        public function get_productos_en_ventas()
        {
            $conectar= parent::conexion();

            $sql= "SELECT p.id_producto,p.id_categoria,p.producto,p.presentacion,p.unidad, p.moneda, p.precio_compra, p.precio_venta, p.stock, p.estado, p.imagen, p.fecha_vencimiento AS fecha_vencimiento,c.id_categoria, c.categoria AS categoria
            FROM 
                producto p     
            INNER JOIN 
                categoria c ON p.id_categoria=c.id_categoria
            WHERE
                p.stock > 0 AND p.estado='1'";

            $sql=$conectar->prepare($sql);

            $sql->execute();

            return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        
    }

