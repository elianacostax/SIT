<?php
    class Categoria extends Conectar{
        //Consulta a la BD de las categorias.
        public function get_categoria(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_categoria WHERE cat_estado=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }
    }
?>