<?php

    session_start();

    class Conectar
    {
        protected $dbh;

        public function conexion()
        {
            try
            {
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=dbproyecto","root","");
    
                return $conectar;  
            }
            catch(Exception $e)
            {
                print "!Error:". $e->getMessage()."<br>";
                die();
            }

        }


        public function set_names()
        {
            return $this->dbh->query("SET NAMES UTF-8");
        }
        

        public function ruta()
        {
            return "http://localhost/eiter/";
        }

    }
    



