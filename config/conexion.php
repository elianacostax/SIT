<?php
    session_start();
//conexion a la base de datos.
    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                //Local
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=sit","root","");
                
				return $conectar;
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }
    //establecer metodo
        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

        //Definimos la ruta donde se encuentra el proyecto.
        public static function ruta(){
            //Local
			return "http://localhost:90/proyecto/";
		}

    }
?>